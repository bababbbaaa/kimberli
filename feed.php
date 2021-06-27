<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once('api/Okay.php');
$okay = new Okay();

header("Content-type: text/xml; charset=UTF-8");
print (pack('CCC', 0xef, 0xbb, 0xbf));
// Заголовок
print
"<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE yml_catalog SYSTEM 'shops.dtd'>
<yml_catalog date='".date('Y-m-d H:i')."'>
<shop>
<name>".$okay->settings->site_name."</name>
<company>".$okay->settings->site_name."</company>
<url>".$okay->config->root_url."</url>
";

// Валюты
$currencies = $okay->money->get_currencies(array('enabled'=>1));
$main_currency = reset($currencies);
print "<currencies>
";
foreach($currencies as $c)
if($c->enabled)
print "<currency id='".$c->code."' rate='".$c->rate_to/$c->rate_from*$main_currency->rate_from/$main_currency->rate_to."'/>
";
print "</currencies>
";

$cat_id = [
    17 => ['id'=> 724014, 'name' => 'Золоті жіночі каблучки'],
    22 => ['id'=> 724109, 'name' => 'Золоті сережки з англійським замком'],
   // 38 => ['id'=> 724119, 'name' => 'Сережки-гвіздки (пусети)'],
    29 => ['id'=> 724049, 'name' => 'Жіночі золоті кулони'],
    //17 => ['id'=> 724024, 'name' => 'Каблучки солітери (одинарники)'],
    28 => ['id'=> 724074, 'name' => 'Золоті хрестики'],
    23 => ['id'=> 723979, 'name' => 'Золоті запонки'],
    //27 => ['id'=> 724029, 'name' => 'Чоловічі золоті каблучки'],
    //36 => ['id'=> 4657908, 'name' => 'Ланцюжки біжутерія'],
    //30 => ['id'=> 724034, 'name' => 'Золоті обручки'],
   // 19 => ['id'=> 4657902, 'name' => 'Браслети біжутерія'],
   // 21 => ['id'=> 753624, 'name' => 'Жіночі кольє'],
   // 40 => ['id'=> 723959, 'name' => 'Золоті брошки'],
   // 34 => ['id'=> '', 'name' => ''],
   // 29 => ['id'=> '', 'name' => ''],
    ];



$stock_filter = $okay->settings->yandex_export_not_in_stock ? '' : ' AND v.stock >0 ';
$price_filter = $okay->settings->yandex_no_export_without_price ? ' AND v.price >0 ' : '';

// Товары
$okay->db->query("SET SQL_BIG_SELECTS=1");
// Товары
$okay->db->query("SELECT 
        p.description, 
        b.name as vendor, 
        v.stock, 
        v.compare_price, 
        v.sku, 
        v.price, 
        v.id as variant_id, 
        p.name as product_name, 
        v.name as variant_name, 
        v.position as variant_position, 
        p.id as product_id, 
        v.url, 
        p.annotation, 
        p.xml_category_id as category_id, 
        c.rate_from, 
        c.rate_to, 
        v.currency_id,
        cx.name as category_name
    FROM __variants v 
    LEFT JOIN __products p ON v.product_id=p.id
    left join __currencies as c on(c.id=v.currency_id)
    LEFT JOIN __brands b on (b.id = p.brand_id)
    inner JOIN __category_xml cx on cx.category_id = p.xml_category_id
    WHERE 
        1 
        AND p.visible 
        AND p.xml_category_id
        $stock_filter
        $price_filter 
    GROUP BY v.id 
    ORDER BY p.id, v.position ");
print "<offers>
";

$currency_code = reset($currencies)->code;
$prev_product_id = null;

$products = $okay->db->results();
$p_ids = $p_var = array();
$categories = array();
foreach ($products as $p) {
    if (!in_array($p->product_id, $p_ids)) {
        $p_ids[] = $p->product_id;
    }
	$p_var[] = $p->sku;
    
    $categories[$p->category_id] = $p->category_name; 
}

// Категории
print "<categories>
";
foreach($categories as $k=>$c)
{
print "<category id='$k'";
//if($c->parent_id>0)
   // print " parentId='$c->parent_id'";
print ">".htmlspecialchars($c)."</category>
";
}
print "</categories>
";


$p_images = array();
foreach($okay->products->get_images(array('product_id' => $p_ids)) as $image) {
    $p_images[$image->product_id][] = $image->filename;
}

// Получаем список свойств для фида
$features_values = array();
foreach ($okay->features_values->get_features_values(array('product_id'=>$p_ids, 'yandex'=>1)) as $fv) {
    $features_values[$fv->id] = $fv;
}

// Получаем связь товара и значения свойства
$products_values = array();
foreach ($okay->features_values->get_product_value_id($p_ids) as $pv) {
    $products_values[$pv->product_id][] = $pv->value_id;
}

/**/
$insertions = [];

foreach ($okay->insertions->get_insertions_shtr(array('shtr' => $p_var)) as $in){
    $insertions[$in->product_id][] =  $in->title . ' ' . $in->name;
}


foreach($products as $p) {
    $variant_url = '';
    //if ($prev_product_id === $p->product_id) {
      //  $variant_url = '?variant='.$p->variant_id;
   // }
    $prev_product_id = $p->product_id;
    
    //если задана валюта варианта - переводим к основной
    if ($p->currency_id > 0) {
        if ($p->rate_from != $p->rate_to) {
            $p->price = $p->price*$p->rate_to/$p->rate_from;
            $p->compare_price = $p->compare_price*$p->rate_to/$p->rate_from;
        }
        $price = round($p->price, 2);
        $old_price = round($p->compare_price, 2);
    } else {
        $price = round($okay->money->convert($p->price, $main_currency->id, false),2);
        $old_price = round($okay->money->convert($p->compare_price, $main_currency->id, false),2);
    }
    $old_price = ($old_price > 0 ? "<oldprice>$old_price</oldprice>" : '');
    print
    "
    <offer id='$p->variant_id'  available='".($p->stock > 0 || $p->stock === null ? 'true' : 'false')."'>
    <url>".$okay->config->root_url.'/products/'.$p->url."</url>";
    print "
    <price>$price</price>
    $old_price
    <currencyId>".$currency_code."</currencyId>
    <categoryId>".$p->category_id."</categoryId>
    ";
    
    if(!empty($p_images[$p->product_id])) {
        foreach($p_images[$p->product_id] as $img) {
            print "<picture>".$okay->design->resize_modifier($img, 800, 600)."</picture>";
        }
    }
    
    print "
    <store>".($okay->settings->yandex_available_for_retail_store ? 'true' : 'false')."</store>
    <pickup>".($okay->settings->yandex_available_for_reservation ? 'true' : 'false')."</pickup>
    <delivery>true</delivery>
    <vendor>".htmlspecialchars($p->vendor)."</vendor>
    ".($p->sku ? '<vendorCode>'.$p->sku.'</vendorCode>' : '')."
    ";
    $pn = [];
     $feature = [];
    if (!empty($products_values[$p->product_id])) {
        foreach($products_values[$p->product_id] as $value_id) {
            if (isset($features_values[$value_id])) {
                $feature[] = $features_values[$value_id];
                
                if($features_values[$value_id]->name == 'Розмір'){
                    $pn[] = $features_values[$value_id]->value . ' розміру';
                }
               
            }
        }

    }
    
    if (!empty($insertions[$p->product_id])){
        foreach ($insertions[$p->product_id] as $s){
             $feature[] = (object)['name' => 'Вставка', 'value' => $s];
        }
    }
    
    $p->options = $feature;
   /* $pos = strripos($haystack, '-');
    if ($pos === false) {
       // $ps = stristr($p->product_name, '—', true);
        
        $ps = $p->product_name;
    } else {
        $ps = '++++';//stristr($p->product_name, '-', true);
    }*/

    $str = ucfirst(mb_strtolower(trim($p->product_name . ' ('.$p->sku.')'.' '.implode(" ", $pn))));
    list($str[0], $str[1]) = mb_strtoupper($str[0].$str[1], 'UTF8'); 
    $p->product_name = $str;
    
    print "<name>" . htmlspecialchars($p->product_name) . "</name>
    <stock_quantity>{$p->stock}</stock_quantity>
    <description>".htmlspecialchars(strip_tags(($okay->settings->yandex_short_description ? $p->description : $p->annotation)))."</description>
    ".($okay->settings->yandex_sales_notes ? "<sales_notes>".htmlspecialchars(strip_tags($okay->settings->yandex_sales_notes))."</sales_notes>" : "")."
    ";
    
    print "
    <manufacturer_warranty>".($okay->settings->yandex_has_manufacturer_warranty ? 'true' : 'false')."</manufacturer_warranty>
    <seller_warranty>".($okay->settings->yandex_has_seller_warranty ? 'true' : 'false')."</seller_warranty>
    ";
    
    if(!empty($p->options)) {
    foreach ($p->options as $po) {
         print "
                <param name='".htmlspecialchars($po->name)."'>".htmlspecialchars($po->value)."</param>
                ";
    }
    }
    
    print "</offer>";
}

print "</offers>
";
print "</shop>
</yml_catalog>
";
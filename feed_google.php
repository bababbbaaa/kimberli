<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once('api/Okay.php');
$okay = new Okay();

$lang_link = '';
$title = 'Ювелірний Дім Kimberli';
$description = 'Ювелірний Дім Kimberli - це великий вибір високоякісних прикрас із золота з довічною гарантією на всю продукцію і сертифікованим камінням від виробника.';

// Все валюты
$okay->currencies = $okay->money->get_currencies(array('enabled'=>1));
$okay->currency = reset($okay->currencies);

if (isset($_GET['lang_label'])) {
	switch ($_GET['lang_label']) {
		case 'ru/':
			$okay->languages->set_lang_id(1);
			$okay->language = $okay->languages->get_language($okay->languages->lang_id());
			$lang_link = $okay->language->label . '/';
            //$okay->currency = reset($okay->currencies);
			
			$title = 'Ювелирный Дом Kimberli';
			$description = 'Ювелирный Дом Kimberli – это большой выбор высококачественных украшений из золота с пожизненной гарантией на всю продукцию и сертифицированными камнями от производителя.';
			break;
		default:
			$okay->languages->set_lang_id(3);
			$okay->language = $okay->languages->get_language($okay->languages->lang_id());
	}
}

// Товары
$okay->db->query("SET SQL_BIG_SELECTS=1");
$stock_filter = $okay->settings->yandex_export_not_in_stock ? '' : ' AND v.stock >0 ';
$price_filter = $okay->settings->yandex_no_export_without_price ? ' AND v.price >0 ' : '';

$lang_sql = $okay->languages->get_query(array('object'=>'variant'));

// Товары
$query = "SELECT 
        p.description, 
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
        c.rate_from, 
        c.rate_to, 
        v.currency_id,
       $lang_sql->fields
    FROM __variants v 
    LEFT JOIN __products p ON v.product_id = p.id
    $lang_sql->join
    left join __currencies as c on(c.id=v.currency_id)
    WHERE 
        1 
        AND p.visible 
        #AND p.xml_category_id
        $stock_filter
        $price_filter 
    GROUP BY v.id 
    ORDER BY p.id, v.position";

$okay->db->query($query);
$products = $okay->db->results();

//print_r($products); exit;

header("Content-type: text/xml; charset=UTF-8");
print (pack('CCC', 0xef, 0xbb, 0xbf));

$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
$xml .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">';
$xml .= '<channel>';

$xml .= '<title>'.$title.'</title>';
$xml .= '<link>' . $okay->config->url . $lang_link. '</link>';
$xml .= '<description>'.$description.'</description>';

$p_ids = $p_var = [];

foreach ($products as $p) {
    if (!in_array($p->product_id, $p_ids)) {
        $p_ids[] = $p->product_id;
		$p_var[] = $p->sku;

    }
}

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


$insertions = [];

foreach ($okay->insertions->get_insertions_shtr(array('shtr' => $p_var)) as $in){
    $insertions[$in->product_id][] =  $in->title . ' ' . $in->name;
}

foreach($products as $product)
{
   
    
$categories = $okay->categories->get_categories(array('product_id' => $product->product_id));
$category = array_shift($categories);

$parts = [
            '{$category}' => ($category->name),
            '{$product}' => (mb_strtolower($product->product_name?? '')),
            '{$price}' => ($product->price . ' '. $okay->currency->sign),
            '{$sitename}' => ($okay->settings->site_name ?? ''),
        ];

    $default_products_seo_pattern = (object) $okay->settings->default_products_seo_pattern;

$meta_description = $auto_meta_description = $default_products_seo_pattern->auto_meta_desc;//$product->meta_description;//strtr($okay->settings->seo_product_description, $parts);
$meta_description = strtr($auto_meta_description, $parts);
/*
if (empty($meta_description)) {
    $opt = "SELECT  f.id as feature_id, l.name ,po.value
            FROM ok_options po
            LEFT JOIN ok_features f ON f.id=po.feature_id
            LEFT JOIN ok_lang_features l ON l.feature_id=f.id AND l.lang_id = 3
            WHERE po.product_id = {$result[$k][$kk]->id} AND po.lang_id='3' ";

    $okay->db->query($opt);
    $option = $okay->db->results();
}*/

    $xml .= '<item>';
    $xml .= '<g:id>' . $product->sku . '</g:id>';
    $xml .= '<g:title><![CDATA[' . ucfirst(trim(mb_strtolower($product->name . ' ('. $product->sku . ')'))) . ']]></g:title>';
    $xml .= '<g:description><![CDATA[' . $meta_description . ']]></g:description>';
    $xml .= '<g:link>' . $okay->config->root_url . '/' . $lang_link . 'products/' . $product->url . '</g:link>';
    
     if(!empty($p_images[$product->product_id])) {
     	$i = 0;
        foreach($p_images[$product->product_id] as $img) {
        	
        	if ($i == 0) {
				$xml .= '<g:image_link>'.$okay->design->resize_modifier($img, 700, 700).'</g:image_link>';
			} else {
				$xml .= '<g:additional_image_link>'.$okay->design->resize_modifier($img, 700, 700).'</g:additional_image_link>';
			}
           
            $i++;
        }
    }
    
    $xml .= '<g:condition>new</g:condition>';
    if(!$product->stock) {
        $xml .= '<g:availability>out of stock</g:availability>';
    } else {
        $xml .= '<g:availability>in stock</g:availability>';
    }
    if($product->compare_price != '0.00') {
        $xml .= '<g:price>' . intval($product->compare_price) . ' UAH</g:price>';
        $xml .= '<g:sale_price>' . intval($product->price) . ' UAH</g:sale_price>';
    } else {
        $xml .= '<g:price>' . intval($product->price) . ' UAH</g:price>';
    }

    $xml .= '<g:brand>Kimberli</g:brand>';
    $xml .= '<g:google_product_category>188</g:google_product_category>';
    
   /* $pn = [];
     $feature = [];
    if (!empty($products_values[$p->product_id])) {
        foreach($products_values[$p->product_id] as $value_id) {
            if (isset($features_values[$value_id])) {
                $feature[] = $features_values[$value_id];
                
              //  if($features_values[$value_id]->name == 'Розмір'){
                 //   $pn[] = $features_values[$value_id]->value . ' розміру';
               // }
               
            }
        }

    }
    
    if (!empty($insertions[$p->product_id])){
        foreach ($insertions[$p->product_id] as $s){
             $feature[] = (object)['name' => 'g:insert', 'value' => $s];
        }
    }
    
    if(!empty($feature)) {
    foreach ($feature as $po) {
         
                $xml .= '<param name="'.htmlspecialchars($po->name).'">'.htmlspecialchars($po->value).'</param>';
    }
    }*/
    $xml .= '</item>';
}
$xml .= '</channel>';
$xml .= '</rss>';

echo $xml;

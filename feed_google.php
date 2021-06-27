<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once('api/Okay.php');
$okay = new Okay();

// Товары
$okay->db->query("SET SQL_BIG_SELECTS=1");
$stock_filter = $okay->settings->yandex_export_not_in_stock ? '' : ' AND v.stock >0 ';
$price_filter = $okay->settings->yandex_no_export_without_price ? ' AND v.price >0 ' : '';

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
        p.url, 
        p.annotation, 
        c.rate_from, 
        c.rate_to, 
        v.currency_id
    FROM __variants v 
    LEFT JOIN __products p ON v.product_id=p.id
    left join __currencies as c on(c.id=v.currency_id)
    WHERE 
        1 
        AND p.visible 
        AND p.xml_category_id
        $stock_filter
        $price_filter 
    GROUP BY v.id 
    ORDER BY p.id, v.position";
$okay->db->query($query);
$products = $okay->db->results();

header("Content-type: text/xml; charset=UTF-8");
print (pack('CCC', 0xef, 0xbb, 0xbf));

$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
$xml .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">';
$xml .= '<channel>';

$xml .= '<title>Ювелірний Дім Kimberli</title>';
$xml .= '<link>' . $okay->config->url . '</link>';
$xml .= '<description>Ювелірний Дім Kimberli - це великий вибір високоякісних прикрас із золота з довічною гарантією на всю продукцію і сертифікованим камінням від виробника.</description>';

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
            //'{$category}' => $category->name,
            '{$product}' => mb_strtolower($product->product_name),
            '{$price}' => $product->price,
            '{$sitename}' => $okay->settings->site_name,
        ];

$meta_description = strtr($okay->settings->seo_product_description, $parts);
    $xml .= '<item>';
    $xml .= '<g:id>' . $product->product_id . '</g:id>';
    $xml .= '<g:title><![CDATA[' . ucfirst(trim(mb_strtolower($product->product_name . ' sku '. $product->sku))) . ']]></g:title>';
    $xml .= '<g:description><![CDATA[' . $meta_description . ']]></g:description>';
    $xml .= '<g:link>' . $okay->config->root_url . '/products/' . $product->url . '</g:link>';
    
     if(!empty($p_images[$product->product_id])) {
        foreach($p_images[$product->product_id] as $img) {
            $xml .= '<g:image_link>'.$okay->design->resize_modifier($img, 800, 600).'</g:image_link>';
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

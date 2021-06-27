<?php

chdir(__DIR__);
require_once('app/bootstrap.php');
$okay = new Okay();

header("Content-Type: text/xml");

$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
$xml .= '<price>';
$xml .= '<date>' . date('Y-m-d H:i') . '</date>';
$xml .= '<firmName>Ювелирный Дом Kimberli</firmName>';
$xml .= '<firmId>34589</firmId>';

$xml .= '<categories>';
foreach($okay->categories->get_categories() as $category)
{
    if(!$category->visible) {
        continue;
    }
    $xml .= '<category>';
    $xml .= '<id>' . $category->id . '</id>';
    $xml .= '<name>' . $category->name . '</name>';
    if($category->parent_id) {
        $xml .= '<parentId>' . $category->parent_id . '</parentId>';
    }
    $xml .= '</category>';
}
$xml .= '</categories>';

$xml .= '<items>';

foreach($okay->products->get_products(['visible'=>1, 'limit'=>10000]) as $product)
{
    $categories = $okay->categories->get_categories(array('product_id' => $product->id));
    $category = array_shift($categories);

    $xml .= '<item>';
    $xml .= '<id>' . $product->id . '</id>';
    $xml .= '<categoryId>' . $category->id . '</categoryId>';
    $xml .= '<code>' . $product->sku . '</code>';
    $xml .= '<vendor>Kimberli</vendor>';
    $xml .= '<name>' . $product->name . '</name>';
    $xml .= '<url>' . $okay->config->url . '/products/' . $product->url . '</url>';
    $xml .= '<image>' . $okay->config->url . '/files/originals/' . $product->image . '</image>';
    $xml .= '<priceRUAH>' . $product->price . '</priceRUAH>';
    if($product->compare_price != '0.00') {
        $xml .= '<oldprice>' . $product->compare_price . '</oldprice>';
    }

    if(!$product->stock) {
        $xml .= '<stock days="30">Под заказ</stock>';
    } else {
        $xml .= '<stock>В наличии</stock>';
    }


    foreach($okay->features->get_product_options(array('product_id' => $product->id)) as $feature)
    {
        $name = $feature->name;
        if(strpos($name, 'Вставка') === 0) {
            $name = "Вставка";
        }
        $xml .= '<param name="' . $name . '">'. $feature->value .'</param>';
    }
    $xml .= '<condition>0</condition>';
    $xml .= '<custom>1</custom>';
    $xml .= '</item>';
}
$xml .= '</items>';
$xml .= '</price>';

echo $xml;
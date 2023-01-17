<?php

require_once('api/Okay.php');
$okay = new Okay();

header("Content-Type: text/xml");

$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
$xml .= '<yml_catalog date="' .date('Y-m-d H:i') . '">';
$xml .= '<shop>';
$xml .= '<name>Ювелірний дім Kimberli</name>';
$xml .= '<company>Kimberli</company>';
$xml .= '<url>' . $okay->config->url . '</url>';
$xml .= '<currencies>';
$xml .= '<currency id="UAH" rate="1"/>';
$xml .= '</currencies>';
$cc = [
    35=>[
        'id'=> 724014, 'name' => 'Золоті жіночі каблучки'
    ],
    18=>[
        'id'=> 724109, 'name' => 'Золоті сережки з англійським замком'
    ],
    38=>[
        'id'=> 724119, 'name' => 'Сережки-гвіздки (пусети)'
    ],
    20=>[
        'id'=> 724049, 'name' => 'Жіночі золоті кулони'
    ],
    17=>[
        'id'=> 724024, 'name' => 'Каблучки солітери (одинарники)'
    ],
    28=>[
        'id'=> 724074, 'name' => 'Золоті хрестики'
    ],
    25=>[
        'id'=> 723979, 'name' => 'Золоті запонки'
    ],
    27=>[
        'id'=> 724029, 'name' => 'Чоловічі золоті каблучки'
    ],
    36=>[
        'id'=> 4657908, 'name' => 'Ланцюжки біжутерія'
    ],
    30=>[
        'id'=> 724034, 'name' => 'Золоті обручки'
    ],
    19=>[
        'id'=> 4657902, 'name' => 'Браслети біжутерія'
    ],
    21=>[
        'id'=> 753624, 'name' => 'Жіночі кольє'
    ],
    40=>[
        'id'=> 723959, 'name' => 'Золоті брошки'
    ],
    34 => [
         'id'=> '', 'name' => ''
    ],
    29 => [
         'id'=> '', 'name' => ''
    ]
];
$sql = "SELECT DISTINCT `ok_products`.`id`, `ok_products`.`url`, `ok_products`.`price`, `ok_products`.`sku`, `ok_products`.`shtr`, `ok_products`.`stock`, `ok_categories`.`id` as category_id, `ok_products`.`image`, `ok_products`.`collections`, l.name,  l.description
FROM `ok_products`
inner join `ok_products_categories` ON `ok_products_categories`.`product_id` = `ok_products`.`id`
inner join `ok_categories` ON `ok_categories`.`id` = `ok_products_categories`.`category_id` and `ok_categories`.`visible` = 1
LEFT JOIN `ok_lang_products` l ON l.product_id=`ok_products`.`id` AND l.lang_id = 3
WHERE `ok_products`.`stock` > 0 and  `ok_products`.`visible` = '1' group by `ok_products`.`id`";
$okay->db->query($sql);
$products = $okay->db->results();
$category = [];
$result = [];
foreach ($products as $p){
   // if($p->category_id == 18){
   $result[$p->category_id][] = $p;
  //  }
}
$opti = [
    'Маса' => 'Вага',
    'Колір золота' => 'Колір металу',
    'Проба' => 'Метал',
    '585' => 'Золото 585°',
    'Розмiр' => 'Розмір',
    
];
foreach ($result as $k => $r){
    $sq_c = "SELECT c.id, l.name "
            . "FROM ok_categories c "
            . "LEFT JOIN ok_lang_categories l ON l.category_id=c.id AND l.lang_id = 3 "
            . "WHERE c.id = {$k} ";
            $okay->db->query($sq_c);
            $cat_rez = $okay->db->result();
            $category[] = (object)[
                'id' => $cc[$cat_rez->id]['id'],
                'name' =>  $cc[$cat_rez->id]['name'],//$cat_rez->name,
                'ids' => $cat_rez->id
            ];
          // $result[$k]->name = $cat_rez->name;
            foreach ($result[$k] as $kk => $p){
                
                $result[$k][$kk]->category = $cc[$cat_rez->id]['name'];//$cat_rez->name;
                $result[$k][$kk]->roz_cat_id = $cc[$cat_rez->id]['id'];
            $opt = "SELECT  f.id as feature_id, l.name ,po.value
            FROM ok_options po
            LEFT JOIN ok_features f ON f.id=po.feature_id
            LEFT JOIN ok_lang_features l ON l.feature_id=f.id AND l.lang_id = 3
            WHERE po.product_id = {$result[$k][$kk]->id} AND po.lang_id='3' ";
            
            $okay->db->query($opt);
            $option = $okay->db->results();
            $par = [];
            $name = [];
          // print_r($option);
            foreach ($option as $op){
              
               // if($op->name != 'Категорії' && $op->name != 'Коллекция' ){
                 //   $name[] = $op->name.' '.$op->value;
               // }
                
                if($op->name != 'Коллекция' && $op->name != 'Категорії'){
                    if(in_array($cat_rez->id, [17,35]) && $op->name == 'Розмiр'){
                        $name[] = $op->name.' '.$op->value;
                    }
                     $par[$opti[$op->name]] = isset($opti[$op->value])?$opti[$op->value]:$op->value;
                }
              
            }
            $result[$k][$kk]->option = $par;
             $str = ucfirst(mb_strtolower(trim(stristr($result[$k][$kk]->name, '-', true).' '.$result[$k][$kk]->shtr.' '.implode(" ", $name))));
            list($str[0], $str[1]) = mb_strtoupper($str[0].$str[1], 'UTF8'); 
            $result[$k][$kk]->name = $str;
            // $result[$k][$kk]->name = mb_strtolower(trim(stristr($result[$k][$kk]->name, '-', true).implode(" ", $name).' '.$result[$k][$kk]->shtr));

            }

}
//print_r($category);
//print_r($result);
//exit();
$xml .= '<categories>';
foreach($category as $category)
{

    $xml .= '<category id="'. $category->id . '" id_site="'.$category->ids.'">';
    $xml .= $category->name;
    $xml .= '</category>';
}
$xml .= '</categories>';

$xml .= '<offers>';
foreach ($result as $k => $res){
    foreach ($result[$k] as $p){
    if(true){
        $available = 'true';
    if(!$p->stock) {
        $available = 'false';
    }
    $xml .= "<offer id='{$p->id}' available='{$available}'>";
    $xml .= '<url>' . $okay->config->url . '/products/' . $p->url . '</url>';
    $xml .= '<price>' . $p->price . '</price>';
    $xml .= '<currencyId>UAH</currencyId>';
    $xml .= '<categoryId>' . $p->roz_cat_id . '</categoryId>';
    $xml .= '<picture>' . $okay->config->url . '/files/originals/' . $p->image . '</picture>';
    $xml .= '<vendor>Kimberli</vendor>';
    $xml .= '<code>' . $p->shtr . '</code>';
    $xml .= '<name>' . $p->name . '</name>';
    $xml .= '<stock_quantity>' . $p->stock . '</stock_quantity>';
    if(count($p->option)){
    foreach ($p->option as $kp => $op){
        $name = $kp;
        if(strpos($kp, 'Вставка') === 0) {
            $name = "Вставка";
        }
    $xml .= '<param name="' . $name . '"><![CDATA[ '.$op .' ]]></param>';
    }
    }
     $xml .= '</offer>';
    }
} 
}
$xml .= '</offers>';
$xml .= '</shop>';
$xml .= '</yml_catalog>';

echo $xml;
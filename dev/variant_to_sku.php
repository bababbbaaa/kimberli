<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
if(!empty($_SERVER['HTTP_USER_AGENT'])){
    session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();
chdir('..');
include_once('api/Okay.php');
$okay = new Okay();

$arr = [
  723959 => 'Брощки',
  723999 => 'Стильне кольє',
  723979 => 'Золоті запонки',
  723944 => 'Браслети на ногу',
  723949 => 'Жіночі браслети',
  723954 => 'Чоловічі браслети',
  723994 => 'Кольє з сердечками',
  723969 => 'Золоті шпильки та заколки',
  723974 => 'Золоті зажими для краватки',
  724089 => 'Пірсинг',
  724054 => 'Кулони-букви',
  724009 => 'Дитячі каблучки',
  724044 => 'Дитячі кулони',
  724099 => 'Дитячі сережки',
  724014 => 'Жіночі каблучки',
  724049 => 'Жіночі кулони',
  724069 => 'Кулони-юдаїка',
  724064 => 'Кулони-ладанки',
  724029 => 'Чоловічі каблучки',
  724084 => 'Чоловічі кулони',
  724074 => 'Кулони-хрестики',
  724079 => 'Кулони-сердечки',
  724034 => 'Обручки',
  724024 => 'Каблучки для заручин',
  724059 => 'Кулони-знаки зодіаку',
  724019 => 'Романтичні каблучки',
  724144 => 'Ланцюжки',
  724149 => 'Чоловічі ланцюжки',
  724104 => 'Чоловічі сережки',
  724129 => 'Сережки-сердечки',
  724154 => 'Ювелірні набори',
  724134 => 'Супер ціна-40/50%',
  724114 => 'Сережки з підвісками',
  724124 => 'Сережки-Конго(каблучки)',
  724119 => 'Сережки-гвоздики (пусети)',
  724109 => 'Сережки з англійським/омега замком',
];
/*
foreach ($arr as $k => $value) {
     $okay->db->query("INSERT INTO `kimb`.`ok_category_xml` (`id`, `category_id`, `name`, `visible`) VALUES (NULL, '{$k}', '{$value}', '1')");
}

$sql = "SELECT DISTINCT (
`sku2`
) AS `id` , `product_id` AS `product`
FROM `kimb`.`ok_variants`
WHERE 1
GROUP BY `sku2`
ORDER BY `ok_variants`.`sku2` DESC";

$okay->db->query($sql);
$results = $okay->db->results();
$i = 0;
if (!empty($results)) {
    
    foreach ($results as $r) {
        $okay->db->query("SELECT `filename`
FROM `kimb`.`ok_images`
WHERE `product_id` = {$r->product}");
$file = '';
        foreach ($okay->db->results() as $im) {
            if (false === empty($im->filename)) {
                $file = trim($im->filename);
            }
        }
        
    $okay->db->query("INSERT INTO `kimb`.`ok_sku_images` (`id`, `sku`, `filename`, `position`, `name`) VALUES (NULL, '{$r->id}', '{$file}', '0', '')");
    $i++;
}
}*/

echo 'Всего: '. $i;



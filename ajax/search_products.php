<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Okay.php');
    define('IS_CLIENT', true);
    $okay = new Okay();
    $limit = 10;

    /*Определяем язык*/
    $lang_id  = $okay->languages->lang_id();
    $language = $okay->languages->get_language($lang_id);
    $lang_link = $okay->languages->get_lang_link();
    $px = ($lang_id ? 'l' : 'p'); /*Если язык существует выбираем с таблицы переводов, иначе - таблицы produtcs*/
    $lang_sql = $okay->languages->get_query(array('object'=>'product'));

    /*Ищем товар*/
    $keyword = $okay->request->get('query', 'string');
    $keyword_filter = '';
    if (!empty($keyword)) {
        $keywords = explode(' ', $keyword);
        foreach ($keywords as $kw) {
            $kw = $okay->db->escape($kw);
            if($kw!=='') {
				$k_adm = '';
				if(!empty($filter['admin'])) {
					$k_adm = " OR v.sku LIKE '%$kw%'";
				}
				/*$keyword_filter .= $okay->db->placehold("AND (
						 $px.name LIKE '%$kw%'
						 OR $px.meta_keywords LIKE '%$kw%'
						 OR p.id in (SELECT product_id FROM __variants WHERE sku LIKE '%$kw%')
					 ) ");*/
				$keyword_filter .=" AND (v.sku2 LIKE '%$kw%' OR $px.name LIKE '%$kw%' OR $px.meta_keywords LIKE '%$kw%' $k_adm)";
            }
        }
    }
   // $variants_join = $okay->db->placehold("inner join __variants v on v.product_id=p.id");

    /*Делаем выборку из БД*/
	$okay->db->query("SELECT 
            p.id,
            p.url,
            p.main_image_id,
            v.stock,
			v.price,
       		v.sku2,
            $px.name
        FROM __products p 
        $lang_sql->join
        inner join ok_variants v on v.product_id=p.id
        WHERE 
            1
            $keyword_filter
            AND visible=1
        ORDER BY v.stock DESC, v.price ASC, v.sku2,  $px.name 
        LIMIT ?
    ", $limit);
    $products = $okay->db->results();

    $suggestions = array();
    $ids = array();
    $images_ids = array();
    foreach($products as $p){
        $ids[] = $p->id;
        $images_ids[] = $p->main_image_id;
    }
    /*Подставляем к найденым товарам их варианты*/
    $variants = array();
    foreach ($okay->variants->get_variants(array('product_id'=>$ids)) as $v) {
        $variants[$v->product_id][] = $v;
    }

    /*Картинки товаров*/
    $images = array();
    if (!empty($images_ids)) {
        foreach ($okay->products->get_images(array('id'=>$images_ids)) as $i) {
            $images[$i->product_id] = $i->filename;
        }
    }

    /*Определяем валюту*/
    $currencies = $okay->money->get_currencies(array('enabled'=>1));
    if(isset($_SESSION['currency_id'])) {
        $currency = $okay->money->get_currency($_SESSION['currency_id']);
    } else {
        $currency = reset($currencies);
    }

    /*Подготавливаем данные для отображения в автокомплите*/
    foreach($products as $product) {
        $suggestion = new stdClass();
        if(isset($images[$product->id])) {
            $product->image = $okay->design->resize_modifier($images[$product->id], 35, 35);
        }
        if($product->stock > 0){
            $suggestion->price = $okay->money->convert($variants[$product->id][0]->price, $currency->id);
        $suggestion->currency = $currency->sign;
        }else{
             $suggestion->price = $okay->translations->get_translation('product_pre_order')->values[$lang_id];
             $suggestion->currency = '';
        }
        
        $suggestion->value = $product->name;
        $suggestion->data = $product;
        $suggestion->lang = $lang_link;
        $suggestions[] = $suggestion;
    }

    $res = new stdClass;
    $res->query = $keyword;
    $res->suggestions = $suggestions;
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");		
    print json_encode($res);

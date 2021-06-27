<?php

	if(!$okay->managers->access('products')) {
        exit();
    }

    $limit = 30;
    if (!empty($_SESSION['admin_lang_id'])) {
        $okay->languages->set_lang_id($_SESSION['admin_lang_id']);
    }

    /*Определение языка для поиска*/
    $lang_id  = $okay->languages->lang_id();
    $px = ($lang_id ? 'l' : 'p');
    $lang_sql = $okay->languages->get_query(array('object'=>'product', 'px'=>'p'));

    /*Поиск товаров*/
    $keyword = $okay->request->get('query', 'string');
    $keywords = explode(' ', $keyword);
    $keyword_sql = '';
    foreach($keywords as $keyword) {
        $kw = $okay->db->escape(trim($keyword));
        $keyword_sql .= $okay->db->placehold("AND (
            $px.name LIKE '%$kw%' 
            OR $px.meta_keywords LIKE '%$kw%' 
             OR v.name LIKE '%$kw%'
             OR v.sku LIKE '$kw%'
        ) ");
    }
    $variants_join = $okay->db->placehold("inner join __variants v on v.product_id=p.id");
    
    $query = "SELECT 
            p.id, 
            $px.name, 
            v.stock,
            v.price,
            i.filename as image 
        FROM __products p
        $lang_sql->join
        $variants_join
        LEFT JOIN __images i ON i.id=p.main_image_id
        WHERE 
            1 
            $keyword_sql 
            and v.stock > 0
            and v.price > 0
            AND i.filename != ''
        ORDER BY v.price ASC
        LIMIT ". $limit;

    $okay->db->query($query);
    
    $products = $okay->db->results();
    
    $suggestions = array();
    foreach($products as $product) {
        if(!empty($product->image)) {
            $product->image = $okay->design->resize_modifier($product->image, 35, 35);
        }
        
        $suggestion = new stdClass();
        $suggestion->value = $product->name .= ' (<b>'.$product->price.' грн.</b>)';
        //$product->name .= ' (<b>'.$product->price.' грн.</b>)';
        $suggestion->data = $product;
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

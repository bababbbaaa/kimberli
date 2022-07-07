<?php

require_once('Okay.php');

class Products extends Okay {
    
    private $all_brands = array();

    /*Выборка всех товаров*/
    public function get_products($filter = array()) {
        // По умолчанию
        $limit = 100;
        $page = 1;
        $category_id_filter = '';
        $without_category_filter = '';
        $brand_id_filter = '';
        $product_id_filter = '';
        $features_filter = '';
		$features_filter_join = '';
        $keyword_filter = '';
        $visible_filter = '';
        $is_featured_filter = '';
        $discounted_filter = '';
        $stock_filter = '';
        $has_images_filter = '';
        $feed_filter = '';
        $new_filter = '';
        $other_filter = '';
		$group_by = "GROUP BY p.id";
        $order = 'pv.price ASC';

        $include_empty = false;

        if (!empty($filter['empty'])) {
			$include_empty = true;
		}
        
        $lang_id  = $this->languages->lang_id();

        $px = ($lang_id ? 'l' : 'p');
        
        if(isset($filter['limit'])) {
            $limit = max(1, intval($filter['limit']));
        }
        
        if(isset($filter['page'])) {
            $page = max(1, intval($filter['page']));
        }
        
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1) * $limit, $limit);
        
        if(!empty($filter['id'])) {
        	$ids = implode(',', $filter['id']);
        	$product_id_filter = "AND p.id in($ids)";
        }
        
        if(!empty($filter['category_id'])) {
			if (count($filter['category_id']) && $filter['category_id'][0] == (int) 113) {
				$filter['no_stock'] = 1;
			} else if(count($filter['category_id']) && $filter['category_id'][0] == (int) 114) {
				$catIds = implode(',', $filter['category_id']);
				$category_id_filter = "LEFT JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id in({$catIds})";
				$group_by = "GROUP BY p.id";
			} else {
				$catIds = implode(',', $filter['category_id']);
				$category_id_filter = "INNER JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id in({$catIds})";
				$group_by = "GROUP BY p.id";
			}

        }

        if (isset($filter['without_category'])) {
            $without_category_filter = $this->db->placehold('AND (SELECT count(*)=0 FROM __products_categories pc WHERE pc.product_id=p.id) = ?', intval($filter['without_category']));
        }
        
        if(!empty($filter['brand_id'])) {
            $brand_id_filter = $this->db->placehold('AND p.brand_id in(?@)', (array)$filter['brand_id']);
        }
        
        if(isset($filter['featured'])) {
			$is_featured_filter = " AND p.featured={$filter['featured']}";
        }
        
        if(isset($filter['discounted'])) {
            $is_featured_filter = " AND p.outlet={$filter['discounted']}"; //$this->db->placehold('AND p.outlet=?', intval($filter['discounted']));
        }

        if (!empty($filter['other_filter'])) {
            $other_filter = "AND (";
            if (in_array("featured", $filter['other_filter'])) {
                $other_filter .= "p.featured=1 OR ";
            }
            if (in_array("discounted", $filter['other_filter'])) {
               $other_filter .= "(pv.compare_price>0 and pv.proc >=40) OR ";
            }
            $other_filter = substr($other_filter, 0, -4).")";
        }

        if(isset($filter['has_images'])) {
            $has_images_filter = $this->db->placehold('AND (SELECT count(*)>0 FROM __images pi WHERE pi.product_id=p.id LIMIT 1) = ?', intval($filter['has_images']));
        }
        
        if(isset($filter['created'])) {
            $has_images_filter = $this->db->placehold('AND p.created >= ?', date('Y-m-d 00:00:00'));
        }
        
        if(isset($filter['feed'])) {
            $feed_filter = $this->db->placehold('inner join __variants v on v.product_id=p.id and v.feed=?', intval($filter['feed']));
        }

		if(isset($filter['new'])) {
			$new_filter = " AND (p.main_category_id IS NULL or p.main_image_id IS NULL)";
		}

        $price_filter = '';

        $variant_join = "INNER JOIN ok_variants pv ON pv.product_id = p.id";

        $currency_join = '';
        
        $first_currency = $this->money->get_currencies(array('enabled'=>1));
        $first_currency = reset($first_currency);
        $coef = 1;

        if(isset($_SESSION['currency_id']) && $first_currency->id != $_SESSION['currency_id']) {
            $currency = $this->money->get_currency(intval($_SESSION['currency_id']));
            $coef = $currency->rate_from / $currency->rate_to;
        }

        if(isset($filter['price'])) {
            if(isset($filter['price']['min'])) {
                $price_filter .= $this->db->placehold(" AND floor(IF(pv.currency_id=0 OR c.id is null,p.price, p.price*c.rate_to/c.rate_from)*$coef)>= ? ", $this->db->escape(trim($filter['price']['min'])));
            }
            if(isset($filter['price']['max'])) {
                $price_filter .= $this->db->placehold(" AND floor(IF(pv.currency_id=0 OR c.id is null,p.price, p.price*c.rate_to/c.rate_from)*$coef)<= ? ", $this->db->escape(trim($filter['price']['max'])));
            }

            $currency_join = 'LEFT JOIN __currencies c ON c.id=pv.currency_id';
        }
        
        if(isset($filter['visible'])) {
            $visible_filter =  "AND p.visible={$filter['visible']}";
        }
        
        if(!empty($filter['sort'])) {
            switch ($filter['sort']) {
                case 'rand':
                    $order = 'RAND()';
                    break;
                case 'position':
                    $order = 'p.position DESC';
                    break;
                case 'name':
                    $order = 'p.name ASC';
                    break;
                case 'name_desc':
                    $order = 'p.name DESC';
                    break;
                case 'rating':
                    $order = 'p.rating ASC';
                    break;
                case 'rating_desc':
                    $order = 'p.rating DESC';
                    break;
                case 'created':
                    $order = 'p.created DESC';
                    break;
                case 'price':
					$order = " p.price ASC";
                    break;
                case 'price_desc':
					$order = " p.price DESC";
                    break;
				case 'sku':
					$order = "pv.sku2 ASC";
					break;
				case 'sku_desc':
					$order = "pv.sku2 DESC";
					break;
				case 'last_update':
					$order = "p.last_modify ASC";
					break;
				case 'last_update_desc':
					$order = "p.last_modify DESC";
					break;
            }
        }
        
        if(!empty($filter['keyword'])) {
            $keywords = explode(' ', $filter['keyword']);
			$filter['stock'] = 1;
            foreach($keywords as $keyword) {
                $kw = $this->db->escape(trim($keyword));
                if($kw !=='') {
                $k_adm = '';
                if(!empty($filter['admin'])) {
					$k_adm = " OR pv.sku LIKE '%$kw%'";
					$filter['stock'] = false;
                } 

					$keyword_filter .=" AND (pv.sku2 LIKE '%$kw%' OR $px.name LIKE '%$kw%' OR $px.meta_keywords LIKE '%$kw%' $k_adm)";
                }
            }

        }

        if(!empty($filter['features'])) {

            $lang_id_options_filter = '';
            $lang_options_join      = '';
            // Алиас для таблицы без языков
            $options_px = 'fv';
            if (!empty($lang_id)) {
                $lang_id_options_filter = $this->db->placehold("AND `lfv`.`lang_id`=?", $lang_id);
                $lang_options_join = $this->db->placehold("LEFT JOIN `__lang_features_values` AS `lfv` ON `pfv`.`value_id`=`lfv`.`feature_value_id`");
                // Алиас для таблицы с языками
                $options_px = 'lfv';
            }

            foreach($filter['features'] as $feature_id=>$value) {
                $features_values[] = $this->db->placehold("(
                            `{$options_px}`.`translit` in(?@)
                            AND `{$options_px}`.`feature_id`=?)", (array)$value, $feature_id);
            }

            if (!empty($features_values)) {
                $features_values = implode(' OR ', $features_values);

				$features_filter_join = " LEFT JOIN `ok_products_features_values` AS `pfv` ON pfv.product_id = p.id
										LEFT JOIN `ok_features_values` AS `fv` ON `fv`.`id` = `pfv`.`value_id`";
				$features_filter_join .= $lang_options_join . $lang_id_options_filter ;

				$features_filter = " AND ($features_values)";
            }
        }

		if(!empty($filter['stock']) || !empty($filter['in_stock']) || (!empty($filter['other_filter']) && in_array("stock", $filter['other_filter']))) {
			$stock_filter = " AND pv.stock > 0";
		}else if(isset($filter['no_stock'])) {
			$stock_filter = " AND (pv.stock = 0 or pv.stock is NULL) ";
		}
        
        $lang_sql = $this->languages->get_query(array('object'=>'product'));

        $query = "SELECT DISTINCT pv.id as pvId,
                p.id,
                p.brand_id,
                p.position,
                p.created as created,
                p.visible,
                p.featured,
                p.outlet,
                p.rating,
                p.votes,
                p.last_modify,
                p.main_category_id,
                p.xml_category_id,
                p.main_image_id,
                p.gia,
                p.hrd,
                p.youtube,
                p.stock as remainder,
                pv.sku,
                pv.sku2,
                pv.url,
                $lang_sql->fields
            FROM __products p
            $variant_join
            $category_id_filter
            $lang_sql->join
            $currency_join
            $feed_filter
			$features_filter_join
            WHERE
                1
                $visible_filter
                $product_id_filter
                $brand_id_filter
                $without_category_filter
                $features_filter
                $keyword_filter
                $is_featured_filter
                $discounted_filter
                $other_filter
                $stock_filter    
                $has_images_filter
                $price_filter
                $new_filter
                $group_by
            ORDER BY $order
            $sql_limit
        ";
        //l($query);

        $this->db->query($query);

        $products = $this->db->results();


        if ($include_empty) {
        	$limit = 8;

			$has_images_filter = $this->db->placehold('AND (SELECT count(*)>0 FROM __images pi WHERE pi.product_id=p.id LIMIT 1) = ?', 1);

			$stock_filter = " AND (pv.stock = 0 or pv.stock is NULL)";
			$pIds = [];

			foreach ($products as $p) {
				$pIds[] = $p->id;
			}

			if(count($pIds) % 4 != 0) {
				$c = count($pIds) / 4;

				$r = substr($c, strrpos($c, ".")+1, strlen($c));

				if ($r <= 25) {
					$limit = 7;
				} else if ($r <= 50) {
					$limit = 6;
				} else if ($r <= 75) {
					$limit = 5;
				}
			}

			$sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);


			$pIds = implode(',', $pIds);

			$product_id_filter = " and p.id not in($pIds)";

			$query = "SELECT DISTINCT pv.id as pvId,
                p.id,
                p.brand_id,
                p.position,
                p.created as created,
                p.visible,
                p.featured,
                p.outlet,
                p.rating,
                p.votes,
                p.last_modify,
                p.main_category_id,
                p.xml_category_id,
                p.main_image_id,
                p.gia,
                p.hrd,
                p.youtube,
                pv.sku2,
                pv.sku,
                pv.url,
                $lang_sql->fields
            FROM __products p
            $variant_join
            $category_id_filter
            $lang_sql->join
            $currency_join
            $feed_filter
			$features_filter_join
            WHERE
                1
                $visible_filter
                $product_id_filter
                $brand_id_filter
                $without_category_filter
                $features_filter
                $keyword_filter
                $is_featured_filter
                $discounted_filter
                $other_filter
                $stock_filter    
                $has_images_filter
                $price_filter
                $new_filter
                $group_by
            ORDER BY $order
            $sql_limit
        ";

			$this->db->query($query);

			$products2 = $this->db->results();

			$products = (object) array_merge((array) $products, (array) $products2);
		}


        return $products;
    }

    /*Подсчет количества товаров*/
    public function count_products($filter = array()) {
        $category_id_filter = '';
        $without_category_filter = '';
        $brand_id_filter = '';
        $product_id_filter = '';
        $keyword_filter = '';
        $visible_filter = '';
        $is_featured_filter = '';
        $stock_filter = '';
        $in_stock_filter = '';
        $has_images_filter = '';
        $feed_filter = '';
		$new_filter = '';
        $discounted_filter = '';
        $features_filter = '';
		$features_filter_join = '';
        $other_filter = '';

		if (!empty($filter['empty'])) {
			$include_empty = true;
		}
        
        $lang_id  = $this->languages->lang_id();
        $px = ($lang_id ? 'l' : 'p');
        
        if(!empty($filter['category_id'])) {
        	if (count($filter['category_id']) && $filter['category_id'][0] == (int) 113) {
				$filter['no_stock'] = 1;
			}  else if(count($filter['category_id']) && $filter['category_id'][0] == (int) 114) {
				$catIds = implode(',', $filter['category_id']);
				$category_id_filter = "LEFT JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id in({$catIds})";

			} else {
				$cat = implode(',', $filter['category_id']);
				$category_id_filter = "INNER JOIN ok_products_categories pc ON pc.product_id = p.id AND pc.category_id in({$cat})";
			}
 }

        if (isset($filter['without_category'])) {
            $without_category_filter = $this->db->placehold('AND (SELECT count(*)=0 FROM __products_categories pc WHERE pc.product_id=p.id) = ?', intval($filter['without_category']));
        }
        
        if(!empty($filter['brand_id'])) {
            $brand_id_filter = $this->db->placehold('AND p.brand_id in(?@)', (array)$filter['brand_id']);
        }
        
        if(!empty($filter['id'])) {
			$pr = implode(',', $filter['id']);
			$product_id_filter = " AND p.id in($pr)";
        }

		if(!empty($filter['keyword'])) {
			$keywords = explode(' ', $filter['keyword']);
			$filter['stock'] = 1;
			foreach($keywords as $keyword) {
				$kw = $this->db->escape(trim($keyword));
				if($kw !=='') {
					$k_adm = '';
					if(!empty($filter['admin'])) {
						$k_adm = " OR pv.sku LIKE '%$kw%'";
						$filter['stock'] = false;
					}

					$keyword_filter .=" AND (pv.sku2 LIKE '%$kw%' OR $px.name LIKE '%$kw%' OR $px.meta_keywords LIKE '%$kw%' $k_adm)";
				}
			}

		}
        
        if(isset($filter['featured'])) {
            $is_featured_filter = $this->db->placehold('AND p.featured=?', intval($filter['featured']));
        }

        if(isset($filter['has_images'])) {
            $has_images_filter = $this->db->placehold('AND (SELECT count(*)>0 FROM __images pi WHERE pi.product_id=p.id LIMIT 1) = ?', intval($filter['has_images']));
        }

        
        if(isset($filter['created'])) {
            $has_images_filter = $this->db->placehold('AND p.created >= ?', date('Y-m-d 00:00:00'));
        }
        
        if(isset($filter['feed'])) {
           $feed_filter = " AND pv.feed =" . intval($filter['feed']);
        }

		if(isset($filter['new'])) {
			$new_filter = " AND (p.main_category_id IS NULL or p.main_image_id IS NULL)";
		}

        $price_filter = '';

		$variant_join = 'INNER JOIN ok_variants pv ON pv.product_id = p.id';


        $select = 'count(distinct p.id) as count';
        $currency_join = '';
        
        $first_currency = $this->money->get_currencies(array('enabled'=>1));
        $first_currency = reset($first_currency);
        $coef = 1;

        if(isset($_SESSION['currency_id']) && $first_currency->id != $_SESSION['currency_id']) {
            $currency = $this->money->get_currency(intval($_SESSION['currency_id']));
            $coef = $currency->rate_from / $currency->rate_to;
        }

        if(isset($filter['get_price'])) {
            $currency_join = 'LEFT JOIN __currencies c ON c.id=pv.currency_id';
            $select = "
                floor(min(IF(pv.currency_id=0 OR c.id is null,pv.price, pv.price*c.rate_to/c.rate_from)*$coef)) as min,
                floor(max(IF(pv.currency_id=0 OR c.id is null,pv.price, pv.price*c.rate_to/c.rate_from)*$coef)) as max
            ";
        } elseif (isset($filter['price'])) {
            if(isset($filter['price']['min'])) {
                $price_filter .= $this->db->placehold(" AND floor(IF(pv.currency_id=0 OR c.id is null,pv.price, pv.price*c.rate_to/c.rate_from)*$coef)>= ? ", $this->db->escape(trim($filter['price']['min'])));

            }

            if(isset($filter['price']['max'])) {
                $price_filter .= $this->db->placehold(" AND floor(IF(pv.currency_id=0 OR c.id is null,pv.price, pv.price*c.rate_to/c.rate_from)*$coef)<= ? ", $this->db->escape(trim($filter['price']['max'])));
            }

            $currency_join = 'LEFT JOIN __currencies c ON c.id=pv.currency_id';
        }

        if(isset($filter['discounted'])) {
           $is_featured_filter = " AND p.outlet=" . intval($filter['discounted']);
        }

        if (!empty($filter['other_filter'])) {
            $other_filter = "AND (";
            if (in_array("featured", $filter['other_filter'])) {
                $other_filter .= "p.featured=1 OR ";
            }
            
            if (in_array("discounted", $filter['other_filter'])) {
				$other_filter .= " AND pv.compare_price>0 and pv.proc >=40";
            }

            $other_filter = substr($other_filter, 0, -4).")";
        }
        
        if(isset($filter['visible'])) {
            $visible_filter = " AND p.visible={$filter['visible']}";
        }

		if(isset($filter['stock']) || isset($filter['in_stock']) || (!empty($filter['other_filter']) && in_array("stock", $filter['other_filter']))) {
			$stock_filter = " AND pv.stock > 0";
		} else if(isset($filter['no_stock'])) {
			$stock_filter = " AND (pv.stock = 0 or pv.stock is NULL)";
		}

        if(!empty($filter['features'])) {

            $lang_id_options_filter = '';
            $lang_options_join      = '';
            // Алиас для таблицы без языков
            $options_px = 'fv';
            if (!empty($lang_id)) {
                $lang_id_options_filter = $this->db->placehold("AND `lfv`.`lang_id`=?", $lang_id);
                $lang_options_join = $this->db->placehold("LEFT JOIN `__lang_features_values` AS `lfv` ON `pfv`.`value_id`=`lfv`.`feature_value_id`");
                // Алиас для таблицы с языками
                $options_px = 'lfv';
            }
            
            foreach($filter['features'] as $feature_id=>$value) {
                $features_values[] = $this->db->placehold("(
                            `{$options_px}`.`translit` in(?@)
                            AND `{$options_px}`.`feature_id`=?)", (array)$value, $feature_id);
            }

            if (!empty($features_values)) {
                $features_values = implode(' OR ', $features_values);

				$features_filter_join = " LEFT JOIN `ok_products_features_values` AS `pfv` ON pfv.product_id = p.id
										LEFT JOIN `ok_features_values` AS `fv` ON `fv`.`id` = `pfv`.`value_id`";
				$features_filter_join .= $lang_options_join . $lang_id_options_filter ;

				$features_filter = " AND ($features_values)";
            }
        }
        
        $lang_sql = $this->languages->get_query(array('object'=>'product'));

        $query = "SELECT $select
            FROM __products AS p
            $variant_join
            $category_id_filter
            $lang_sql->join
            $features_filter_join
            $feed_filter
            $currency_join
            WHERE 
                1
                $brand_id_filter
                $without_category_filter
                $product_id_filter
                $keyword_filter
                $is_featured_filter
                $stock_filter 
                $in_stock_filter
                $has_images_filter
                $discounted_filter
                $visible_filter
                $features_filter
                $other_filter
                $price_filter
				$new_filter
        ";

        $this->db->query($query);

        if(isset($filter['get_price'])) {
            $count = $this->db->result();
        } else {
			$count = $this->db->result('count');
        }

        return $count;
    }

    /*Выборка конкретного товара*/
    public function get_product($id) {
        if (empty($id)) {
            return false;
        }
        if(is_int($id)) {
            $filter = $this->db->placehold('AND p.id = ?', $id);
        } else {
            $filter = $this->db->placehold('AND pv.url = ?', $id);
        }
        
        $lang_sql = $this->languages->get_query(array('object'=>'product'));
        $query = "SELECT DISTINCT
                p.id,
                pv.url,
                p.brand_id,
                p.position,
                p.created as created,
                p.visible,
                p.featured,
                p.outlet,
                p.rating,
                p.votes,
                p.last_modify,
                p.main_category_id,
                p.xml_category_id,
                p.main_image_id,
                p.gia,
                p.hrd,
                p.youtube,
                pv.sku,
                pv.new_sku,
                $lang_sql->fields
            FROM __products AS p
            INNER JOIN ok_variants pv ON pv.product_id = p.id
            $lang_sql->join
            WHERE 
                1 
                $filter
            GROUP BY p.id
            LIMIT 1
        ";
        $this->db->query($query);

        return $this->db->result();
    }

    /*Обновление товара*/
    public function update_product($id, $product) {
		$product = (object) $product;

        $result = $this->languages->get_description($product, 'product');
        $query = $this->db->placehold("UPDATE __products SET ?% WHERE id in (?@) LIMIT ?", $product, (array)$id, count((array)$id));

        if($this->db->query($query)) {
            if(!empty($result->description)) {
                $this->languages->action_description($id, $result->description, 'product', $this->languages->lang_id());
            }
            return $id;
        } else {
            return false;
        }
    }

    /*Добавление товара*/
    public function add_product($product) {
        $created = '';
        $product = (array) $product;
        if(empty($product['url'])) {
            $product['url'] = preg_replace("/[\s]+/ui", '-', $product['name']);
            $product['url'] = strtolower(preg_replace("/[^0-9a-zа-я\-]+/ui", '', $product['url']));
        }
        
        // Если есть товар с таким URL, добавляем к нему число
        while($this->get_product((string)$product['url'])) {
            if(preg_match('/(.+)_([0-9]+)$/', $product['url'], $parts)) {
                $product['url'] = $parts[1].'_'.($parts[2]+1);
            } else {
                $product['url'] = $product['url'].'_2';
            }
        }
        
        $product = (object)$product;
        if (empty($product->created)) {
            $created = $this->db->placehold(", created=NOW()");
        }        
        $result = $this->languages->get_description($product, 'product');

        if($this->db->query("INSERT INTO __products SET ?% $created", $product)) {
            $id = $this->db->insert_id();
            $this->db->query("UPDATE __products SET position=id WHERE id=?", $id);
            
            if(!empty($result->description)) {
                $this->languages->action_description($id, $result->description, 'product');
            }
            return $id;
        } else {
            return false;
        }
    }

    /*Удаление товара*/
    public function delete_product($id) {
        if(!empty($id)) {
            // Удаляем варианты
            $variants = $this->variants->get_variants(array('product_id'=>$id));
            foreach($variants as $v) {
                $this->variants->delete_variant($v->id);
            }
            
            // Удаляем изображения
            $images = $this->get_images(array('product_id'=>$id));
            foreach($images as $i) {
                $this->delete_image($i->id);
            }
            
            // Удаляем категории
            $categories = $this->categories->get_categories(array('product_id'=>$id));
            foreach($categories as $c) {
                $this->categories->delete_product_category($id, $c->id);
            }
            
            // Удаляем свойства
            $this->features_values->delete_product_value($id);
            
            // Удаляем связанные товары
            $related = $this->get_related_products($id);
            foreach($related as $r) {
                $this->delete_related_product($id, $r->related_id);
            }
            
            // Удаляем товар из связанных с другими
            $query = $this->db->placehold("DELETE FROM __related_products WHERE related_id=?", intval($id));
            $this->db->query($query);
            
            // Удаляем отзывы
            $comments = $this->comments->get_comments(array('object_id'=>$id, 'type'=>'product'));
            foreach($comments as $c) {
                $this->comments->delete_comment($c->id);
            }
            
            // Удаляем из покупок
            $this->db->query('UPDATE __purchases SET product_id=NULL WHERE product_id=?', intval($id));
            
            //lastModify
            $this->db->query('select brand_id from __products where id=?', intval($id));
            $bid = (int)$this->db->result('brand_id');
            if ($bid) {
                $this->db->query('update __brands set last_modify=now() where id=?', $bid);
            }
            
            // Удаляем языки
            $query = $this->db->placehold("DELETE FROM __lang_products WHERE product_id=?", intval($id));
            $this->db->query($query);
            
            // Удаляем товар
            $query = $this->db->placehold("DELETE FROM __products WHERE id=? LIMIT 1", intval($id));
            if($this->db->query($query)) {
                return true;
            }
        }
        return false;
    }

    /*Дублирование товара*/
    public function duplicate_product($id) {
        $product = $this->get_product($id);
        $product->id = null;
        $product->external_id = '';
        unset($product->created);
        
        // Сдвигаем товары вперед и вставляем копию на соседнюю позицию
        $this->db->query('UPDATE __products SET position=position+1 WHERE position>?', $product->position);
        $new_id = $this->products->add_product($product);
        $this->db->query('UPDATE __products SET position=? WHERE id=?', $product->position+1, $new_id);
        
        //lastModify
        if ($product->brand_id > 0) {
            $this->db->query('update __brands set last_modify=now() where id=?', intval($product->brand_id));
        }
        
        // Очищаем url
        $this->db->query('UPDATE __products SET url="" WHERE id=?', $new_id);
        
        // Дублируем категории
        $categories = $this->categories->get_product_categories($id);
        foreach($categories as $i=>$c) {
            $this->categories->add_product_category($new_id, $c->category_id, $i);
        }
        
        // Дублируем изображения
        $images = $this->get_images(array('product_id'=>$id));
        foreach($images as $image) {
            $this->add_image($new_id, $image->filename);
        }
        
        // Дублируем варианты
        $variants = $this->variants->get_variants(array('product_id'=>$id));
        foreach($variants as $variant) {
            $variant->product_id = $new_id;
            unset($variant->id);
            if($variant->infinity) {
                $variant->stock = null;
            }
            unset($variant->infinity);
            unset($variant->rate_from);unset($variant->rate_to);
            $variant->external_id = '';
            $this->variants->add_variant($variant);
        }
        
        // Дублируем значения свойств
        $values = $this->features_values->get_product_value_id($id);
        foreach($values as $value) {
            $this->features_values->add_product_value($new_id, $value->value_id);
        }
        
        // Дублируем связанные товары
        $related = $this->get_related_products($id);
        foreach($related as $r) {
            $this->add_related_product($new_id, $r->related_id, $r->position);
        }
        
        $this->multi_duplicate_product($id, $new_id);
        return $new_id;
    }

    /*Выборка связанных товаров*/
    public function get_related_products($product_id = array()) {
        if(empty($product_id)) {
            return array();
        }
        
        $product_id_filter = $this->db->placehold('AND product_id in(?@)', (array)$product_id);
        
        $query = $this->db->placehold("SELECT 
                product_id, 
                related_id, 
                position
            FROM __related_products
            WHERE
                1
                $product_id_filter
            ORDER BY position
        ");
        //l($query);
        $this->db->query($query);
        return $this->db->results();
    }
     /*Выборка связанных товаров*/
    public function get_related_products_auto( array $param) {
        if(empty($param["product"]->id)) {
            return [];
        }
        
            $filter_in_stock = $this->db->placehold('AND (SELECT count(*)>0 FROM __variants pv WHERE pv.product_id=p.id AND (pv.stock IS NULL OR pv.stock>0) LIMIT 1) = ?', 1);

            $filter_not_id = $this->db->placehold(' AND p.id != ?', $param["product"]->id);
            $filter_sku = $this->db->placehold(' AND p.sku = ?', $param["product"]->sku);

            $lang_sql = $this->languages->get_query(array('object'=>'product'));
            
        $query = $this->db->placehold("SELECT 
                p.id as related_id, 
                p.sku,
                $lang_sql->fields
            FROM __products p
            $lang_sql->join
            WHERE
                p.visible = 1
                $filter_not_id
                $filter_sku
                $filter_in_stock
            ORDER BY price asc
            LIMIT 10
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        if (empty($results) && !empty($param["category_id"])) {
            
            $category_id_filter = $this->db->placehold('INNER JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id =?', $param["category_id"]);
            
            $filter_collection = '';
            
                $features_values = null;
                foreach ($param["product"]->features as $k => $f) {
                    if($k === 78){
                        $features_values = $f;
                    }
                }
                
                if (!empty($features_values)) {
                    $filter_collection = $this->db->placehold("INNER JOIN  __products_features_values pf ON pf.product_id = p.id AND pf.value_id = ?", $features_values->id);  
                }


            
            $query = $this->db->placehold("SELECT 
                DISTINCT(p.id) as related_id, 
                p.sku,
                $lang_sql->fields
            FROM __products p
            $lang_sql->join
            $category_id_filter 
            $filter_collection
            WHERE
                p.visible = 1
                $filter_not_id
                $filter_in_stock
                    
            ORDER BY price asc
            LIMIT 10
        ");
          //  l($query);
        $this->db->query($query);
        $results = $this->db->results();
        }
        
        return $results;
            
    }

    /*Добавление связанных товаров*/
    public function add_related_product($product_id, $related_id, $position=0) {
        $query = $this->db->placehold("INSERT IGNORE INTO __related_products SET product_id=?, related_id=?, position=?", $product_id, $related_id, $position);
        $this->db->query($query);
        return $related_id;
    }

    /*Удаление связанных товаров*/
    public function delete_related_product($product_id, $related_id) {
        $query = $this->db->placehold("DELETE FROM __related_products WHERE product_id=? AND related_id=? LIMIT 1", intval($product_id), intval($related_id));
        $this->db->query($query);
    }

    /*Выборка изображений товаров*/
    public function get_images($filter = array()) {
        $id_filter = '';
        $product_id_filter = '';
        
        if(!empty($filter['product_id'])) {
            $product_id_filter = $this->db->placehold('AND i.product_id in(?@)', (array)$filter['product_id']);
        }
        
        if(!empty($filter['id'])) {
            $id_filter = $this->db->placehold('AND i.id in(?@)', (array)$filter['id']);
        }
        
        // images
        $query = $this->db->placehold("SELECT 
                i.id, 
                i.product_id, 
                i.name, 
                i.filename, 
                i.position
            FROM __images AS i 
            WHERE 
                1 
                $id_filter
                $product_id_filter 
            ORDER BY i.product_id, i.position
        ");
        $this->db->query($query);
        return $this->db->results();
    }
    
    public function get_images_new($filter = array()) {
        $id_filter = '';
        $product_id_filter = '';
        
        if(!empty($filter['sku'])) {
            $product_id_filter = $this->db->placehold('AND i.sku in(?@)', (array)$filter['sku']);
        }
        
        if(!empty($filter['id'])) {
            $id_filter = $this->db->placehold('AND i.id in(?@)', (array)$filter['id']);
        }
        
        // images
        $query = $this->db->placehold("SELECT 
                i.id, 
                i.sku, 
                i.name, 
                i.filename, 
                i.position
            FROM __sku_images AS i 
            WHERE 
                1 
                $id_filter
                $product_id_filter 
            ORDER BY i.sku, i.position
        ");
        
        $this->db->query($query);
        return $this->db->results();
        
    }
    

    /*Добавление изображений товаров*/
    public function add_image($product_id, $filename, $name = '') {
        $query = $this->db->placehold("SELECT id FROM __images WHERE product_id=? AND filename=?", $product_id, $filename);
        $this->db->query($query);
        $id = $this->db->result('id');
        if(empty($id)) {
            $query = $this->db->placehold("INSERT INTO __images SET product_id=?, filename=?", $product_id, $filename);
            $this->db->query($query);
            $id = $this->db->insert_id();
            $query = $this->db->placehold("UPDATE __images SET position=id WHERE id=?", $id);
            $this->db->query($query);
        }
        return($id);
    }
    
    /*Добавление изображений товаров*/
    public function add_image_new($sku, $filename, $name = '') {
        $query = $this->db->placehold("SELECT id FROM __sku_images WHERE sku=? AND filename=?", $sku, $filename);
        $this->db->query($query);
        $id = $this->db->result('id');
        if(empty($id)) {
            $query = $this->db->placehold("INSERT INTO __sku_images SET sku=?, filename=?", $sku, $filename);
            $this->db->query($query);
            $id = $this->db->insert_id();
            $query = $this->db->placehold("UPDATE __sku_images SET position=id WHERE id=?", $id);
            $this->db->query($query);
        }
        return($id);
    }

    /*Обновление изображений*/
    public function update_image($id, $image) {
        $query = $this->db->placehold("UPDATE __images SET ?% WHERE id=?", $image, $id);
        $this->db->query($query);
        return($id);
    }
    
    /*Обновление изображений*/
    public function update_image_new($id, $image) {
        $query = $this->db->placehold("UPDATE __sku_images SET ?% WHERE id=?", $image, $id);
        $this->db->query($query);
        return($id);
    }

    /*Удаление изображений*/
    public function delete_image($id) {
        $query = $this->db->placehold("SELECT filename FROM __images WHERE id=?", $id);
        $this->db->query($query);
        $filename = $this->db->result('filename');
        $query = $this->db->placehold("DELETE FROM __images WHERE id=? LIMIT 1", $id);
        $this->db->query($query);
        $query = $this->db->placehold("SELECT count(*) as count FROM __images WHERE filename=? LIMIT 1", $filename);
        $this->db->query($query);
        $count = $this->db->result('count');
        if($count == 0) {
            $file = pathinfo($filename, PATHINFO_FILENAME);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            
            // Удалить все ресайзы
            $rezised_images = glob($this->config->root_dir.$this->config->resized_images_dir.$file.".*x*.".$ext);
            if(is_array($rezised_images)) {
                foreach ($rezised_images as $f) {
                    @unlink($f);
                }
            }
            
            @unlink($this->config->root_dir.$this->config->original_images_dir.$filename);
        }
    }
    /*Удаление изображений*/
    public function delete_image_new($id) {
        $query = $this->db->placehold("SELECT filename FROM __sku_images WHERE id=?", $id);
        $this->db->query($query);
        $filename = $this->db->result('filename');
        $query = $this->db->placehold("DELETE FROM __sku_images WHERE id=? LIMIT 1", $id);
        $this->db->query($query);
        $query = $this->db->placehold("SELECT count(*) as count FROM __sku_images WHERE filename=? LIMIT 1", $filename);
        $this->db->query($query);
        $count = $this->db->result('count');
        if($count == 0) {
            $file = pathinfo($filename, PATHINFO_FILENAME);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            // Удалить все ресайзы
            $rezised_images = glob($this->config->root_dir.$this->config->resized_images_dir.$file.".*x*.".$ext);
            if(is_array($rezised_images)) {
                foreach ($rezised_images as $f) {
                    @unlink($f);
                }
            }
            @unlink($this->config->root_dir.$this->config->original_images_dir.$filename);
        }
    }

    /*Выборка "соседних" товаров*/
    public function get_neighbors_products($category_id, $position) {
        $pids = array();
        // следующий товар
        $query = "SELECT id
FROM ok_products p
INNER JOIN ok_products_categories pc ON pc.product_id = p.id
AND pc.category_id = {$category_id}
WHERE p.position > {$position}
AND pc.position = (
SELECT MIN( pc2.position )
FROM ok_products_categories pc2
WHERE pc.product_id = pc2.product_id )
AND p.visible
ORDER BY p.position
LIMIT 1";
        $this->db->query($query);
        $pid = $this->db->result('id');
        if ($pid) {
            $pids[$pid] = 'prev';
        }
        // предыдущий товар
        
        $query = "SELECT id
FROM ok_products p
INNER JOIN ok_products_categories pc ON pc.product_id = p.id
AND pc.category_id = {$category_id}
WHERE p.position < {$position}
AND pc.position = (
SELECT MIN( pc2.position )
FROM ok_products_categories pc2
WHERE pc.product_id = pc2.product_id )
AND p.visible
ORDER BY p.position DESC
LIMIT 1";
        $this->db->query($query);
        $pid = $this->db->result('id');
        if ($pid) {
            $pids[$pid] = 'next';
        }

        $result = array('next'=>'', 'prev'=>'');
        if (!empty($pids)) {
            foreach ($this->get_products(array('id'=>array_keys($pids))) as $p) {
                $result[$pids[$p->id]] = $p;
            }
        }
        return $result;
    }

    /*Дублирование мультиязычного контента товара*/
    public function multi_duplicate_product($id, $new_id) {
        $lang_id = $this->languages->lang_id();
        if (!empty($lang_id)) {
            $languages = $this->languages->get_languages();
            $prd_fields = $this->languages->get_fields('products');
            $variant_fields = $this->languages->get_fields('variants');
            foreach ($languages as $language) {
                if ($language->id != $lang_id) {
                    $this->languages->set_lang_id($language->id);
                    //Product
                    if (!empty($prd_fields)) {
                        $old_prd = $this->get_product($id);
                        $upd_prd = new stdClass();
                        foreach($prd_fields as $field) {
                            $upd_prd->{$field} = $old_prd->{$field};
                        }
                        $this->update_product($new_id, $upd_prd);
                    }
                    
                    // Дублируем варианты
                    if (!empty($variant_fields)) {
                        $variants = $this->variants->get_variants(array('product_id'=>$new_id));
                        $old_variants = $this->variants->get_variants(array('product_id'=>$id));
                        foreach($old_variants as $i=>$old_variant) {
                            $upd_variant = new stdClass();
                            foreach ($variant_fields as $field) {
                                $upd_variant->{$field} = $old_variant->{$field};
                            }
                            $this->variants->update_variant($variants[$i]->id, $upd_variant);
                        }
                    }
                    
                    $this->languages->set_lang_id($lang_id);
                }
            }
        }
    }

    /*Выборка промо-изображений*/
    public function get_spec_images() {
        $query = $this->db->placehold("SELECT id, filename, position FROM __spec_img ORDER BY position ASC");
        $this->db->query($query);
        $res = $this->db->results();
        if(!empty($res)){
            return $res;
        } else {
            return array();
        }
    }

    /*Удаление промо-изображений*/
    public function delete_spec_image($image_id) {
        if(empty($image_id)){
            return false;
        }
        $query = $this->db->placehold("SELECT filename FROM __spec_img WHERE id =?", intval($image_id));
        $this->db->query($query);
        $filename = $this->db->result('filename');
        unlink($this->config->root_dir.$this->config->special_images_dir.$filename);
        $this->db->query("DELETE FROM __spec_img WHERE id=? LIMIT 1", intval($image_id));
        $this->db->query("UPDATE __products SET special=NULL WHERE special=?", $filename);
        $this->db->query("UPDATE __lang_products SET special=NULL WHERE special=?", $filename);
        return true;
    }

    /*Обновление промо-изображений*/
    public function update_spec_images($id, $spec_image){
        if(empty($id) || empty($spec_image)){
            return false;
        }
        $spec_image = (array)$spec_image;
        $query = $this->db->placehold("UPDATE __spec_img SET ?% WHERE id=?", $spec_image, $id);
        $this->db->query($query);
        return $id;
    }

    /*Добавление промо-изображений*/
    public function add_spec_image($image) {
        if(empty($image)){
            return false;
        }
        $query = $this->db->query("INSERT INTO __spec_img SET filename = ?", $image);
        $this->db->query($query);
        $id = $this->db->insert_id();
        $this->db->query("UPDATE __spec_img SET position=id WHERE id=?", $id);
        return $id;
    }

}

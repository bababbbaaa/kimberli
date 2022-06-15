<?php
define('RU', 1);
define('UA', 3);
define('EN', 2);

class Insertions extends Okay
{

    public function get_filters($filter = array())
    {
        $category_id_filter = '';
        $without_category_filter = '';
        $brand_id_filter = '';
        $product_id_filter = '';
        $keyword_filter = '';
        $visible_filter = '';
        $is_featured_filter = '';
        $in_stock_filter = '';
        $has_images_filter = '';
        $feed_filter = '';
        $discounted_filter = '';
        $features_filter = '';

        $lang_id = $this->languages->lang_id();
        $px = ($lang_id ? 'l' : 'p');

        if (!empty($filter['category_id'])) {
            $category_id_filter = $this->db->placehold('INNER JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id in(?@)', (array)$filter['category_id']);
        }

        if (isset($filter['without_category'])) {
            $without_category_filter = $this->db->placehold('AND (SELECT count(*)=0 FROM ok_products_categories pc WHERE pc.product_id=p.id) = ?', intval($filter['without_category']));
        }


        if (!empty($filter['id'])) {
            $product_id_filter = $this->db->placehold('AND p.id in(?@)', (array)$filter['id']);
        }


        if (isset($filter['featured'])) {
            $is_featured_filter = $this->db->placehold('AND p.featured=?', intval($filter['featured']));
        }


        $price_filter = '';
        $select = 'GROUP_CONCAT(distinct p.id) as ids';
        $currency_join = '';

        $first_currency = $this->money->get_currencies(array('enabled' => 1));
        $first_currency = reset($first_currency);
        $coef = 1;
        if (isset($_SESSION['currency_id']) && $first_currency->id != $_SESSION['currency_id']) {
            $currency = $this->money->get_currency(intval($_SESSION['currency_id']));
            $coef = $currency->rate_from / $currency->rate_to;
        }


        if (isset($filter['visible'])) {
            $visible_filter = $this->db->placehold('AND p.visible=?', intval($filter['visible']));
        }

        if (!empty($filter['features'])) {
            foreach ($filter['features'] as $feature => $value) {
                $features_filter .= $this->db->placehold('AND p.id in (SELECT product_id FROM ok_options WHERE feature_id=? AND translit in(?@) ) ', $feature, (array)$value);
            }
        }

        $lang_sql = $this->languages->get_query(array('object' => 'product'));
        $query = "SELECT $select
			FROM ok_products AS p
			$lang_sql->join
			$category_id_filter
			$feed_filter
			$currency_join
			WHERE 
				1
				$brand_id_filter
				$without_category_filter
				$product_id_filter
				$keyword_filter
				$is_featured_filter
				$in_stock_filter
				$has_images_filter
				$discounted_filter
				$visible_filter
				$features_filter
				$price_filter
		";
        $this->db->query($query);


        return $this->insertions->get_insertions(array('products_id' => $this->db->result('ids')));

    }

    /*Выборка вариантов*/
    public function get_insertions($filter = [])
    {
        $product_id_filter = '';
        $insertion_id_filter = '';
        $lang_id = $this->languages->lang_id();

        if (!empty($filter['product_id'])) {
            $product_id_filter = $this->db->placehold('AND vp.product_id in(?@)', (array)$filter['product_id']);
        }

        if (!empty($filter['id'])) {
            $insertion_id_filter = $this->db->placehold('AND v.id in(?@)', (array)$filter['id']);
        }

        $query = $this->db->placehold("SELECT 
                v.id, 
                v.translit,
                v.title as `value`,
                count(vp.product_id) as count
               
            FROM ok_insertions AS v
            	INNER JOIN ok_variants vp ON vp.sku = v.shtr
            WHERE
                v.`lang_id` = {$lang_id}
                  AND v.title != ''
                $product_id_filter
                $insertion_id_filter
            GROUP BY v.translit
        ", $this->settings->max_order_amount);
            //  print_r($query); 
        $this->db->query($query);
        $insertions = $this->db->results();
        return $insertions;

    }

    public function get_insertions_admin($filter = array())
    {
        $product_id_filter = '';
        $insertion_id_filter = '';
        $lang_id = $this->languages->lang_id();

        if (!empty($filter['product_id'])) {
            $product_id_filter = $this->db->placehold('AND vp.product_id in(?@)', (array)$filter['product_id']);
        }

        if (!empty($filter['id'])) {
            $insertion_id_filter = $this->db->placehold('AND v.id in(?@)', (array)$filter['id']);
        }

        $query = $this->db->placehold("SELECT 
                v.id, 
                v.translit,
                v.name,
                v.count,
                v.title,
                v.form,
                v.mass,
                vp.product_id
            FROM ok_insertions AS v
				INNER JOIN ok_variants vp ON vp.sku = v.shtr
            WHERE
                v.`lang_id` = {$lang_id}
                  AND v.title != ''
                $product_id_filter
                $insertion_id_filter
        ", $this->settings->max_order_amount);
              //  print_r($query); 
        $this->db->query($query);
        $insertions = $this->db->results();
        return $insertions;

    }

	public function get_insertions_shtr($filter = array())
	{
		//l($filter);
		$shtr_filter = '';
		$insertion_id_filter = '';

		$lang_id = $this->languages->lang_id();

		if (!empty($filter['shtr'])) {
			if (is_array($filter['shtr'])) {
				$ids = implode(',',$filter['shtr']);
			} else {
				$ids = (int) $filter['shtr'];
			}

			$shtr_filter = " AND v.shtr in({$ids}) ";
			//$product_id_filter = $this->db->placehold('AND v.product_id in(?@)', (array)$filter['product_id']);
		}

		if (!empty($filter['id'])) {
			$insertion_id_filter = $this->db->placehold('AND v.id in(?@)', (array)$filter['id']);
		}

		$query = "SELECT 
                v.id, 
                v.translit,
                v.name,
                v.count,
                v.title,
                v.form,
                v.mass,
                v.shtr,
       			vp.product_id
            FROM ok_insertions AS v
				INNER JOIN ok_variants vp ON vp.sku = v.shtr
            WHERE
                v.`lang_id` = {$lang_id}
                  AND v.title != ''
                $shtr_filter
                $insertion_id_filter
        ";

		$this->db->query($query);

		return $this->db->results();

	}

    /*Выборка конкретного варианта*/
    public function get_insertion($id)
    {
        if (empty($id)) {
            return false;
        }
        $insertion_id_filter = $this->db->placehold('AND v.id=?', intval($id));

        $query = $this->db->placehold("SELECT 
                v.id, 
                vp.product_id,
				v.name,
				v.form,
				v.count
            FROM ok_insertions v
				INNER JOIN ok_variants vp ON vp.sku = v.shtr
            WHERE 
                1 
                $insertion_id_filter 
            LIMIT 1
        ", $this->settings->max_order_amount);

        $this->db->query($query);
        $insertions = $this->db->result();
        return $insertions;
    }

    public function update_insertion($id, $insertion)
    {

        $v = (array)$insertion;
        if (!empty($v)) {
            $query = $this->db->placehold("UPDATE ok_insertions SET ?% WHERE id=? LIMIT 1", $insertion, intval($id));
            $this->db->query($query);
        }


        return $id;
    }

    private $insertionsLang = array(
        RU => [
            'ametist' => 'Аметист',
            'brilliant' => 'Бриллиант',
            'rubin' => 'Рубин',
            'sapfir' => 'Сапфир',
            'korall' => 'Коралл',
            'biryuza' => 'Бирюза',
            'goryachayaemal' => 'Горячая эмаль',
            'serebro' => 'Серебро',
            'izumrud' => 'Изумруд',
            'zhemchug' => 'Жемчуг',
            'tsitrin' => 'Цитрин',
            'limonnyjkvarts' => 'Лимонный кварц',
            'granat' => 'Гранат',
            'kvarts' => 'Кварц',
            'peridot' => 'Перидот',
            'topaz' => 'Топаз',
            'haltsedon' => 'Халцедон',
            'gornyjhrustal' => 'Горный хрусталь',
            'praziolit' => 'Празиолит',
            'turmalin' => 'Турмалин',
            'tsavorit' => 'Цаворит',
            'perlamutr' => 'Перламутр'
            ],
        UA => [
            'ametist' => 'Аметист',
            'brilliant' => 'Діамант',
            'rubin' => 'Рубін',
            'sapfir' => 'Сапфір',
            'korall' => 'Корал',
            'biryuza' => 'Бірюза',
            'goryachayaemal' => 'Гаряча емаль',
            'serebro' => 'Срібло',
            'izumrud' => 'Смарагд',
            'zhemchug' => 'Перли',
            'tsitrin' => 'Цитрин',
            'limonnyjkvarts' => 'Лимонний кварц',
            'granat' => 'Гранат',
            'kvarts' => 'Кварц',
            'peridot' => 'Перідот',
            'topaz' => 'Топаз',
            'haltsedon' => 'Халцедон',
            'gornyjhrustal' => 'Горний кришталь',
            'praziolit' => 'Празиолит',
            'turmalin' => 'Турмалін',
            'tsavorit' => 'Цаворіт',
            'perlamutr' => 'Перламутр'
            ],
        EN => [
            'ametist' => 'Amethyst',
            'brilliant' => 'Diamond',
            'rubin' => 'Ruby',
            'sapfir' => 'Sapphire',
            'korall' => 'Coral',
            'biryuza' => 'Turquoise',
            'goryachayaemal' => 'Hot enamel',
            'serebro' => 'Silver',
            'izumrud' => 'Emerald',
            'zhemchug' => 'Pearls',
            'tsitrin' => 'Citrine',
            'limonnyjkvarts' => 'Lemon Quartz',
            'granat' => 'Garnet',
            'kvarts' => 'Quartz',
            'peridot' => 'Peridot',
            'topaz' => 'Topaz',
            'haltsedon' => 'Chalcedony',
            'gornyjhrustal' => 'Rhinestone',
            'praziolit' => 'Prasiolite',
            'turmalin' => 'Tourmaline',
            'tsavorit' => 'Tsavorite',
            'perlamutr' => 'Nacre'
        ]
    );

    private $insertionsMap = array(
        'Кр-57' => 'brilliant',
        'Аметист' => 'ametist',
        'Изумруд' => 'izumrud',
        'Рубин' => 'rubin',
        'Сапфир' => 'sapfir',
        'Ов-57' => 'brilliant',
        'Корал' => 'korall',
        'Гар. емаль' => 'goryachayaemal',
        'Серебро' => 'serebro',
        'Жемчуг' => 'zhemchug',
        'Цитрин' => 'tsitrin',
        'Кварц лимон' => 'limonnyjkvarts',
        'Гранат' => 'granat',
        'Кварц' => 'kvarts',
        'Перидот' => 'peridot',
        'Топаз' => 'topaz',
        'Бирюза' => 'biryuza',
        'горн хрусталь' => 'gornyjhrustal',
        'Халцедон' => 'haltsedon',
        'Празиолiт' => 'praziolit',
        'Турмалин' => 'turmalin',
        'Цаворит' => 'tsavorit',
        '3/4 1.10' => 'brilliant',
        'Перламутр' => 'perlamutr',
        'рубін' => 'rubin',
        'Пр-57' => 'brilliant'
    );

    public function add_insertion($insertion)
    {
        $insertion = (object)$insertion;

        foreach ($this->insertionsMap as $hayStack => $translit) {
            if (strpos($insertion->name, $hayStack) !== false) {
                $insertion->translit = $translit;
                break;
            }
        }
        $insertion->title = $this->insertionsLang[$insertion->lang_id][$insertion->translit];

        $query = $this->db->placehold("INSERT INTO ok_insertions SET ?%", $insertion);
        $this->db->query($query);
        $insertion_id = $this->db->insert_id();
        return $insertion_id;
    }

    public function delete_insertion($id)
    {
        if (!empty($id)) {
            $query = $this->db->placehold("DELETE FROM ok_insertions WHERE id = ? LIMIT 1", intval($id));
            $this->db->query($query);
        }
    }


}

<?php

require_once('Okay.php');

class Compilations extends Okay {

    /*Выбираем все товары*/
  /*  public function getCompilationProducts($filter = []) {
        $limit = 100;  // По умолчанию
        $page = 1;
        $compilation_id_filter = '';
        $compilation_product_id_filter = '';
        $active_filter = '';
        $group_by = '';
        
        $order = 'cp.product_id DESC';
        
        if(isset($filter['limit'])) {
            $limit = max(1, intval($filter['limit']));
        }
        
        if(isset($filter['page'])) {
            $page = max(1, intval($filter['page']));
        }
        
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);
        
        if(!empty($filter['id'])) {
            $compilation_product_id_filter = $this->db->placehold('AND cp.id in(?@)', (array)$filter['id']);
        }
        
        if(!empty($filter['compilation_id'])) {
            $compilation_id_filter = $this->db->placehold('AND cp.compilation_id in(?@)', (array)$filter['compilation_id']);
        }
        
        if(isset($filter['active'])) {
            $active_filter = $this->db->placehold('AND bi.active=?', intval($filter['active']));
        }
        
        if(!empty($filter['sort'])) {
            switch ($filter['sort']) {
                case 'product':
                    $order = 'cp.product_id DESC';
                    break;
            }
        }
        
        $query = "SELECT 
                cp.id, 
                cp.banner_id, 
                cp.compilation_id, 
                cp.product_id, 
                cp.active
            FROM __compilation_product cp
            WHERE 
                1 
                $compilation_product_id_filter 
                $compilation_id_filter 
                $active_filter 
            $group_by
            ORDER BY $order 
            $sql_limit
        ";
        
        $this->db->query($query);
        return $this->db->results();
    }*/
    
    public function getCompilationProductsIds($compilation_id = null)
    {
        $result = [];
       
        if (null === $compilation_id) {
            return [];
        }
        
        $query = "SELECT cp.product_id 
                FROM ok_compilation_product cp
                inner join ok_compilations as c ON c.compilation_id = cp.compilation_id
                WHERE 1 and c.visible = 1 and c.compilation_id = {$compilation_id}";
        try {
        $this->db->query($query);
        
        foreach($this->db->results() as $product) {
            $result[] = $product->product_id;
        }
        } catch (Exception $e) {
           
        }

        return $result;
    }
    
    public function getCompilationProducts($compilation_id = null)
    {
        $compilation_items = [];
        $compilation_items_images_ids = [];
        if (null === $compilation_id) {
            return $compilation_items;
        }
        
        $product_ids = $this->getCompilationProductsIds($compilation_id);
        
        if (empty($product_ids)) {
            return $compilation_items;
        }
        
         $products_array = $this->products->get_products(['id' => $product_ids]);
         
                        foreach($products_array as $p) {
                            $compilation_items[$p->id] = $p;
                            $compilation_items_images_ids[] = $p->main_image_id;
                        }
                        
        if(!empty($compilation_items)) {
            // Товары
            $products_ids = array_keys($compilation_items);
            foreach($compilation_items as &$product) {
                $product->variants = array();
                $product->properties = array();
            }
            
            $variants = $this->variants->get_variants(array('product_id'=>$products_ids));
            
            foreach($variants as $variant) {
                $compilation_items[$variant->product_id]->variants[] = $variant;
            }

            if (!empty($compilation_items_images_ids)) {
                $images = $this->products->get_images(array('id'=>$compilation_items_images_ids));
                foreach ($images as $image) {
                    if (isset($compilation_items[$image->product_id])) {
                        $compilation_items[$image->product_id]->image = $image;
                    }
                }
            }
            
        }
        
        return $compilation_items;
        
    }

    /*Подсчитываем количество найденных товаров*/
    public function getCountCompilationProducts($filter = []) {
        $compilation_id_filter = $compilation_product_id_filter = $active_filter = '';

        if(!empty($filter['compilation_id'])) {
            $compilation_id_filter = $this->db->placehold('AND cp.compilation_id in(?@)', (array)$filter['compilation_id']);
        }
        
        if(!empty($filter['id'])) {
            $compilation_product_id_filter = $this->db->placehold('AND cp.id in(?@)', (array)$filter['id']);
        }

        if(isset($filter['active'])) {
            $active_filter = $this->db->placehold('AND cp.active=?', intval($filter['active']));
        }
        $query = "SELECT count(distinct cp.id) as count 
            FROM __compilation_product AS cp
            WHERE 
                1 
                $compilation_id_filter 
                $compilation_product_id_filter 
                $active_filter 
        ";
        $this->db->query($query);
        return $this->db->result('count');
    }

    /*Выбираем конкретный товар*/
    public function getCompilationItems($id) {
        if(!is_int($id)) {
           return false;
        }
        $banner_id_filter = $this->db->placehold("AND cp.id=?", intval($id));
        
        //$lang_sql = $this->languages->get_query(array('object'=>'banner_image', 'px'=>'bi'));
        $query = $this->db->placehold("SELECT 
                bi.id, 
                bi.banner_id, 
                bi.image, 
                bi.position, 
                bi.visible, 
            FROM __ok_compilation_product cp
            WHERE 
                1 
                $banner_id_filter
            LIMIT 1
        ", $id);
        $this->db->query($query);
        $banners_image = $this->db->result();
        return $banners_image;
    }

    /*Добавление слайда*/
    public function addCompilationProduct($product) {

        if($this->db->query("INSERT INTO __compilation_product SET ?%", (object)$product)) {
            $id = $this->db->insert_id();
            $this->db->query("UPDATE __compilation_product SET position=id WHERE id=?", $id);
            return $id;
        } else {
            return false;
        }
    }

    /*Обновление слайда*/
    public function updateCompilationProduct($id, $product) {
        $query = $this->db->placehold("UPDATE __compilation_product SET ?% WHERE id in (?@) LIMIT ?", (object)$product, (array)$id, count((array)$id));
        if($this->db->query($query)) {
            return $id;
        } else {
            return false;
        }
    }

    /*Удаление слайда*/
    public function deleteCompilationProduct($id) {
        if(!empty($id)) {
            $query = $this->db->placehold("DELETE FROM __compilation_product WHERE id=? LIMIT 1", intval($id));
            if($this->db->query($query)) {
                return true;
            }
        }
        return false;
    }
    
    /*Удаление слайда*/
    public function deleteCompilationProducts($id) {
        if(!empty($id)) {
            $query = $this->db->placehold("DELETE FROM __compilation_product WHERE compilation_id=?", intval($id));
            if($this->db->query($query)) {
                return true;
            }
        }
        return false;
    }

    /*Выбираем все подборки*/
    public function getCompilations($filter = []) {
        $active_filter = '';
        $compilations = array();
        
        if(isset($filter['active'])) {
            $active_filter = $this->db->placehold('AND c.active = ?', intval($filter['active']));
        }
        
        $query = "SELECT c.*"
                . " FROM __compilations as c "
                . "WHERE 1 $active_filter "
                . "ORDER BY c.position";
        
        $this->db->query($query);
        foreach($this->db->results() as $compilation) {
            $compilations[$compilation->compilation_id] = $compilation;
        }
        
        $count = $this->getCountProduct(array_keys($compilations));
        
        foreach ($compilations as $k => $c) {
            $c->count = isset($count[$k]) ? $count[$k] : 0;
        }
        
        return $compilations;
    }
    
    public function getCountProduct($ids = [])
    {
        $query = "SELECT cp.`compilation_id`,  count(cp.id) as ctn"
                . " FROM __compilation_product as cp "
                . "WHERE 1 ".
                $this->db->placehold('AND cp.compilation_id in (?@) ', $ids)
                . " GROUP BY cp.`compilation_id`";

        $this->db->query($query);
        
        $result = [];
        $res = $this->db->results();
        if (!empty($res)) {
        foreach ($res as $r) {
            $result[$r->compilation_id] = $r->ctn;
        }
        }
        
        return $result;
    }

    /*Выбираем определенную подборку*/
    public function getCompilation($id, $show_filter_array = array()) {
        if (empty($id)) {
            return false;
        }
       
        $show_filter = $compilation_id_filter = '';
        
        if(is_int($id)) {
            $compilation_id_filter = $this->db->placehold('AND compilation_id=? ', intval($id));
        }
        
       /* if(!empty($show_filter_array)) {
            foreach($show_filter_array as $k=>$sfa) {
                if(empty($sfa)) {
                    unset($show_filter_array[$k]);
                    continue;
                }
                $show_filter_array[$k] = $this->db->placehold($k." regexp '[[:<:]](?)[[:>:]]'", intval($show_filter_array[$k]));
            }
            $show_filter_array[] = "show_all_pages=1";
            $show_filter = 'AND (' . implode(' OR ',$show_filter_array) . ')';
        }*/

     try {
         $query = $this->db->placehold("SELECT * FROM __compilations WHERE 1 $compilation_id_filter $show_filter LIMIT 1");
        $this->db->query($query);
        $compilation = $this->db->result();
     } catch (Exception $exc) {
        // echo $exc->getTraceAsString();
         $compilation = [];
     }
     
        return $compilation;
    }

    /*Обновляем подборку*/
    public function updateCompilation($id, $compilation)
    {
        $query = $this->db->placehold("UPDATE __compilations SET ?% WHERE compilation_id in (?@) LIMIT ?", $compilation, (array)$id, count((array)$id));
        if($this->db->query($query)) {
            return $id;
        } else {
            return false;
        }
    }

    /*Добавляем группу баннеров*/
    public function addCompilations($compilation)
    {
        if($this->db->query("INSERT INTO __compilations SET ?%", $compilation)) {
            $id = $this->db->insert_id();
            $this->db->query("UPDATE __compilations SET position=compilation_id WHERE compilation_id=?", $id);
            return $id;
        } else {
            return false;
        }
    }

    /*Удаляем подборку*/
    public function deleteCompilation($id)
    {
        if(!empty($id)) {
            $query = $this->db->placehold("DELETE FROM __compilations WHERE compilation_id=? LIMIT 1", intval($id));
            if($this->db->query($query)) {
                return true;
            }
        }
        return false;
    }
    
}

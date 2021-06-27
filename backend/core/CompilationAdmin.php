<?php

require_once('api/Okay.php');

class CompilationAdmin extends Okay {

    public function fetch() {
        $compilation = new stdClass();
        $compilation_items = [];
        $related_products = array();
        /*Принимаем данные о меню*/
        if($this->request->method('POST')) {
            $compilation->compilation_id = $this->request->post('compilation_id', 'integer');
            $compilation->name = $this->request->post('name');
            $compilation->visible = $this->request->post('visible', 'boolean');
            
        // Связанные товары
            if(is_array($this->request->post('related_products'))) {
                foreach($this->request->post('related_products') as $p) {
                    $rp[$p] = new stdClass;
                    $rp[$p]->compilation_id = $compilation->compilation_id;
                    $rp[$p]->product_id = $p;
                }
                $related_products = $rp;
            }

                /*Добавляем/обновляем подборку*/
                if (empty($compilation->compilation_id)) {
                   
                    $compilation->compilation_id = $this->compilation->addCompilations($compilation);
                    $this->design->assign('message_success', 'added');
                } else {
                    $this->compilation->updateCompilation($compilation->compilation_id, $compilation);
                    $this->design->assign('message_success', 'updated');
                }
                
                // Связанные товары
                $this->compilation->deleteCompilationProducts($compilation->compilation_id);
                if(is_array($related_products)) {
                    foreach($related_products  as $i=>$related_product) {
                        $this->compilation->addCompilationProduct($related_product);
                    }
                }
                
                if ($compilation->compilation_id) {
                    $compilation_items = $this->compilation->getCompilationProducts((int)$compilation->compilation_id);
                }
                
                $compilation = $this->compilation->getCompilation($compilation->compilation_id);
                
        } else {
            /*Отображение меню*/
            $id = $this->request->get('id', 'integer');
            if(!empty($id)) {
                $compilation = $this->compilation->getCompilation((int)$id);
                if (!empty($compilation->compilation_id)) {
                    
                    $compilation_items = $this->compilation->getCompilationProducts((int)$compilation->compilation_id);
                    
                    
                   /* $compilation_products_ids = $this->compilation->getCompilationProductsIds((int)$compilation->compilation_id);
                    
                    if (!empty($compilation_products_ids)) {
                        
                        $products_array = $this->products->get_products(['id' => $compilation_products_ids]);
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
                    }*/
                }
            } else {
                $compilation->visible = 1;
            }
        }
        $this->design->assign('compilation', $compilation);
        $this->design->assign('compilation_items', $compilation_items);
        return $this->design->fetch('compilation.tpl');
    }

    private function build_tree($items) {
        $tree = new stdClass();
        $tree->submenus = array();

        // Указатели на узлы дерева
        $pointers = array();
        $pointers[0] = &$tree;

        $finish = false;
        // Не кончаем, пока не кончатся элементы, или пока ниодну из оставшихся некуда приткнуть
        while (!empty($items) && !$finish) {
            $flag = false;
            // Проходим все выбранные элементы
            foreach ($items as $k => $item) {
                if (isset($pointers[$item->parent_index])) {
                    // В дерево элементов меню (через указатель) добавляем текущий элемент
                    $pointers[$item->index] = $pointers[$item->parent_index]->submenus[] = $item;

                    // Убираем использованный элемент из массива
                    unset($items[$k]);
                    $flag = true;
                }
            }
            if (!$flag) $finish = true;
        }
        unset($pointers[0]);
        return $tree->submenus;
    }

}

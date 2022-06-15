<?php

require_once('View.php');

class PageView extends View {

    /*Отображение страниц сайта*/
    public function fetch() {
        $url = $this->request->get('page_url', 'string');
        $page = $this->pages->get_page($url);
        
        // Отображать скрытые страницы только админу
        if((empty($page) || (!$page->visible && empty($_SESSION['admin']))) && $url != '404') {
            return false;
        }
        
        //lastModify
        if ($page->url != '404') {
            $this->setHeaderLastModify($page->last_modify);
        }
        
        switch ($url) {
        case 'atelier': 
           // $this->design->assign('dop_files_header', $this->design->fetch('dop_files_header.tpl'));
           // $footer = $this->design->fetch('dop_files_header.tpl');
            $footer = $this->design->fetch('callback_page.tpl');
            $this->design->assign('dop_files_footer', $footer);
            break;
			default : break;
        }

      if (file_exists(BASE_DIR . '/design/kimberli/html/page/' .$this->language->label . '/' . $url . '.tpl')) {

		  switch($url) {
			  case 'vacancy':

				  $vacancies = $this->vacancy->get_vacancies(['visible' => 1]);
				  $this->design->assign('vacancies', $vacancies);
				  break;
			  default : break;
		  }

		  $page->content = $this->design->fetch('page/' . $this->language->label . '/'. $url . '.tpl');
		}
        
        if (!empty($page->compilation_id)) {
            
            $compilation = $this->compilation->getCompilationProductsIds($page->compilation_id);
            
            if (!empty($compilation)) {
                
        // Товары
        $products = array();
        foreach($this->products->get_products(['id' => $compilation, 'in_stock' => 1]) as $p) {
            $products[$p->id] = $p;
        }
        
        if(!empty($products)) {
            $products_ids = array_keys($products);
            $images_ids = array();
            foreach($products as $product) {
                $product->variants = array();
                $product->properties = array();
                $images_ids[] = $product->main_image_id;
            }

            $variants = $this->variants->get_variants(array('product_id'=>$products_ids));

            foreach($variants as $variant) {
                $products[$variant->product_id]->variants[] = $variant;
            }

            if (!empty($images_ids)) {
                $images = $this->products->get_images(array('id'=>$images_ids));
                foreach ($images as $image) {
                    $products[$image->product_id]->image = $image;
                }
            }

            foreach($products as $product) {
                if(isset($product->variants[0])) {
                    $product->variant = $product->variants[0];
                }
            }
            $this->design->assign('compilation', $products);
        }
            }  
        }
        
        $this->design->assign('page', $page);
        $this->design->assign('meta_title', $page->meta_title);
        $this->design->assign('meta_keywords', $page->meta_keywords);
        $this->design->assign('meta_description', $page->meta_description);
        
        return $this->design->fetch('page.tpl');
    }
    
}

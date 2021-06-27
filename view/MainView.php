<?php

require_once('View.php');

class MainView extends View {

    /*Отображение контента главной страницы*/
    public function fetch() {
        if($this->page) {
            $this->design->assign('meta_title', $this->page->meta_title);
            $this->design->assign('meta_keywords', $this->page->meta_keywords);
            $this->design->assign('meta_description', $this->page->meta_description);
        }
        
        $baner = "desctop";
        if ($this->design->is_mobile() || $this->design->is_tablet()) {
            $baner = "mobile";
        }
        
        $this->design->assign('full_banner', $this->design->fetch("banners/{$baner}/full_page_banner.tpl"));
        $this->design->assign('collection', $this->design->fetch("banners/{$baner}/collections.tpl"));
        $this->design->assign('pages_banner', $this->design->fetch("banners/{$baner}/page.tpl"));
        $this->design->assign('kamni', $this->design->fetch("banners/{$baner}/kamni.tpl"));
        
        return $this->design->fetch('main.tpl');
    }
    
}

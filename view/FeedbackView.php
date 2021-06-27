<?php

require_once('View.php');

class FeedbackView extends View {
    
    public function fetch() {
        if($this->page) {
            $this->design->assign('meta_title', $this->page->meta_title);
            $this->design->assign('meta_keywords', $this->page->meta_keywords);
            $this->design->assign('meta_description', $this->page->meta_description);
            $this->design->assign('feedback_form', $this->design->fetch('feedback_form.tpl'));
        }
        
        $body = $this->design->fetch('feedback.tpl');
        return $body;
    }
    
}

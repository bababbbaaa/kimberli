<?php

require_once('api/Okay.php');

class CompilationsAdmin extends Okay {

    public function fetch() {
        /*Принимаем выбранные подборки*/
        if($this->request->method('post')) {
            $ids = $this->request->post('check');
            if(is_array($ids)) {
                switch($this->request->post('action')) {
                    case 'disable': {
                        /*Выключаем меню*/
                        foreach($ids as $id) {
                            $this->compilation->updateCompilation($id, array('active'=>0));
                        }
                        break;
                    }
                    case 'enable': {
                        /*Включаем меню*/
                        foreach($ids as $id) {
                            $this->compilation->updateCompilation($id, array('active'=>1));
                        }
                        break;
                    }
                    case 'delete': {
                        /*Удаляем меню*/
                        foreach ($ids as $id) {
                            $this->compilation->deleteCompilation($id);
                        }
                        break;
                    }
                }
            }

            // Сортировка
           /* $positions = $this->request->post('positions');
            $ids = array_keys($positions);
            sort($positions);
            foreach($positions as $i=>$position) {
                $this->compilations->updateCompilation($ids[$i], array('position'=>$position));
            }*/
        }

        $compilations = $this->compilation->getCompilations();
        $this->design->assign('compilations', $compilations);
        return $this->design->fetch('compilations.tpl');
    }

}

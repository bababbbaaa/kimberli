<?php

require_once('api/Okay.php');

class VacanciesAdmin extends Okay {
    
    public function fetch() {
        // Обработка действий
        if($this->request->method('post')) {
            // Сортировка
            $positions = $this->request->post('positions');
            $ids = array_keys($positions);
            sort($positions);
            foreach($positions as $i=>$position) {
                $this->vacancy->update_vacancy($ids[$i], array('position'=>$position));
            }

            // Действия с выбранными
            $ids = $this->request->post('check');
            if(is_array($ids)) {
                switch($this->request->post('action')) {
                    case 'disable': {
                        /*Выключить страницу*/
                        $this->vacancy->update_vacancy($ids, array('visible'=>0));
                        break;
                    }
                    case 'enable': {
                        /*Включить страницу*/
                        $this->vacancy->update_vacancy($ids, array('visible'=>1));
                        break;
                    }
                    case 'delete': {
                        /*Удалить страницу*/
                        foreach($ids as $id) {
                            if (!$this->vacancy->delete_vacancy($id)) {
                                $this->design->assign('message_error', 'url_system');
                            }
                        }
                        break;
                    }
                }
            }
        }
        
        // Отображение
        $vacancies = $this->vacancy->get_vacancies();
        
        $this->design->assign('vacancies', $vacancies);
        return $this->design->fetch('vacancies.tpl');
    }
    
}

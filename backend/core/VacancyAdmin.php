<?php

require_once('api/Okay.php');

class VacancyAdmin extends Okay {
    
    public function fetch() {
		$vacancy = new stdClass;
        /*Прием информации о страницу*/
        if($this->request->method('POST')) {
			$vacancy->id = $this->request->post('id', 'integer');
			$vacancy->name = $this->request->post('name');
			$vacancy->description = $this->request->post('description');
			$vacancy->visible =  $this->request->post('visible', 'boolean');
			$vacancy->experience = $this->request->post('experience');
			$vacancy->schedule = $this->request->post('schedule');
			$vacancy->city = $this->request->post('city');
			$vacancy->date_vacancy = date('Y-m-d', strtotime($this->request->post('date_vacancy')));
			$vacancy->responsibilities = $this->request->post('responsibilities');
			$vacancy->offer = $this->request->post('offer');
			$vacancy->required_skills = $this->request->post('required_skills');
			$vacancy->extra_skills = $this->request->post('extra_skills');

                /*Добавление/Обновление страницы*/
                if(empty($vacancy->id)) {
					$vacancy->id = $this->vacancy->add_vacancy($vacancy);
					$vacancy = $this->vacancy->get_vacancy($vacancy->id);
                    $this->design->assign('message_success', 'added');
                } else {
                    $this->vacancy->update_vacancy($vacancy->id, $vacancy);
					$vacancy = $this->vacancy->get_vacancy($vacancy->id);
                    $this->design->assign('message_success', 'updated');
                }



        } else {
            $id = $this->request->get('id', 'integer');
            if(!empty($id)) {
				$vacancy = $this->vacancy->get_vacancy(intval($id));

            } else {
				$vacancy->visible = 1;
            }
        }
        
        //$this->design->assign('compilations', $this->compilation->getCompilations());
        $this->design->assign('vacancy', $vacancy);
        return $this->design->fetch('vacancy.tpl');
    }
    
}

<?php
namespace rest\api;

/**
 * Class Vacancy
 */
class Vacancy extends Okay {

	public function __construct()
	{
		parent::__construct();
	}

    /*Выборка конкрентной вакансии*/
    public function get_vacancy($id) {
       $where = $this->db->placehold('AND v.id=? ', intval($id));
        
        $lang_sql = $this->languages->get_query(array('object'=>'vacancy'));
        
        $query = "SELECT 
                v.id, 
                v.visible, 
                v.date_vacancy,
       			v.position,
                $lang_sql->fields
            FROM __vacancy v 
            $lang_sql->join 
            WHERE 
                1 
                $where 
            LIMIT 1
        ";
        
        $this->db->query($query);

        return $this->db->result();
    }

    /*Выборка всех страниц*/
    public function get_vacancies($filter = array()) {
        $visible_filter = '';
        $vacancies = [];
        
        if(isset($filter['visible'])) {
            $visible_filter = $this->db->placehold('AND v.visible = ?', intval($filter['visible']));
        }
        
        $lang_sql = $this->languages->get_query(array('object'=>'vacancy'));
        $query = "SELECT 
                v.id, 
                v.visible, 
                v.date_vacancy,
       			v.position,
                $lang_sql->fields
            FROM __vacancy v 
            $lang_sql->join 
            WHERE 
                1 
                $visible_filter 
            ORDER BY v.position
        ";
        $this->db->query($query);

        foreach($this->db->results() as $vacancy) {
			$vacancies[$vacancy->id] = $vacancy;
        }

        return $vacancies;
    }
    
    /*Добавление страницы*/
    public function add_vacancy($vacancy) {
        $vacancy = (object)$vacancy;

        $vacancyAll =  new stdClass;
		$vacancyAll->visible = $vacancy->visible;
		$vacancyAll->date_vacancy = $vacancy->date_vacancy;


        // Проверяем есть ли мультиязычность и забираем описания для перевода
        $result = $this->languages->get_description($vacancy, 'vacancy');

        $query = $this->db->placehold('INSERT INTO __vacancy SET ?%', $vacancyAll);

        if(!$this->db->query($query)) {
            return false;
        }
        
        $id = $this->db->insert_id();
        
        // Если есть описание для перевода. Указываем язык для обновления
        if(!empty($result->description)) {
            $this->languages->action_description($id, $result->description, 'vacancy');
        }
        
        $this->db->query("UPDATE __vacancy SET position=id WHERE id=?", $id);

        return $id;
    }

    /*Обновление страницы*/
    public function update_vacancy($id, $vacancy) {
        $vacancy = (object)$vacancy;
        // Проверяем есть ли мультиязычность и забираем описания для перевода
        $result = $this->languages->get_description($vacancy, 'vacancy');

		$vacancyAll =  new stdClass;
		$vacancyAll->visible = $vacancy->visible;
		$vacancyAll->date_vacancy = $vacancy->date_vacancy;

        $query = $this->db->placehold('UPDATE __vacancy SET ?% WHERE id in (?@)', $vacancyAll, (array)$id);
        if(!$this->db->query($query)) {
            return false;
        }
        
        // Если есть описание для перевода. Указываем язык для обновления
        if(!empty($result->description)) {
            $this->languages->action_description($id, $result->description, 'vacancy', $this->languages->lang_id());
        }
        
        return $id;
    }

    /*Удаление страницы*/
    public function delete_vacancy($id) {
        if(!empty($id)) {
            // Запретим удаление системных ссылок
            $vacancy = $this->get_page(intval($id));

            $query = $this->db->placehold("DELETE FROM __vacancy WHERE id=? LIMIT 1", intval($id));
            if($this->db->query($query)) {
                $this->db->query("DELETE FROM __lang_vacancy WHERE page_id=?", intval($id));
                return true;
            }
        }
        return false;
    }

}

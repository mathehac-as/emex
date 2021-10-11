<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Searchtiket extends Controller_Template {
            
        public $template = 'manager/VSearchTiket';
            
        public function action_index()
	{
            $this->template->title_site = 'Поиск авиабилетов';
            $this->template->description  = '';
            $this->template->title_page  = null;
            $this->template->styles  = array('css/index.css');
	}
}
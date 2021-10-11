<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Typeexpenseslist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftExpenses';
            
        public function action_get_typeexpenses_list()
	{
            $typeexpenses = Model::factory('Admin_Typeexpenses');
            $typeexpensess = $typeexpenses->get_typeexpensess();
            $typeexpenses_lists_act = array('img' => '/img/add.png', 'js' => 'typeExpensesAdd()'); 
            $this->template->typeexpensess = $typeexpensess;
            $this->template->typeexpenses_lists_act = $typeexpenses_lists_act;
	}
}
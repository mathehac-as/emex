<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Salaryuserlist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftSalary';
            
        public function action_get_user_list()
	{
            $user = Model::factory('Admin_User');
            $users = $user->get_users();
            $user_lists_act = array('img' => '/img/add.png', 'js' => 'userSalaryAdd()'); 
            $this->template->users = $users;
            $this->template->user_lists_act = $user_lists_act;
	}
}
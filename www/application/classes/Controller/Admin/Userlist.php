<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Userlist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftOffice';
            
        public function action_get_user_list()
	{
            $user = Model::factory('Admin_User');
            $user_lists = $user->get_users_for_login();
            $user_lists_act = array('img' => '/img/add.png', 'js' => 'userAdd()');       
            $this->template->user_lists = $user_lists;
            $this->template->user_lists_act = $user_lists_act;
	}
}
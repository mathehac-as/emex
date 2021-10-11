<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settingslist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftSettings';
            
        public function action_get_settings_list()
	{
            $settings = Model::factory('Admin_Settings');
            $settings_lists = $settings->get_settings();
            $this->template->settings_lists = $settings_lists;
	}
}
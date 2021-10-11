<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Clientlist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftClient';
            
        public function action_get_client_list()
	{
            $office_id = (int)$this->request->param('office_id');
            $client = Model::factory('Admin_Client');
            $client_lists = $client->get_clients($office_id);
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $this->template->client_lists = $client_lists;
            $this->template->offices = $offices;
            $this->template->office_id = $office_id;
	}
}
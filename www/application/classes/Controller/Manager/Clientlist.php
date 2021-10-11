<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Clientlist extends Controller_Template {
            
        public $template = 'manager/VPanelLeftClient';
            
        public function action_get_client_list()
	{
            $office_id = (int)$this->request->param('office_id');
            $user_name = Auth::instance()->get_user();
            $manager = Model::factory('Manager_User');
            $office = $manager->get_office_for_manager(array('user_id' => $user_name->id));
            $client = Model::factory('Manager_Client');
            $office_id = 0;
            if(isset($office[0]['id']) && (int)$office[0]['id'] != 0)
            {
                $office_id = (int)$office[0]['id'];
                $group_id = $client->get_group_id($office_id);
                $group_id = (int)$group_id[0]['id'];
                $client_lists = $client->get_clients($office_id, $group_id);
            }
            $client_lists_act = array(
                                    'add' => array(
                                                'title' => 'Добавление клиента',
                                                'img' => '/img/add.png', 
                                                'js' => 'clientAdd()'),
                                    'refresh' => array(
                                                'title' => 'Обновление списка клиентов',
                                                'img' => '/img/refresh.png', 
                                                'js' => 'clientRefresh()')
                                );
            $this->template->client_lists = $client_lists;
            $this->template->office_id = $office_id;
            $this->template->client_lists_act = $client_lists_act;
	}
}
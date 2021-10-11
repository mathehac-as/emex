<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Client extends Controller_Template {
            
        public $template = 'admin/VPanelCenterClientClient';
            
        public function action_get_client()
	{
            $mclient = Model::factory('Admin_Client');
            $client_id = (int)$this->request->param('client_id');
            $client = $mclient->get_client(array('client_id' => $client_id));  
            if(isset($client[0]))
            {
                $sum_order = $mclient->get_sum_order_for_client($client_id);
                $sum_debt = $mclient->get_debt_for_client($client_id);
                $client =  array(
                            'id' => $client[0]['id'],
                            'fio' => $client[0]['fio'],
                            'phone' => $client[0]['phone'],
                            'vin' => $client[0]['vin'],
                            'marka_avto' => $client[0]['marka_avto'],
                            'sum_order' => $sum_order[0]['sum_order'],
                            'sum_debt' => $sum_debt[0]['sum_debt'],
                            'title_save' => 'Редактирование клиента',
                            'img_save' => '/img/edit.png',
                            'js_save' => 'clientEdit(this)'
                        );
            }
            else 
            {
                $client = null;
            }
            $this->template->client = $client;
	}

        public function action_client_edit()
	{
            $client = Model::factory('Admin_Client');
            $client_id = (int)$this->request->param('client_id');
            $client = $client->get_client(array('client_id' => $client_id));  
            if(isset($client[0]))
            {
                $client =  array(
                            'title' => 'Редактирование клиента',
                            'id' => $client[0]['id'],
                            'fio' => $client[0]['fio'],
                            'emex_id' => $client[0]['emex_id'],
                            'vin' => $client[0]['vin'],
                            'marka_avto' => $client[0]['marka_avto'],
                            'organization' => $client[0]['organization'],
                            'comment' => $client[0]['comment'],
                            'phone' => $client[0]['phone'],
                            'email' => $client[0]['email'],
                            'percent_discount' => $client[0]['percent_discount'],
                            'js_save' => 'clientUpdate(this)'
                        );
            }
            else 
            {
                $client = null;
            }
            $this->template->client = $client;
            $this->template->act = 'edit';
	}        
        
        public function action_save_client()
	{
            $msg = '';
            $client_one = null;
            try
            {
                if($post = $this->request->post())
                {
                    $client = Model::factory('Admin_Client');                  
                    $data = array();   
                    if ($post['action'] == 'edit')
                    {
                        $client_id = (int)$this->request->param('client_id');
                        if(!isset($client_id) || $client_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор клиента!');
                        }
   
                        $data['fio'] = $post['fio'];
                        $data['emex_id'] = $post['emex_id'];
                        $data['vin'] = $post['vin'];
                        $data['marka_avto'] = $post['marka_avto'];
                        $data['organization'] = $post['organization'];
                        $data['phone'] = $post['phone'];
                        $data['email'] = $post['email'];
                        $data['comment'] = $post['comment'];
                        $data['percent_discount'] = $post['percent_discount'];
                        $res = $client->update_client($client_id, $data);
                        $client = $client->get_client(array('client_id' => $client_id));     
                        if(isset($client[0]))
                        {
                            $client_one =  array(
                                        'id' => $client[0]['id'],
                                        'fio' => $client[0]['fio'],
                                        'phone' => $client[0]['phone'],
                                        'vin' => $client[0]['vin'],
                                        'marka_avto' => $client[0]['marka_avto'],
                                        'title_save' => 'Редактирование клиента',
                                        'img_save' => '/img/edit.png',
                                        'js_save' => 'clientEdit(this)'
                                    );
                        }
                        $msg = 'Данные о клиенте обновлены';
                    }
                    else 
                    {
                        throw new Exception('Ошибка: Неопределено действия!');
                    }
                }
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->client = $client_one;
            $this->template->msg = $msg;
	}
}
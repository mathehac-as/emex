<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Client extends Controller_Template {
            
        public $template = 'manager/VPanelCenterClientClient';
            
        public function action_get_client()
	{
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $mclient = Model::factory('Manager_Client');
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
            $this->template->accesses = $accesses;
            $this->template->client = $client;
	}
        
        public function action_client_add()
	{
            $client =  array(
                            'title' => 'Добавление клиента',
                            'id' => 0,
                            'fio' => '',
                            'emex_id' => '',
                            'vin' => '',
                            'marka_avto' => '',
                            'organization' => '',
                            'comment' => '',
                            'phone' => '',
                            'email' => '',
                            'percent_discount' => '',
                            'js_save' => 'clientSave(this)'
                        );
            $this->template->client = $client;
            $this->template->act = 'add';
	}        

        public function action_client_edit()
	{
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $client = Model::factory('Manager_Client');
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
            $this->template->accesses = $accesses;
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
                    $mclient = Model::factory('Manager_Client');                  
                    $data = array(); 
                    if ($post['action'] == 'add')
                    {
                        $res = $mclient->exists_client($post['fio']);
                        if(isset($res[0]))
                        {
                            throw new Exception('Ошибка: ФИО клиента уже существует!');
                        }
                        $data['fio'] = $post['fio'];
                        $data['emex_id'] = $post['emex_id'];
                        $data['vin'] = $post['vin'];
                        $data['marka_avto'] = $post['marka_avto'];
                        $data['organization'] = $post['organization'];
                        $data['phone'] = $post['phone'];
                        $data['email'] = $post['email'];
                        $data['comment'] = $post['comment'];
                        $data['office_id'] = $post['office_id'];
                        $data['percent_discount'] = $post['percent_discount'];
                        $res = $mclient->save_client($data);
                        if(isset($res[0]) && (int)$res[0] >0)
                        {
                            $client_id = $res[0];
                            if(!isset($client_id) || $client_id == 0)
                            {
                                throw new Exception('Ошибка: Неопределен идентификатор клиента!');
                            }

                            $client = $mclient->get_client(array('client_id' => $client_id));     
                            if(isset($client[0]))
                            {
                                $sum_order = $mclient->get_sum_order_for_client($client_id);
                                $sum_debt = $mclient->get_debt_for_client($client_id);
                                $client_one =  array(
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
                        }
                        $msg = 'Данные о клиенте добавлены';
                    }
                    elseif ($post['action'] == 'edit')
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
                        $res = $mclient->update_client($client_id, $data);                        
                        $client = $mclient->get_client(array('client_id' => $client_id));     
                        if(isset($client[0]))
                        {
                            $sum_order = $mclient->get_sum_order_for_client($client_id);
                            $sum_debt = $mclient->get_debt_for_client($client_id);
                            $client_one =  array(
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
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Order extends Controller_Template {
            
        public $template = 'manager/VPanelCenterClientOrder';
            
        public function action_get_orders()
	{
            $order = Model::factory('Manager_Order');
            $client_id = (int)$this->request->param('client_id');
            $order_lists = $order->get_orders(array('client_id' => $client_id));
            $journals = $order->get_order_journals(array('client_id' => $client_id));
            $journal_lists = array();
            foreach ($journals as $value)
            {
                $journal_lists[$value['order_id']][] = $value;
            }
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $order_lists_act = array(
                                    'add' => array(
                                            'title' => 'Добавление заказа',
                                            'img' => '/img/add.png', 
                                            'js' => 'orderAdd()'
                                        ),
                                    'edit' => array(
                                            'title' => 'Редактирование заказа',
                                            'img' => '/img/edit.png', 
                                            'js' => 'orderEdit(this)'
                                        ),
                                    'refresh' => array(
                                            'title' => 'Обновление списка заказов',
                                            'img' => '/img/refresh.png', 
                                            'js' => 'orderRefresh()'
                                        ),
                                    'shipping' => array(
                                            'title' => 'Выдать заказа',
                                            'img' => '/img/shipping.png', 
                                            'js' => 'orderShipping(this)'
                                        ),
                                    'coins_add' => array(
                                            'title' => 'Пополнить баланс',
                                            'img' => '/img/coins_add.png', 
                                            'js' => 'getOrderCoinsAdd(this)'
                                        ),
                                    'invoice' => array(
                                            'title' => 'Печать накладной',
                                            'img' => '/img/invoice.png', 
                                            'js' => 'getPrintInvoice(this)'
                                        ),
                                    'cash_register' => array(
                                            'title' => 'Печать ПКО',
                                            'img' => '/img/cash_register.png', 
                                            'js' => 'getPrintCashRegister(this)'
                                        ),
                                    'cash_register_fast' => array(
                                            'title' => 'Быстрая печать ПКО',
                                            'img' => '/img/cash_register_fast.png', 
                                            'js' => 'getPrintCashRegisterFast(this)'
                                        ),
                                    'print_coins' => array(
                                            'title' => 'Печать Пополнения баланса',
                                            'img' => '/img/print_coins.png', 
                                            'js' => 'getPrintCoins(this)'
                                        ),
                                    'credit_card' => array(
                                            'title' => 'Дисконт',
                                            'img' => '/img/credit_card.png', 
                                            'js' => 'getCreditCard(this)'
                                        ),
                                    'credit_bonus' => array(
                                            'title' => 'Бонусы',
                                            'img' => '/img/credit_bonus.png', 
                                            'js' => 'getCreditBonus(this)'
                                        ),
                                    'send_sms' => array(
                                            'title' => 'Отправить СМС',
                                            'img' => '/img/send_sms.png', 
                                            'js' => 'getSendSms(this)'
                                        )
                                );
            $this->template->order_lists = $order_lists;
            $this->template->journal_lists = $journal_lists;
            $this->template->order_lists_act = $order_lists_act;
            $this->template->accesses = $accesses;
	}
        
        public function action_order_add()
	{
            $client_id = (int)$this->request->param('client_id');
            $client = Model::factory('Manager_Client');
            $client = $client->get_client(array('client_id' => $client_id));
            $access = Model::factory('Manager_Access');
            $user_name = Auth::instance()->get_user();
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $order =  array(
                            'title' => 'Добавление заказа',
                            'client_id' => $client_id,
                            'percent_discount' => $client[0]['percent_discount'],
                            'title_add' => 'Добавление оборудования',
                            'js_add' => 'orderAddRow()',
                            'img_add' => '/img/add.png',
                            'title_add_auto' => 'Автоматическое добавление оборудования',
                            'js_add_auto' => 'orderAddAutoRow()',
                            'img_add_auto' => '/img/add_auto.png',
                            'title_del' => 'Удаление оборудования',
                            'js_del' => 'orderDelRow(this)',
                            'img_del' => '/img/del.png',
                            'js_save' => 'orderSave(this)',
                            'title_abcp' => 'Введите № заказа',
                            'js_add_abcp' => 'orderAddAbcpRow()',
                            'img_add_abcp' => '/img/add_abcp.png',
                        );
            $this->template->order = $order;
            $this->template->accesses = $accesses;
            $this->template->act = 'add';
	}
        
        public function action_order_edit()
	{
            $client_id = (int)$this->request->param('client_id');
            $client = Model::factory('Manager_Client');
            $client = $client->get_client(array('client_id' => $client_id));
            $order_one = null;
            $post = $this->request->post();
            if(isset($post['order_id']))
            {
                $order = Model::factory('Manager_Order');
                $order_one = $order->get_order($post['order_id']); 
            }
            $comment = str_replace( '<br>', "\n", trim($order_one[0]['comment']) ); 
            $order =  array(
                            'title' => 'Редактирование заказа',
                            'id' => $order_one[0]['id'],
                            'client_id' => $client_id,
                            'percent_discount' => $client[0]['percent_discount'],
                            'comment' => $comment,
                            'sum' => $order_one[0]['sum'],
                            'delta_balance' => ($order_one[0]['sum']+$order_one[0]['balance']),
                            'delivery' => $order_one[0]['delivery'],
                            'title_add' => 'Добавление оборудования',
                            'js_add' => null,//'orderAddRow()',
                            'img_add' => '/img/add.png',
                            'title_del' => 'Удаление оборудования',
                            'js_del' => null,//'orderDelRow(this)',
                            'img_del' => '/img/del.png',
                            'js_save' => 'orderUpdate(this)'
                        );
            $this->template->order = $order;
            $this->template->act = 'edit';
	}
        
        public function action_save_order()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $order = Model::factory('Manager_Order');                  
                    $data = array(); 
                    if ($post['action'] == 'add')
                    {
                        $client_id = $post['client_id'];
                        $percent_discount = $post['percent_discount'];
                        $data_post = json_decode($post['data'], true);
                        $sum = 0;
                        $comment = '';
                        foreach ($data_post as $key => $value) 
                        {
                            $comment .= ($key+1).". ".$value['order_comment']." (".
                                            (int)$value['order_count']." шт.) - ".$value['order_sum']." руб.<br>";
                            $sum += ($value['order_sum'] * (int)$value['order_count']);
                        }
                        $comment = trim($comment, '<br>');
                        $sum = $sum - ($sum * ($percent_discount/100));
                        $data['client_id'] = (int)$client_id;
                        $data['comment'] = $comment;
                        $data['sum'] = $sum;
                        $data['date_create'] = date('Y-m-d H:i:s');
                        $data['delivery'] = $post['delivery'];
                        $data['abcp_number'] = isset($post['abcp_number']) ? $post['abcp_number'] : null;
                        $data['balance'] = -$sum;
                        $res = $order->save_order($data);
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $order_id = $res[0];
                            $journal = Model::factory('Manager_Journal');                  
                            $data = array();
                            $user_name = Auth::instance()->get_user();
                            $data['order_id'] = $order_id;
                            $data['base'] = $comment;
                            $data['sum'] = $sum;
                            $data['date_history'] = date('Y-m-d H:i:s');
                            $data['journal_type_id'] = 1;
                            $data['user_id'] = $user_name->id;
                            $res = $journal->save_journal($data);
                            if(isset($res[0]) && (int)$res[0] > 0)
                            {
                                $msg = 'Данные о заказе добавлены';
                            }
                            else 
                            {
                                throw new Exception('Ошибка: Данные о заказе не добавлены в историю!');
                            }
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Данные о заказе не добавлены!');
                        }
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $order_id = $post['order_id'];
                        $sum = $post['sum'] - ($post['sum'] * ($post['percent_discount']/100));
                        $data['client_id'] = (int)$post['client_id'];
                        $data['comment'] = str_replace( "\n", '<br>', trim($post['comment']) );
                        $data['sum'] = $sum;
                        $data['delivery'] = $post['delivery'];
                        $data['balance'] = $post['delta_balance']-$sum;
                        $res = $order->update_order($order_id, $data);
                        
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $user_name = Auth::instance()->get_user();
                        $data['order_id'] = $order_id;
                        $data['base'] = str_replace( "\n", '<br>', trim($post['comment']) );
                        $data['comment'] = $post['sub_comment'];
                        $data['sum'] = $sum;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = 3;
                        $data['user_id'] = $user_name->id;
                        $res = $journal->save_journal($data);
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $msg = 'Данные о заказе добавлены';
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Данные о заказе не добавлены в историю!');
                        }
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
            $this->template->msg = $msg;
	}
        
        public function action_order_add_auto()
	{
            $error = '';
            $client_id = (int)$this->request->param('client_id');
            $client = Model::factory('Manager_Client');
            $client = $client->get_client(array('client_id' => $client_id));
            $access = Model::factory('Manager_Access');
            $user_name = Auth::instance()->get_user();
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $user = Model::factory('Manager_User');
            $user_emex = $user->get_account_emex_for_manager($user_name->id);
            $user_emex_id = isset($user_emex[0]['emex_id']) ? $user_emex[0]['emex_id'] : '';
            $user_emex_pass = isset($user_emex[0]['emex_pass']) ? $user_emex[0]['emex_pass'] : '';
            $auto_orders = array();
            if($user_emex_id != '' && $user_emex_pass != '')
            {
                $auto_orders = $this->get_soap_emex($user_emex_id, $user_emex_pass);
                if(isset($auto_orders->GetBasketResult) && isset($auto_orders->GetBasketResult->BasketData))
                {
                    $auto_orders = $auto_orders->GetBasketResult->BasketData;
                }
            }
            else
            {
                $error = 'Не определены логин и пароль emex!';
            }
            $order =  array(
                            'title' => 'Автоматическое добавление оборудования',
                            'client_id' => $client_id,
                            'auto_orders' => $auto_orders,
                            'js_save' => 'orderAutoAdd(this)'
                        );
            $this->template->error = $error;
            $this->template->order = $order;
            $this->template->accesses = $accesses;
            $this->template->act = 'add_auto';
	}
            
        public function action_order_add_abcp()
	{
            $error = '';
            $client_id = (int)$this->request->param('client_id');
            $order_abcp =  array(
                            'title' => 'ABCP добавление оборудования',
                            'client_id' => $client_id,
                            'js_save' => 'orderAddAbcp(this)'
                        );
            $this->template->order_abcp = $order_abcp;
            $this->template->act = 'add_abcp';
	}
       
        public function action_save_shipping()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $journal = Model::factory('Manager_Journal');                  
                    $data = array();
                    $user_name = Auth::instance()->get_user();
                    $data['order_id'] = (int)$post['order_id'];
                    $data['base'] = 'Заказ выдан клиенту';
                    $data['date_history'] = date('Y-m-d H:i:s');
                    $data['journal_type_id'] = 6;
                    $data['user_id'] = $user_name->id;
                    $res = $journal->save_journal($data);
                    if(isset($res[0]) && (int)$res[0] > 0)
                    {
                        $msg = 'Заказ выдан клиенту';
}
                    else 
                    {
                        throw new Exception('Ошибка: Заказ не выдан!');
                    }
                }
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
        
        public function action_get_send_sms()
	{
            $post = $this->request->post();
            $order_id = (isset($post['order_id']) ? (int)$post['order_id'] : 0);
            $user_name = Auth::instance()->get_user();
            $order = Model::factory('Manager_Order');
            $office = $order->get_address_office_for_user($user_name->id);
            $office_address = (isset($office[0]['name']) ? $office[0]['name'] : '');
            $office_phone = (isset($office[0]['phone']) ? $office[0]['phone'] : '');
            $message = $order->get_config('sms_message');
            $message = (isset($message[0]['value']) ? $message[0]['value'] : '');
            if(!empty($message))
            {
                $message = preg_replace('/#order_id#/i', $order_id, $message);
                $message = preg_replace('/#address#/i', $office_address, $message);
                $message = preg_replace('/#phone#/i', $office_phone, $message);
            }
            
            $client = Model::factory('Manager_Client');
            $client = $client->get_client_for_order($order_id);
            $phone = (isset($client[0]['phone']) ? $client[0]['phone'] : '');
            $client_id = (isset($client[0]['id']) ? $client[0]['id'] : 0);

            $send_sms =  array(
                            'title' => 'Посылка смс клиенту',
                            'phone' => $phone,
                            'message' => $message,
                            'client_id' => $client_id,
                            'order_id' => $order_id,
                            'js_save' => 'sendSms(this)'
                        );
            $this->template->send_sms = $send_sms;
            $this->template->act = 'send_sms';
	}
        
        public function action_send_sms()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $client_id = (isset($post['client_id']) ? (int)$post['client_id'] : 0);
                    $phone_number = urlencode(isset($post['phone_number']) ? $post['phone_number'] : '');
                    $message = urlencode(isset($post['message']) ? $post['message'] : '');
                    $main = Kohana::$config->load('main');
                    $from = $main->get('sms_from');
                    $pass = $main->get('sms_pass');
                    $user = $main->get('sms_user');
                    $url = $main->get('sms_url');
                    $url .= '?login='.$user.'&password='.$pass.'&service=1&space_force=1&space='.$from.'&subno='.$phone_number.'&text='.$message;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    $format_message_id = $main->get('format_message_id');
                    $message_id = '';
                    if(isset($result) && preg_match($format_message_id, $result, $matches))
                    {
                        $message_id = $matches[1];
                    }
                    else 
                    {
                        throw new Exception('Ошибка: СМС не послано(http)!');
                    }
                    $journal = Model::factory('Manager_Journal');                  
                    $data = array();
                    $user_name = Auth::instance()->get_user();
                    $data['order_id'] = (isset($post['order_id']) ? (int)$post['order_id'] : 0);
                    $data['base'] = 'СМС послано на тел.'.$phone_number.'; СМС идентификатор - '.$message_id;
                    $data['date_history'] = date('Y-m-d H:i:s');
                    $data['journal_type_id'] = 10;
                    $data['user_id'] = $user_name->id;
                    $res = $journal->save_journal($data);
                    if(isset($res[0]) && (int)$res[0] > 0)
                    {
                        $msg = 'СМС послано';
                    }
                    else 
                    {
                        throw new Exception('Ошибка: СМС не послано!');
                    }
                }
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
        
        private function get_soap_emex($user_emex_id, $user_emex_pass) 
        {
            $security = new SoapClient(
                'http://ws.emex.ru/EmEx_Basket.asmx?wsdl',
                array(
                    'soap_version'=>SOAP_1_1,
                    'cache_wsdl'=>WSDL_CACHE_NONE,
                    'trace'=>true
                )
            );

            return $security->GetBasket(array('login' => $user_emex_id,'password' => $user_emex_pass, 'basketPart' => 'Basket'));
        }
}
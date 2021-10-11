<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Ordercoins extends Controller_Template {
            
        public $template = 'manager/VPanelCenterOrdercoins';
            
        public function action_get_coins()
	{
            $office_id = (int)$this->request->param('office_id');
            $coins =  array(
                            'title' => 'Пополнение баланса',
                            'office_id' => $office_id,
                            'js_save' => 'orderCoinsAdd(this)'
                            );                 
            $this->template->coins = $coins;
	}
        
        public function action_save_coins()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $data = array();
                    $user_name = Auth::instance()->get_user();
                    $office_id = (int)$this->request->param('office_id');
                    if(!isset($office_id) || $office_id == 0)
                    {
                        throw new Exception('Ошибка: Неопределен идентификатор офиса!');
                    }     
                    $sum = (int)$post['sum'];
                    if(!$post['cashless'])
                    {
                        $office = Model::factory('Admin_Office');    
                        $officehistory = Model::factory('Admin_Officehistory');
                        $balance = $office->get_balance($office_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance+$sum;
                        $res = $office->update_office($office_id, $data);

                        $data = array();
                        $data['sum'] = $sum;
                        $data['comment'] = 'Пополнение баланса';
                        $data['date_change'] = date('Y-m-d H:i:s');
                        $data['office_id'] = $office_id;
                        $data['type_history'] = 'coins_add';
                        $data['user_id'] = $user_name->id;
                        $res = $officehistory->save_office_history($data);
                    }

                    $order = Model::factory('Manager_Order');                  
                    $data = array(); 
                    $client_id = $post['client_id'];
                    $data['client_id'] = (int)$client_id;
                    $data['comment'] = 'Пополнение баланса'.($post['cashless'] ? ' (Безналичный)' : '')."; ".(isset($post['comment']) ? $post['comment'] : '');
                    $data['sum'] = $sum;
                    $data['date_create'] = date('Y-m-d H:i:s');
                    $data['order_type_id'] = 1;
                    $res = $order->save_order($data);
                    if(isset($res[0]) && (int)$res[0] > 0)
                    {
                        $order_id = $res[0];
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $data['order_id'] = $order_id;
                        $data['base'] = 'Пополнение баланса'.($post['cashless'] ? ' (Безналичный)' : '');
                        $data['sum'] = $sum;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = ($post['cashless'] ? 8 : 7);
                        $data['user_id'] = $user_name->id;
                        $res = $journal->save_journal($data);
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $msg = 'Пополнение баланса выполнена';
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Пополнение баланса не выполнена(запись в журнал)!');
                        }
                    }
                    else 
                    {
                        throw new Exception('Ошибка: Пополнение баланса не выполнена(заказ не создан)!');
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
}
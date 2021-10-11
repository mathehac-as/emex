<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Ordercash extends Controller_Template {
            
        public $template = 'manager/VPanelCenterOrdercash';
            
        public function action_get_cash()
	{
            $office_id = (int)$this->request->param('office_id');
            if($post = $this->request->post())
            {
                $title = '';
                $type = '';
                if($post['type'] == 'outcash')
                {
                    $title = 'Из кассу';
                    $type = $post['type'];
                }
                elseif($post['type'] == 'incash')
                {
                    $title = 'В кассу';
                    $type = $post['type'];
                }
                elseif($post['type'] == 'card')
                {
                    $title = 'Оплачено картой';
                    $type = $post['type'];
                }
                elseif($post['type'] == 'transfer')
                {
                    $title = 'Переводом на карту';
                    $type = $post['type'];
                }
                $cash =  array(
                                'title' => $title,
                                'office_id' => $office_id,
                                'order_id' => $post['order_id'],
                                'type' => $type,
                                'js_save' => 'orderCashSave(this)'
                            );                 
            }
            else 
            {
                $cash = null; 
            }
            $this->template->cash = $cash;
	}
        
        public function action_save_cash()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $user_name = Auth::instance()->get_user();
                    $office = Model::factory('Admin_Office');    
                    $officehistory = Model::factory('Admin_Officehistory');
                    $data = array();
                    $office_id = (int)$this->request->param('office_id');
                    if(!isset($office_id) || $office_id == 0)
                    {
                        throw new Exception('Ошибка: Неопределен идентификатор офиса!');
                    }     
                    $sum = (int)$post['sum'];
                    if ($post['type'] == 'outcash')
                    {
                        $balance = $office->get_balance($office_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance-$sum;
                        if($data['balance'] < 0)
                        {
                            throw new Exception('Ошибка: Не достаточно сдредств в офисе!');
                        }
                        $res = $office->update_office($office_id, $data);
                        
                        $data = array();
                        $data['sum'] = $sum;
                        $data['comment'] = $post['comment'];
                        $data['date_change'] = date('Y-m-d H:i:s');
                        $data['office_id'] = $office_id;
                        $data['type_history'] = 'outcash';
                        $data['user_id'] = $user_name->id;
                        $res = $officehistory->save_office_history($data);
                        
                        $order_id = (int)$post['order_id'];
                        $order = Model::factory('Manager_Order'); 
                        $data = array();
                        $balance = $order->get_balance($order_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance-$sum;
                        $res = $order->update_order($order_id, $data);
                        
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $data['order_id'] = $order_id;
                        $data['base'] = 'Возврат денежных средств';
                        $data['comment'] = $post['comment'];
                        $data['sum'] = $sum;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = 5;
                        $data['user_id'] = $user_name->id;
                        $res = $journal->save_journal($data);
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $msg = 'Возврат денежных средств выполнена';
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Возврат денежных средств не выполнена(запись в журнал)!');
                        }
                    }
                    elseif ($post['type'] == 'incash')
                    {
                        $balance = $office->get_balance($office_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance+$sum;
                        $res = $office->update_office($office_id, $data);
                        
                        $data = array();
                        $data['sum'] = $sum;
                        $data['comment'] = $post['comment'];
                        $data['date_change'] = date('Y-m-d H:i:s');
                        $data['office_id'] = $office_id;
                        $data['type_history'] = 'incash';
                        $data['user_id'] = $user_name->id;
                        $res = $officehistory->save_office_history($data);
                        
                        $order_id = (int)$post['order_id'];
                        $order = Model::factory('Manager_Order'); 
                        $data = array();
                        $balance = $order->get_balance($order_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance+$sum;
                        $res = $order->update_order($order_id, $data);
                        
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $data['order_id'] = $order_id;
                        $data['base'] = 'Внесение денежных средств';
                        $data['comment'] = $post['comment'];
                        $data['sum'] = $sum;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = 2;
                        $data['user_id'] = $user_name->id;
                        $res = $journal->save_journal($data);
                        
                        $discount = Model::factory('Manager_Discount'); 
                        $discount_one = $discount->get_discount_for_order_id($order_id);
                        $discount_bonus = (isset($discount_one[0]['d_bonus']) ? $discount_one[0]['d_bonus'] : 0 );
                        $discount_id = (isset($discount_one[0]['d_id']) ? $discount_one[0]['d_id'] : null );
                        if(isset($discount_bonus) && isset($discount_id))
                        {
                            $config = Model::factory('Config');
                            $bonus_percent = $config->get_config('bonus_percent');
                            $bonus_percent = (isset($bonus_percent[0]['value']) ? $bonus_percent[0]['value'] : 0 );
                            $bonus_percent_sum = ($sum / 100) * $bonus_percent;
                            $data = array();
                            $bonus = (int)$discount_bonus + (int)$bonus_percent_sum;
                            $data['d_bonus'] = (int)$discount_bonus + (int)$bonus_percent_sum;
                            $res = $discount->update_discount($discount_id, $data);
                            
                            $data = array();
                            $data['dh_percent'] = 0;
                            $data['dh_comment'] = 'Сумма пополнения: '.$sum.'; Бонус: '.$bonus.';';
                            $data['dh_discount_sum'] = 0;
                            $data['dh_date_create'] = date('Y-m-d H:i:s');
                            $data['dh_order_sum'] = 0;
                            $data['dh_discount_id'] = $discount_id;
                            $data['dh_order_id'] = $order_id;
                            $data['dh_bonus'] = $bonus;
                            $data['dh_discounts_history_type_id'] = 3;
                            $res = $discount->save_discounts_history($data);
                        }
                        if(isset($res) && (int)$res != 0)
                        {
                            $msg = 'Внесение денежных средств выполнена';
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Внесение денежных средств не выполнена(запись в журнал)!');
                        }
                    }
                    elseif ($post['type'] == 'card')
                    {
                        $order_id = (int)$post['order_id'];
                        $order = Model::factory('Manager_Order'); 
                        $balance = $order->get_balance($order_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance+$sum;
                        $res = $order->update_order($order_id, $data);
                        
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $data['order_id'] = $order_id;
                        $data['base'] = 'Оплата картой';
                        $data['comment'] = $post['comment'];
                        $data['sum'] = $sum;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = 4;
                        $data['user_id'] = $user_name->id;
                        $res = $journal->save_journal($data);
                        
                        $discount = Model::factory('Manager_Discount'); 
                        $discount_one = $discount->get_discount_for_order_id($order_id);
                        $discount_bonus = (isset($discount_one[0]['d_bonus']) ? $discount_one[0]['d_bonus'] : 0 );
                        $discount_id = (isset($discount_one[0]['d_id']) ? $discount_one[0]['d_id'] : null );
                        if(isset($discount_bonus) && isset($discount_id))
                        {
                            $config = Model::factory('Config');
                            $bonus_percent = $config->get_config('bonus_percent');
                            $bonus_percent = (isset($bonus_percent[0]['value']) ? $bonus_percent[0]['value'] : 0 );
                            $bonus_percent_sum = ($sum / 100) * $bonus_percent;
                            $data = array();
                            $bonus = (int)$discount_bonus + (int)$bonus_percent_sum;
                            $data['d_bonus'] = (int)$discount_bonus + (int)$bonus_percent_sum;
                            $res = $discount->update_discount($discount_id, $data);
                            
                            $data = array();
                            $data['dh_percent'] = 0;
                            $data['dh_comment'] = 'Сумма пополнения: '.$sum.'; Бонус: '.$bonus.';';
                            $data['dh_discount_sum'] = 0;
                            $data['dh_date_create'] = date('Y-m-d H:i:s');
                            $data['dh_order_sum'] = 0;
                            $data['dh_discount_id'] = $discount_id;
                            $data['dh_order_id'] = $order_id;
                            $data['dh_bonus'] = $bonus;
                            $data['dh_discounts_history_type_id'] = 3;
                            $res = $discount->save_discounts_history($data);
                        }
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $msg = 'Оплата картой выполнена';
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Оплата картой не выполнена(запись в журнал)!');
                        }
                    }
                    elseif ($post['type'] == 'transfer')
                    {
                        $order_id = (int)$post['order_id'];
                        $order = Model::factory('Manager_Order'); 
                        $balance = $order->get_balance($order_id);
                        $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                        $data['balance'] = $balance+$sum;
                        $res = $order->update_order($order_id, $data);
                        
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $data['order_id'] = $order_id;
                        $data['base'] = 'Перевод на карту';
                        $data['comment'] = $post['comment'];
                        $data['sum'] = $sum;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = 12;
                        $data['user_id'] = $user_name->id;
                        $res = $journal->save_journal($data);
                        
                        $discount = Model::factory('Manager_Discount'); 
                        $discount_one = $discount->get_discount_for_order_id($order_id);
                        $discount_bonus = (isset($discount_one[0]['d_bonus']) ? $discount_one[0]['d_bonus'] : 0 );
                        $discount_id = (isset($discount_one[0]['d_id']) ? $discount_one[0]['d_id'] : null );
                        if(isset($discount_bonus) && isset($discount_id))
                        {
                            $config = Model::factory('Config');
                            $bonus_percent = $config->get_config('bonus_percent');
                            $bonus_percent = (isset($bonus_percent[0]['value']) ? $bonus_percent[0]['value'] : 0 );
                            $bonus_percent_sum = ($sum / 100) * $bonus_percent;
                            $data = array();
                            $bonus = (int)$discount_bonus + (int)$bonus_percent_sum;
                            $data['d_bonus'] = (int)$discount_bonus + (int)$bonus_percent_sum;
                            $res = $discount->update_discount($discount_id, $data);
                            
                            $data = array();
                            $data['dh_percent'] = 0;
                            $data['dh_comment'] = 'Сумма перевода: '.$sum.'; Бонус: '.$bonus.';';
                            $data['dh_discount_sum'] = 0;
                            $data['dh_date_create'] = date('Y-m-d H:i:s');
                            $data['dh_order_sum'] = 0;
                            $data['dh_discount_id'] = $discount_id;
                            $data['dh_order_id'] = $order_id;
                            $data['dh_bonus'] = $bonus;
                            $data['dh_discounts_history_type_id'] = 3;
                            $res = $discount->save_discounts_history($data);
                        }
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $msg = 'Перевод картой выполнен';
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Перевод картой не выполнен(запись в журнал)!');
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
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Creditbonus extends Controller_Template {
            
        public $template = 'manager/VPanelCenterOrdercreditbonus';
            
        public function action_get_creditbonus()
	{
            $order_id = (int)$this->request->param('order_id');
            $discount = Model::factory('Manager_Discount'); 
            $discount_one = $discount->get_discount_for_order_id($order_id);
            $discount_bonus = (isset($discount_one[0]['d_bonus']) ? $discount_one[0]['d_bonus'] : 0 );
            $creditbonus =  array(
                            'title' => 'Потратить бонусы',
                            'order_id' => $order_id,
                            'bonus' => $discount_bonus,
                            'js_save' => 'orderCreditBonusAdd(this)'
                            );                 
            $this->template->creditbonus = $creditbonus;
	}
        
        public function action_save_creditbonus()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $data = array();
                    $order_id = (int)$post['order_id'];
                    $creditbonus = (int)$post['creditbonus'];
                    if($creditbonus != 0)
                    {
                        if($order_id != 0)
                        {
                            $discount = Model::factory('Manager_Discount');   
                            $discount_one = $discount->get_discount_for_order_id($order_id);
                            if(isset($discount_one[0]['d_id']))
                            {
                                if($discount_one[0]['d_bonus_no_writeoff'] != 1)
                                {
                                    if($creditbonus <= $discount_one[0]['d_bonus'])
                                    {
                                        $order = Model::factory('Manager_Order'); 
                                        $order_one = $order->get_order($order_id);
                                        $order_sum = (isset($order_one[0]['sum']) ? $order_one[0]['sum'] : 0 );
                                        $order_balance = (isset($order_one[0]['balance']) ? $order_one[0]['balance'] : 0 );
                                        $data = array();
                                        $sum = $order_sum - $creditbonus;
                                        $balance = $order_balance + $creditbonus;
                                        $data['sum'] = $sum;
                                        $data['balance'] = $balance;
                                        $res = $order->update_order($order_id, $data);

                                        $data = array();
                                        $data['d_bonus'] = $discount_one[0]['d_bonus'] - $creditbonus;
                                        $res = $discount->update_discount($discount_one[0]['d_id'], $data);

                                        $data = array();
                                        $user_name = Auth::instance()->get_user();
                                        $journal = Model::factory('Manager_Journal');                  
                                        $data['order_id'] = $order_id;
                                        $data['base'] = 'Бонусные баллы: '.$creditbonus.'.<br/>Дисконтная карта: '.$discount_one[0]['d_number'].'; '.
                                                        'Владелец карты: '.$discount_one[0]['d_fio'].'.';
                                        $data['sum'] = $sum;
                                        $data['date_history'] = date('Y-m-d H:i:s');
                                        $data['journal_type_id'] = 11;
                                        $data['user_id'] = $user_name->id;
                                        $res = $journal->save_journal($data);
                                        if(isset($res[0]) && (int)$res[0] > 0)
                                        {
                                            $data = array();  
                                            $data['dh_percent'] = 0;
                                            $data['dh_comment'] = 'Списание бонусных баллов: '.$creditbonus.';';
                                            $data['dh_discount_sum'] = 0;
                                            $data['dh_date_create'] = date('Y-m-d H:i:s');
                                            $data['dh_order_sum'] = $sum;
                                            $data['dh_discount_id'] = $discount_one[0]['d_id'];
                                            $data['dh_order_id'] = $order_id;
                                            $data['dh_bonus'] = $creditbonus;
                                            $data['dh_discounts_history_type_id'] = 4;
                                            $res = $discount->save_discounts_history($data);
                                            if(isset($res[0]) && (int)$res[0] > 0)
                                            {
                                                $msg = 'Списаны бонусные баллы '.$creditbonus.'. Сумма заказа: '.$sum.'.';
                                            }
                                            else 
                                            {
                                                throw new Exception('Ошибка: Бонусы не потрачены(запись в историю по бонусным баллам)!');
                                            }
                                        }
                                        else 
                                        {
                                            throw new Exception('Ошибка: Бонусы не потрачены(запись в журнал)!');
                                        }
                                    }
                                    else 
                                    {
                                        throw new Exception('Ошибка: Бонусы не потрачены(вы пытались списать больше бонусов чем есть в наличии)!');
                                    }
                                }
                                else 
                                {
                                    throw new Exception('Ошибка: Бонусы не потрачены(списывать баллы запрещено для данной карты)!');
                                }
                            }
                            else 
                            {
                                throw new Exception('Ошибка: Бонусы не потрачены(id карты не определен)!');
                            }
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Бонусы не потрачены(id заказа не определен)!');
                        }
                    }
                    else
                    {
                        throw new Exception('Ошибка: Бонусы не потрачены(баллы равны 0)!');
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
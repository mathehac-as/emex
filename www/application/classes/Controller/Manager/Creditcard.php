<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Creditcard extends Controller_Template {
            
        public $template = 'manager/VPanelCenterOrdercreditcard';
            
        public function action_get_creditcard()
	{
            $order_id = (int)$this->request->param('order_id');
            $creditcard =  array(
                            'title' => 'Прикрепить карту',
                            'order_id' => $order_id,
                            'js_save' => 'orderCreditCardAdd(this)'
                            );                 
            $this->template->creditcard = $creditcard;
	}
        
        public function action_save_creditcard()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $data = array();
                    $order_id = (int)$post['order_id'];
                    $creditcard = $post['creditcard'];
                    if(!empty($creditcard))
                    {
                        if($order_id != 0)
                        {
                            $discount = Model::factory('Manager_Discount');   
                            $discount_one = $discount->get_discount_for_number($creditcard);
                            if(isset($discount_one[0]['d_id']))
                            {
                                $discounthistory = $discount->get_discounthistorys_sum(array('discount_id' => $discount_one[0]['d_id']));
                                $discounthistory_sum = (isset($discounthistory[0]['order_sum']) ? $discounthistory[0]['order_sum'] : 0 );
                                $order = Model::factory('Manager_Order'); 
                                $data['discount_id'] = $discount_one[0]['d_id'];
                                $res = $order->update_order($order_id, $data);

                                $percent = (int)$discount_one[0]['d_percent'];
                                $balance_order = $order->get_order($order_id);
                                $order_sum = (isset($balance_order[0]['sum']) ? $balance_order[0]['sum'] : 0 );
                                $order_balance = (isset($balance_order[0]['balance']) ? $balance_order[0]['balance'] : 0 );
                                if($percent > 0)
                                {
                                    $data = array();
                                    $discount_sum = $order_sum * ($percent / 100);
                                    $sum = $order_sum - $discount_sum;
                                    $balance = $order_balance + $discount_sum;
                                    $data['sum'] = $sum;
                                    $data['balance'] = $balance;
                                    $res = $order->update_order($order_id, $data);

                                    $data = array();
                                    $user_name = Auth::instance()->get_user();
                                    $journal = Model::factory('Manager_Journal');                  
                                    $data['order_id'] = $order_id;
                                    $data['base'] = 'Сумма скидки: '.$discount_sum.' руб.<br/>Дисконтная карта: '.$discount_one[0]['d_number'].'; '.
                                                    'Скидка: '.$percent.'%; Владелец карты: '.$discount_one[0]['d_fio'].'.';
                                    $data['sum'] = $sum;
                                    $data['date_history'] = date('Y-m-d H:i:s');
                                    $data['journal_type_id'] = 9;
                                    $data['user_id'] = $user_name->id;
                                    $res = $journal->save_journal($data);
                                    if(isset($res[0]) && (int)$res[0] > 0)
                                    {
                                        $data = array();  
                                        $data['dh_percent'] = $percent;
                                        $data['dh_comment'] = 'Сумма заказа: '.$order_sum.'; Сумма скидки: '.$discount_sum.' руб. Скидка: '.$percent.'%; ';
                                        $data['dh_discount_sum'] = $discount_sum;
                                        $data['dh_date_create'] = date('Y-m-d H:i:s');
                                        $data['dh_order_sum'] = $order_sum;
                                        $data['dh_discount_id'] = $discount_one[0]['d_id'];
                                        $data['dh_order_id'] = $order_id;
                                        $data['dh_discounts_history_type_id'] = 2;
                                        $res = $discount->save_discounts_history($data);
                                        if(isset($res[0]) && (int)$res[0] > 0)
                                        {
                                            $msg = 'Скидка '.$percent.'% назначена. Сумма заказа: '.$order_sum.'; Сумма скидки: '.$discount_sum.' руб.';
                                        }
                                        else 
                                        {
                                            throw new Exception('Ошибка: Прикрепление карты не выполнена(запись в историю по проценту)!');
                                        }
                                    }
                                    else 
                                    {
                                        throw new Exception('Ошибка: Прикрепление карты не выполнена(запись в журнал)!');
                                    }
                                }

                                $discount_config = $discount->get_discount_config('discount_percent');
                                $max_percent = $discount->get_discount_config('max_percent');
                                if(isset($discount_config) && isset($max_percent) && (int)$discount_config[0]['dc_sum'] > 0)
                                {
                                    if((int)$discount_one[0]['d_percent_fixed'] == 0)
                                    {
                                        $discounthistory_sum = $discounthistory_sum % (int)$discount_config[0]['dc_sum'];
                                        $percent = ((int)(($order_sum + $discounthistory_sum) / $discount_config[0]['dc_sum']) + (int)$discount_one[0]['d_percent']);
                                        $max_percent = $max_percent[0]['dc_percent'];
                                        if($percent > $max_percent)
                                        {
                                            $percent = $max_percent;
                                        }
                                        if((int)$discount_one[0]['d_percent'] >= $max_percent || (int)$discount_one[0]['d_percent'] > $percent)
                                        {
                                            $percent = (int)$discount_one[0]['d_percent'];
                                        }
                                        $data['dh_comment'] = 'Обновлен процент по карте. Процент по карте: '.$percent.'%.';
                                        $msg_tmp = 'Обновлен процент по карте. ';
                                    }
                                    else 
                                    {
                                        $percent = (int)$discount_one[0]['d_percent'];
                                        $data['dh_comment'] = 'Процент фиксированный по карте. Процент по карте: '.$percent.'%.';
                                        $msg_tmp = 'Процент фиксированный по карте. ';
                                    }
                                    $data = array();                
                                    $data['d_percent'] = $percent;
                                    $res = $discount->update_discount($discount_one[0]['d_id'], $data);

                                    $data = array();               
                                    $data['dh_percent'] = $percent;
                                    $data['dh_date_create'] = date('Y-m-d H:i:s');
                                    $data['dh_discount_id'] = $discount_one[0]['d_id'];
                                    $data['dh_order_id'] = $order_id;
                                    $data['dh_discounts_history_type_id'] = 1;
                                    $res = $discount->save_discounts_history($data);
                                    if(isset($res[0]) && (int)$res[0] > 0)
                                    {
                                        $msg .= $msg_tmp.'Прикрепление карты выполнено';
                                    }
                                    else 
                                    {
                                        throw new Exception('Ошибка: Прикрепление карты не выполнена(запись в историю по проценту)!');
                                    }
                                }
                                else 
                                {
                                    throw new Exception('Ошибка: Прикрепление карты не выполнена(конфигурация по картам не определена)!');
                                }
                            }
                            else 
                            {
                                throw new Exception('Ошибка: Прикрепление карты не выполнена(id карты не определен)!');
                            }
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Прикрепление карты не выполнена(id заказа не определен)!');
                        }
                    }
                    else
                    {
                        throw new Exception('Ошибка: Прикрепление карты не выполнено(не определен номер/идентификатор карты)!');
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
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Order extends Controller_Template {
            
        public $template = 'admin/VPanelCenterClientOrder';
            
        public function action_get_orders()
	{
            $order = Model::factory('Admin_Order');
            $client_id = (int)$this->request->param('client_id');
            $order_lists = $order->get_orders(array('client_id' => $client_id));
            $journals = $order->get_order_journals(array('client_id' => $client_id));
            $journal_lists = array();
            foreach ($journals as $value) 
            {
                $journal_lists[$value['order_id']][] = $value;
            }
            $order_lists_act = array(
                                    'edit' => array(
                                            'title' => 'Редактирование заказа',
                                            'img' => '/img/edit.png', 
                                            'js' => 'orderEdit(this)'
                                        ),
                                    'invoice' => array(
                                            'title' => 'Печать накладной',
                                            'img' => '/img/invoice.png', 
                                            'js' => 'getPrintInvoice(this)'
                                        )
                                );
            $this->template->order_lists = $order_lists;
            $this->template->journal_lists = $journal_lists;
            $this->template->order_lists_act = $order_lists_act;
	}
        
        public function action_order_edit()
	{
            $client_id = (int)$this->request->param('client_id');
            $client = Model::factory('Admin_Client');
            $client = $client->get_client(array('client_id' => $client_id));
            $order_one = null;
            $post = $this->request->post();
            if(isset($post['order_id']))
            {
                $order = Model::factory('Admin_Order');
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
}
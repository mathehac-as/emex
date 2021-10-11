<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Print extends Controller_Template {
            
        public $template = 'manager/VPrintOrder';
            
        public function action_print_invoice()
	{
            $title_site = 'Менеджер-панель';
            $this->template->title_site = 'Учет автозапчастей: Печать накладной';
            $this->template->description  = '';
            $this->template->title_page  = null;
            $this->template->styles  = array('css/index.css');
            $order_id = (int)$this->request->param('order_id');
            $order = Model::factory('Manager_Order');
            $order = $order->get_order($order_id);
            $client = Model::factory('Manager_Client');
            $client = $client->get_client_for_order($order_id);
            $pay = $order[0]['sum']+$order[0]['balance'];
            $debt = ($order[0]['balance'] < 0 ? $order[0]['balance'] : 0);
            $discount = Model::factory('Manager_Discount');
            $discounthistory = $discount->get_discount_for_history($order_id);
            $print_invoice = array(
                                    'id' => $order_id,
                                    'fio' => $client[0]['fio'],
                                    'phone' => $client[0]['phone'],
                                    'date_make' => date('d.m.Y',strtotime($order[0]['date_create'])),
                                    'marka_avto' => $client[0]['marka_avto'],
                                    'vin' => $client[0]['vin'],
                                    'percent_discount' => $client[0]['percent_discount'],
                                    'delivery' => $order[0]['delivery'],
                                    'comment' => $order[0]['comment'],
                                    'sum' => $order[0]['sum'],
                                    'pay' => $pay,
                                    'debt' => $debt,
                                    'img' => '/img/print_img.png'
                                  );
            $print_order = View::factory('manager/VPrintInvoice')->
                set('print_invoice', $print_invoice)->set('discounthistory', $discounthistory);
            $this->template->print_order = $print_order;
	}
        
        public function action_print_cash_register()
	{
            $title_site = 'Менеджер-панель';
            $this->template->title_site = 'Учет автозапчастей: Печать ПКО';
            $this->template->description  = '';
            $this->template->title_page  = null;
            $this->template->styles  = array('css/index.css');
            $order_id = (int)$this->request->param('order_id');
            $order = Model::factory('Manager_Order');
            $order = $order->get_order($order_id);
            $client = Model::factory('Manager_Client');
            $client = $client->get_client_for_order($order_id);
            $pay = $order[0]['sum']+$order[0]['balance'];
            $debt = abs($order[0]['balance'] < 0 ? $order[0]['balance'] : 0);
            $news = Model::factory('Manager_News');
            $news = $news->get_news('print');
            $news = isset($news[0]['text']) ? $news[0]['text'] : '';
            $discount = Model::factory('Manager_Discount');
            $bonus_sum = $discount->get_discount_bonus_sum($order_id);
            $bonus_sum = isset($bonus_sum[0]['bonus_sum']) ? $bonus_sum[0]['bonus_sum'] : 0;
            $bonus_writeoff = $discount->get_discount_bonus_writeoff($order_id);
            $bonus_writeoff = isset($bonus_writeoff[0]['bonus_writeoff']) ? $bonus_writeoff[0]['bonus_writeoff'] : 0;
            $discounthistory = $discount->get_discount_for_history($order_id);
            $print_cash_register = array(            
                                    'number' => $order[0]['id'],
                                    'date_make' => date('d.m.Y',strtotime($order[0]['date_create'])),
                                    'sum' => $order[0]['sum'],
                                    'pay' => $pay,
                                    'debt' => $debt,
                                    'delivery' => $order[0]['delivery'],
                                    'fio' => $client[0]['fio'],
                                    'date' => date('d.m.Y', strtotime($order[0]['date_create'])),
                                    'news' => $news,
                                    'bonus_sum' => $bonus_sum,
                                    'bonus_writeoff' => $bonus_writeoff,
                                    'img' => '/img/print_img.png'
                                  );
            $print_order = View::factory('manager/VPrintPKS')->
                set('print_cash_register', $print_cash_register)->set('discounthistory', $discounthistory);
            $this->template->print_order = $print_order;
	}
        
        public function action_print_cash_register_fast()
	{
            //$this->auto_render = false;
            $title_site = 'Менеджер-панель';
            $this->template->title_site = 'Учет автозапчастей: Печать ПКО';
            $this->template->description  = '';
            $this->template->title_page  = null;
            $this->template->styles  = array('css/index.css');
            $order_id = (int)$this->request->param('order_id');
            $order = Model::factory('Manager_Order');
            $order = $order->get_order($order_id);
            $client = Model::factory('Manager_Client');
            $client = $client->get_client_for_order($order_id);
            $pay = $order[0]['sum']+$order[0]['balance'];
            $debt = abs($order[0]['balance'] < 0 ? $order[0]['balance'] : 0);
            $news = Model::factory('Manager_News');
            $news = $news->get_news('print');
            $news = isset($news[0]['text']) ? $news[0]['text'] : '';
            $discount = Model::factory('Manager_Discount');
            $discounthistory = $discount->get_discount_for_history($order_id);
            $print_cash_register = array(            
                                    'number' => $order[0]['id'],
                                    'date_make' => date('d.m.Y',strtotime($order[0]['date_create'])),
                                    'sum' => $order[0]['sum'],
                                    'pay' => $pay,
                                    'debt' => $debt,
                                    'delivery' => $order[0]['delivery'],
                                    'fio' => $client[0]['fio'],
                                    'date' => date('d.m.Y', strtotime($order[0]['date_create'])),
                                    'news' => $news,
                                    'img' => '/img/print_img.png'
                                  );
            $print_order = View::factory('manager/VPrintPKS')->
                set('print_cash_register', $print_cash_register)->set('discounthistory', $discounthistory);
            $this->template->script_print = "print()";
            $this->template->print_order = $print_order;
	}
        
        public function action_print_coins()
	{
            $title_site = 'Менеджер-панель';
            $this->template->title_site = 'Учет автозапчастей: Печать Пополнения баланса';
            $this->template->description  = '';
            $this->template->title_page  = null;
            $this->template->styles  = array('css/index.css');
            $order_id = (int)$this->request->param('order_id');
            $order = Model::factory('Manager_Order');
            $order = $order->get_order($order_id);
            $client = Model::factory('Manager_Client');
            $client = $client->get_client_for_order($order_id);
            $print_coins = null;
            $print_coins = array(
                                    'id' => $client[0]['id'],
                                    'fio' => $client[0]['fio'],
                                    'phone' => $client[0]['phone'],
                                    'order_id' => $order_id,
                                    'comment' => $order[0]['comment'],
                                    'sum' => $order[0]['sum']
                                  );
            $print_order = View::factory('manager/VPrintCoins')->set('print_coins', $print_coins);
            $this->template->print_order = $print_order;
	}
}
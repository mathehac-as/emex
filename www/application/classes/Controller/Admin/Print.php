<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Print extends Controller_Template {
            
        public $template = 'admin/VPrintOrder';
            
        public function action_print_invoice()
	{
            $title_site = 'Админ-панель';
            $this->template->title_site = 'Учет автозапчастей: Печать накладной';
            $this->template->description  = '';
            $this->template->title_page  = null;
            $this->template->styles  = array('css/index.css');
            $order_id = (int)$this->request->param('order_id');
            $order = Model::factory('Admin_Order');
            $order = $order->get_order($order_id);
            $client = Model::factory('Admin_Client');
            $client = $client->get_client_for_order($order_id);
            $print_invoice = null;
            $pay = $order[0]['sum']+$order[0]['balance'];
            $debt = ($order[0]['balance'] < 0 ? $order[0]['balance'] : 0);
            $print_invoice = array(
                                    'id' => $order_id,
                                    'fio' => $client[0]['fio'],
                                    'phone' => $client[0]['phone'],
                                    'marka_avto' => $client[0]['marka_avto'],
                                    'vin' => $client[0]['vin'],
                                    'percent_discount' => $client[0]['percent_discount'],
                                    'delivery' => $order[0]['delivery'],
                                    'comment' => $order[0]['comment'],
                                    'sum' => $order[0]['sum'],
                                    'pay' => $pay,
                                    'debt' => $debt
                                  );
            $print_order = View::factory('admin/VPrintInvoice')->set('print_invoice', $print_invoice);
            $this->template->print_order = $print_order;
	}
}
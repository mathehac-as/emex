<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Json extends Controller 
{     
    public function action_get_order()
    {
        $result = null;
        $order = Model::factory('Admin_Order');
        $order_id = $this->request->param('order_id');
        $client_fio = $order->get_client_for_order_id($order_id);
        $result['client_fio'] = isset($client_fio[0]['fio']) ? $client_fio[0]['fio'] : '';                 
        $this->request->headers('Content-type','application/json; charset='.Kohana::$charset);
        $this->response->body(json_encode($result));
    }
}
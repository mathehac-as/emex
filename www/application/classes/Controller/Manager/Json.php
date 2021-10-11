<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Json extends Controller 
{     
    public function action_get_order()
    {
        $result = null;
        $order = Model::factory('Manager_Order');
        $order_id = $this->request->param('order_id');
        $client_fio = $order->get_client_for_order_id($order_id);
        $result['client_fio'] = isset($client_fio[0]['fio']) ? $client_fio[0]['fio'] : '';                 
        $this->request->headers('Content-type','application/json; charset='.Kohana::$charset);
        $this->response->body(json_encode($result));
    }
    
    public function action_get_order_abcp()
    {
        $result = null;
        $order = Model::factory('Manager_Order');
        $order_abcp_id = $this->request->param('order_abcp_id');
        $client_fio = $order->get_client_for_order_abcp_id($order_abcp_id);
        $result['client_fio'] = isset($client_fio[0]['fio']) ? $client_fio[0]['fio'] : '';                 
        $this->request->headers('Content-type','application/json; charset='.Kohana::$charset);
        $this->response->body(json_encode($result));
    }
    
    public function action_get_emex_abcp() 
    {           
        $msg = '';
        $result['error'] = '';
        try
        {
            $number_id = $this->request->param('number_id');
            if(!empty($number_id))
            {
                $main = Kohana::$config->load('main');
                $userpsw = $main->get('abcp_pass');
                $userlogin = $main->get('abcp_user');
                $url = $main->get('abcp_url');
                $url = $url.'?userlogin='.$userlogin.'&userpsw='.$userpsw.'&number='.$number_id;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                $data = curl_exec($ch);
                $result['data'] = json_decode($data);
                curl_close($ch);
            }
            else 
            {
                $result['error'] = 'Ошибка - нет парамметров';
            }
        }
        catch (Exception $e)
        {
            $result['error'] = $e->getMessage();
        }
        $this->request->headers('Content-type','application/json; charset='.Kohana::$charset);
        $this->response->body(json_encode($result));
    }
}
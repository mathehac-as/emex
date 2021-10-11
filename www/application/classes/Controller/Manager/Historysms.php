<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Historysms extends Controller_Template {
            
        public $template = 'manager/VPanelCenterHistorySMSHistory';
            
        public function action_get_history()
	{
            $historysms = Model::factory('Manager_Historysms');
            $client_id = (int)$this->request->param('client_id');
            if($client_id == 0)
            {
                $historys_list = $historysms->get_historys_zero();
            }
            else 
            {
                $historys_list = $historysms->get_historys($client_id);
            }
            $historys = array();
            if(isset($historys_list))
            {
                foreach ($historys_list as $value) 
                {
                    $historys[] =  array(
                                    'id' => $value['id'],
                                    'base' => $value['base'],
                                    'comment' => $value['comment'],
                                    'date_history' => $value['date_history'],
                                    'order_id' => (isset($value['order_id']) ? $value['order_id'] : ''),
                                    'fio' => $value['fio']
                                );
                }
            }
            $this->template->historys = $historys;
	}
        
        public function action_get_send_sms_one()
	{
            $send_sms_one =  array(
                                'title' => 'Посылка смс клиенту',
                                'phone' => '',
                                'message' => '',
                                'js_save' => 'sendSMSOne()'
                            );
            $this->template->send_sms_one = $send_sms_one;
            $this->template->act = 'send_sms_one';
	}
        
        public function action_send_sms_one()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $phone_number = urlencode(isset($post['phone_number']) ? $post['phone_number'] : '');
                    $message = urlencode(isset($post['message']) ? $post['message'] : '');
                    $main = Kohana::$config->load('main');
                    $from = $main->get('sms_from');
                    $pass = $main->get('sms_pass');
                    $user = $main->get('sms_user');
                    $url = $main->get('sms_url');
                    $message_id = date('ymdHis').rand(0,100);
                    $url .= '?id='.$message_id.'&login='.$user.'&password='.$pass.'&service=1&space_force=1&space='.$from.'&subno='.$phone_number.'&text='.$message;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    $format_message_id = $main->get('format_message_id');
                    if(!isset($result) || $result != "OK")
                    {
                        throw new Exception('Ошибка: СМС не послано(http)!');
                    }
                    $journal = Model::factory('Manager_Journal');                  
                    $data = array();
                    $user_name = Auth::instance()->get_user();
                    $data['base'] = '(Без заказа) СМС послано на тел.'.$phone_number.'; СМС идентификатор - '.$message_id;
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
        
        public function action_get_delivery_sms()
	{
            $user_name = Auth::instance()->get_user();
            $manager = Model::factory('Manager_User');
            $office = $manager->get_office_for_manager(array('user_id' => $user_name->id));
            $office_id = 0;
            $client_lists = null;
            if(isset($office[0]['id']) && (int)$office[0]['id'] != 0)
            {
                $office_id = (int)$office[0]['id'];
                $client = Model::factory('Manager_Client');
                $group_id = $client->get_group_id($office_id);
                $group_id = (int)$group_id[0]['id'];
                $history_sms = Model::factory('Manager_Historysms');
                $client_lists = $history_sms->get_clients($office_id, $group_id);
            }
            $delivery_sms =  array(
                            'title' => 'Рассылка СМС',
                            'phone' => '',
                            'message' => '',
                            'js_save' => 'deliverySMS()'
                        );
            $this->template->delivery_sms = $delivery_sms;
            $this->template->client_lists = $client_lists;
            $this->template->act = 'delivery_sms';
	}
        
        public function action_delivery_sms()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    if(isset($post['phone_number']) && count($post['phone_number']) > 0)
                    {
                        $message_count = 0;
                        $message = iconv('utf-8', 'cp1251', (isset($post['message']) ? $post['message'] : ''));
                        $comment = iconv('utf-8', 'cp1251', (isset($post['comment']) ? $post['comment'] : ''));
                        $main = Kohana::$config->load('main');
                        $from = $main->get('sms_from');
                        $pass = $main->get('sms_pass');
                        $user = $main->get('sms_user');
                        $url = $main->get('sms_url');
                        foreach ($post['phone_number'] as $value) 
                        {
                            $message_id = date('ymdHis').rand(0,100);
                            $url .= '?id='.$message_id.'&login='.$user.'&password='.$pass.'&service=1&space_force=1&space='.$from.'&subno='.$phone_number.'&text='.$message;
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                            $result = curl_exec($ch);
                            curl_close($ch);

                            $format_message_id = $main->get('format_message_id');
                            if(!isset($result) || $result != "OK")
                            {
                                $message_count++;
                            }
                        }
                        $journal = Model::factory('Manager_Journal');                  
                        $data = array();
                        $user_name = Auth::instance()->get_user();
                        $data['base'] = 'Рассылка СМС выполнена: кол-во клиентов - ' . count($post['phone_number']) . ', кол-во СМС - ' . 
                                        $message_count . ', текст СМС - ' . $message;
                        $data['date_history'] = date('Y-m-d H:i:s');
                        $data['journal_type_id'] = 10;
                        $data['user_id'] = $user_name->id;
                        $data['comment'] = $comment;
                        $res = $journal->save_journal($data);
                        if(isset($res[0]) && (int)$res[0] > 0)
                        {
                            $msg = 'Рассылка СМС выполнена: количество клиентов - ' . count($post['phone_number']) . ', количество СМС - ' . $message_count;
                        }
                        else 
                        {
                            throw new Exception('Ошибка: Рассылка СМС не выполнена!');
                        }
                    }
                    else 
                    {
                        throw new Exception('Ошибка: СМС не послано!(client_lists)');
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
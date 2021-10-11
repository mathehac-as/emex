<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Officecash extends Controller_Template {
            
        public $template = 'admin/VPanelCenterOfficeCash';
            
        public function action_get_cash()
	{
            $office_id = (int)$this->request->param('office_id');
            if($post = $this->request->post())
            {
                $title = '';
                $type = '';
                if($post['type'] == 'outcash')
                {
                    $title = 'Инкассация';
                    $type = $post['type'];
                }
                elseif($post['type'] == 'incash')
                {
                    $title = 'Внести в кассу';
                    $type = $post['type'];
                }
                elseif($post['type'] == 'correction')
                {
                    $title = 'Коррекция';
                    $type = $post['type'];
                }
                $cash =  array(
                                'title' => $title,
                                'office_id' => $office_id,
                                'type' => $type,
                                'js_save' => 'officeCashSave(this)'
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
                    $balance = $office->get_balance($office_id);
                    $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                    if ($post['type'] == 'outcash')
                    {
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
                        $msg = 'Инкассация выполнена';
                    }
                    elseif ($post['type'] == 'incash')
                    {
                        $data['balance'] = $balance+$sum;
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
                        $data['type_history'] = 'incash';
                        $data['user_id'] = $user_name->id;
                        $res = $officehistory->save_office_history($data);
                        $msg = 'Сумма внесна в кассу';
                    }
                    elseif ($post['type'] == 'correction')
                    {    
                        $data['balance'] = $balance+($sum);
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
                        $data['type_history'] = 'correction';
                        $data['user_id'] = $user_name->id;
                        $res = $officehistory->save_office_history($data);
                        $msg = 'Коррекция выполнена';
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
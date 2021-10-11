<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Discount extends Controller_Template {
            
        public $template = 'manager/VPanelCenterDiscountDiscount';
            
        public function action_get_discount()
	{
            $discount = Model::factory('Manager_Discount');
            $discount_id = (int)$this->request->param('discount_id');
            $discount = $discount->get_discount($discount_id);
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            if(isset($discount[0]))
            {
                $birthday = '';
                if(isset($discount[0]['d_birthday']) && !empty($discount[0]['d_birthday']))
                {
                    $date = new DateTime($discount[0]['d_birthday']);
                    $birthday = $date->format('d.m.Y');
                }
                $discount =  array(
                            'id' => $discount[0]['d_id'],
                            'number' => $discount[0]['d_number'],
                            'number_code' => $discount[0]['d_number_code'],
                            'fio' => $discount[0]['d_fio'],
                            'birthday' => $birthday,
                            'phone' => $discount[0]['d_phone'],
                            'address' => $discount[0]['d_address'],
                            'percent' => $discount[0]['d_percent'],
                            'bonus' => $discount[0]['d_bonus'],
                            'title_save' => 'Редактирование карты',
                            'img_save' => '/img/edit.png',
                            'js_save' => 'discountEdit(this)'
                        );
            }
            else 
            {
                $discount = null;
            }
            $this->template->discount = $discount;
            $this->template->accesses = $accesses;
	}
        
        public function action_discount_add()
	{
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $discount =  array(
                            'title' => 'Добавление карты',
                            'id' => 0,
                            'number' => '',
                            'number_code' => '',
                            'fio' => '',
                            'birthday' => '',
                            'phone' => '',
                            'address' => '',
                            'percent' => '',
                            'bonus' => '',
                            'percent_fixed' => 0,
                            'bonus_no_writeoff' => 0,
                            'js_save' => 'discountSave(this)'
                        );
            $this->template->discount = $discount;
            $this->template->accesses = $accesses;
            $this->template->act = 'add';
	}        

        public function action_discount_edit()
	{
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $discount = Model::factory('Manager_Discount');
            $discount_id = (int)$this->request->param('discount_id');
            $discount = $discount->get_discount(array('discount_id' => $discount_id));  
            if(isset($discount[0]))
            {
                $birthday = '';
                if(isset($discount[0]['d_birthday']) && !empty($discount[0]['d_birthday']))
                {
                    $date = new DateTime($discount[0]['d_birthday']);
                    $birthday = $date->format('d.m.Y');
                }
                $discount =  array(
                            'title' => 'Редактирование карты',
                            'id' => $discount[0]['d_id'],
                            'number' => $discount[0]['d_number'],
                            'number_code' => $discount[0]['d_number_code'],
                            'fio' => $discount[0]['d_fio'],
                            'birthday' => $birthday,
                            'phone' => $discount[0]['d_phone'],
                            'address' => $discount[0]['d_address'],
                            'percent' => $discount[0]['d_percent'],
                            'bonus' => $discount[0]['d_bonus'],
                            'bonus_no_writeoff' => $discount[0]['d_bonus_no_writeoff'],
                            'percent_fixed' => $discount[0]['d_percent_fixed'],
                            'js_save' => 'discountUpdate(this)'
                        );
            }
            else 
            {
                $discount = null;
            }
            $this->template->accesses = $accesses;
            $this->template->discount = $discount;
            $this->template->act = 'edit';
	}        
        
        public function action_save_discount()
	{
            $msg = '';
            $discount_one = null;
            try
            {
                if($post = $this->request->post())
                {
                    $user_name = Auth::instance()->get_user();
                    $access = Model::factory('Manager_Access');
                    $accesses_user = $access->get_accesses($user_name->id);
                    $accesses = array();
                    foreach ($accesses_user as $value) 
                    {
                        $accesses[] = $value['access_id'];
                    }
                    $discount = Model::factory('Manager_Discount');                  
                    $data = array(); 
                    if ($post['action'] == 'add')
                    {
                        $res = $discount->exists_discount($post['number']);
                        if(isset($res[0]))
                        {
                            throw new Exception('Ошибка: Карта уже существует!');
                        }       
                        $birthday = '';
                        if(isset($post['birthday']) && !empty($post['birthday']))
                        {
                            $date = new DateTime($post['birthday']);
                            $birthday = $date->format('Y-m-d');
                        }
                        $data['d_number'] = $post['number'];
                        $data['d_number_code'] = $post['number_code'];
                        $data['d_fio'] = $post['fio'];
                        $data['d_birthday'] = $birthday;
                        $data['d_phone'] = $post['phone'];
                        $data['d_address'] = $post['address'];
                        $data['d_percent'] = (int)$post['percent'];
                        $data['d_bonus'] = (int)$post['bonus'];
                        $data['d_bonus_no_writeoff'] = (int)$post['bonus_no_writeoff'];
                        $data['d_percent_fixed'] = (int)$post['percent_fixed']; 
                        $res = $discount->save_discount($data);
                        if(isset($res[0]) && (int)$res[0] >0)
                        {
                            $discount_id = $res[0];
                            if(!isset($discount_id) || $discount_id == 0)
                            {
                                throw new Exception('Ошибка: Неопределен идентификатор карты!');
                            }

                            $discount = $discount->get_discount($discount_id);     
                            if(isset($discount[0]))
                            {
                                $birthday = '';
                                if(isset($discount[0]['d_birthday']) && !empty($discount[0]['d_birthday']))
                                {
                                    $date = new DateTime($discount[0]['d_birthday']);
                                    $birthday = $date->format('d.m.Y');
                                }
                                $discount_one =  array(
                                                    'id' => $discount[0]['d_id'],
                                                    'number' => $discount[0]['d_number'],
                                                    'number_code' => $discount[0]['d_number_code'],
                                                    'fio' => $discount[0]['d_fio'],
                                                    'birthday' => $birthday,
                                                    'phone' => $discount[0]['d_phone'],
                                                    'address' => $discount[0]['d_address'],
                                                    'percent' => $discount[0]['d_percent'],
                                                    'bonus' => $discount[0]['d_bonus'],
                                                    'bonus_no_writeoff' => $discount[0]['d_bonus_no_writeoff'],
                                                    'title_save' => 'Редактирование карты',
                                                    'img_save' => '/img/edit.png',
                                                    'js_save' => 'discountEdit(this)'
                                                );
                            }
                        }
                        $msg = 'Данные о карте добавлены';
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $discount_id = (int)$this->request->param('discount_id');
                        if(!isset($discount_id) || $discount_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор карты!');
                        }
                        $birthday = '';
                        if(isset($post['birthday']) && !empty($post['birthday']))
                        {
                            $date = new DateTime($post['birthday']);
                            $birthday = $date->format('Y-m-d');
                        }
                        $data['d_number'] = $post['number'];
                        $data['d_number_code'] = $post['number_code'];
                        $data['d_fio'] = $post['fio'];
                        $data['d_birthday'] = $birthday;
                        $data['d_phone'] = $post['phone'];
                        $data['d_address'] = $post['address'];
                        $data['d_percent'] = (int)$post['percent'];
                        $data['d_bonus'] = (int)$post['bonus'];
                        $data['d_bonus_no_writeoff'] = (int)$post['bonus_no_writeoff'];
                        $data['d_percent_fixed'] = (int)$post['percent_fixed'];
                        $res = $discount->update_discount($discount_id, $data);
                        
                        if((int)$post['bonus_before'] != (int)$post['bonus'])
                        {
                            $user_name = Auth::instance()->get_user();
                            $data = array();  
                            $data['dl_comment'] = 'Обновление бонусных баллов';
                            $data['dl_date_create'] = date('Y-m-d H:i:s');
                            $data['dl_before'] = (int)$post['bonus_before'];
                            $data['dl_after'] = (int)$post['bonus'];
                            $data['user_id'] = $user_name->id;
                            $data['dl_discount_id'] = $discount_id;
                            $res = $discount->save_discount_change_history($data);
                        }
                        $discount = $discount->get_discount($discount_id);     
                        if(isset($discount[0]))
                        {
                                $birthday = '';
                                if(isset($discount[0]['d_birthday']) && !empty($discount[0]['d_birthday']))
                                {
                                    $date = new DateTime($discount[0]['d_birthday']);
                                    $birthday = $date->format('d.m.Y');
                                }
                                $discount_one =  array(
                                           'id' => $discount[0]['d_id'],
                                            'number' => $discount[0]['d_number'],
                                            'number_code' => $discount[0]['d_number_code'],
                                            'fio' => $discount[0]['d_fio'],
                                            'birthday' => $birthday,
                                            'phone' => $discount[0]['d_phone'],
                                            'address' => $discount[0]['d_address'],
                                            'percent' => $discount[0]['d_percent'],
                                            'bonus' => $discount[0]['d_bonus'],
                                            'bonus_no_writeoff' => $discount[0]['d_bonus_no_writeoff'],
                                            'title_save' => 'Редактирование карты',
                                            'img_save' => '/img/edit.png',
                                            'js_save' => 'discountEdit(this)'
                                        );
                        }
                        $msg = 'Данные о карте обновлены';
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
            $this->template->accesses = $accesses;
            $this->template->discount = $discount_one;
            $this->template->msg = $msg;
	}
}
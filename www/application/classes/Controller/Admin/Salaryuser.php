<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Salaryuser extends Controller_Template {
            
        public $template = 'admin/VPanelCenterSalaryUser';
            
        public function action_get_user()
	{
            $user = Model::factory('Admin_User');
            $user_id = (int)$this->request->param('user_id');
            $user = $user->get_user_no_role(array('user_id' => $user_id));
            $user_act = array('img' => '/img/payment.png', 'js' => 'salaryGive()'); 
            if(isset($user[0]))
            {
                $user =  array(
                            'id' => $user[0]['id'],
                            'fio' => $user[0]['fio'],
                            'img_save' => '/img/edit.png',
                            'js_save' => 'userSalaryEdit(this)',
                            'img_del' => '/img/del.png',
                            'js_del' => 'userSalaryDel(this)'
                        );
            }
            else 
            {
                $user = null;
                $this->template->warning = 'Для редактирования сотрудника перейдите в раздел Менеджеры/офисы';
            }
            $this->template->user_act = $user_act;
            $this->template->user = $user;
        }

        public function action_user_add()
	{
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $user =  array(
                            'title' => 'Добавление сотрудника',
                            'id' => 0,
                            'fio' => '',
                            'position' => '',
                            'phone' => '',
                            'office_id' => 0,
                            'passport' => '',
                            'date_birth' => '',
                            'number_card' => '',
                            'email' => '',
                            'comment' => '', 
                            'js_save' => 'userSalarySave(this)'
                        );
            $this->template->offices = $offices;
            $this->template->user = $user;
            $this->template->act = 'add';
	}
        
        public function action_user_edit()
	{
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $user = Model::factory('Admin_User');
            $user_id = (int)$this->request->param('user_id');
            $user_one = $user->get_user(array('user_id' => $user_id));  
            $birthday = '';
            if(isset($user_one[0]['date_birth']) && !empty($user_one[0]['date_birth']))
            {
                $date = new DateTime($user_one[0]['date_birth']);
                $birthday = $date->format('d.m.Y');
            }
            if(isset($user_one[0]))
            {
                $user_one =  array(
                                'title' => 'Редактирование сотрудника',
                                'id' => $user_one[0]['id'],
                                'fio' => $user_one[0]['fio'],
                                'position' => $user_one[0]['position'],
                                'phone' => $user_one[0]['phone'],
                                'office_id' => $user_one[0]['office_id'],
                                'passport' => $user_one[0]['passport'],
                                'date_birth' => $birthday,
                                'number_card' => $user_one[0]['number_card'],
                                'email' => $user_one[0]['email'],
                                'comment' => $user_one[0]['comment'], 
                                'js_save' => 'userSalaryUpdate(this)'
                            );
            }
            else 
            {
                $user_one = null;
            }
            $this->template->offices = $offices;
            $this->template->user = $user_one;
            $this->template->act = 'edit';
	}
        
        public function action_save_user()
	{
            $msg = '';
            $user = null;
            $user_act = array('img' => '/img/payment.png', 'js' => 'salaryGive()'); 
            try
            {
                if($post = $this->request->post())
                {
                    $user = Model::factory('Admin_User');  
                    $data = array();   
                    if ($post['action'] == 'add')
                    {
                        if(empty($post['fio']))
                        {
                            throw new Exception('Ошибка: Неопределен ФИО сотрудника!');
                        }
                        if(isset($post['date_birth']) && !empty($post['date_birth']))
                        {
                            $date = new DateTime($post['date_birth']);
                            $birthday = $date->format('Y-m-d');
                        }
                        $data['fio'] = $post['fio'];
                        $data['username'] = strtolower($this->translit(htmlspecialchars($post['fio'])));
                        $data['position'] = $post['position'];
                        $data['phone'] = $post['phone'];
                        $data['office_id'] = $post['office_id'];
                        $data['passport'] = $post['passport'];
                        $data['date_birth'] = $birthday;
                        $data['number_card'] = $post['number_card'];
                        $data['email'] = $post['email'];
                        $data['comment'] = $post['comment'];
                        $res = $user->save_user($data);
                        if(isset($res[0]) && (int)$res[0] >0)
                        {
                            $user_id = $res[0];
                            if(!isset($user_id) || $user_id == 0)
                            {
                                throw new Exception('Ошибка: Неопределен идентификатор сотрудника!');
                            }
                            $user = $user->get_user_no_role(array('user_id' => $user_id));
                            if(isset($user[0]))
                            {
                                $user =  array(
                                            'id' => $user[0]['id'],
                                            'fio' => $user[0]['fio'],
                                            'img_save' => '/img/edit.png',
                                            'js_save' => 'userSalaryEdit(this)',
                                            'img_del' => '/img/del.png',
                                            'js_del' => 'userSalaryDel(this)'
                                        );
                            }
                            else 
                            {
                                $user = null;
                                $this->template->warning = 'Для редактирования сотрудника перейдите в раздел Менеджеры/офисы';
                            }
                        }
                        $msg = 'Данные о сотруднике добавлены';
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $user_id = (int)$this->request->param('user_id');
                        if(!isset($user_id) || $user_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор сотрудника!');
                        }
                        if(empty($post['fio']))
                        {
                            throw new Exception('Ошибка: Неопределен ФИО сотрудника!');
                        }
                        $birthday = '';
                        if(isset($post['date_birth']) && !empty($post['date_birth']))
                        {
                            $date = new DateTime($post['date_birth']);
                            $birthday = $date->format('Y-m-d');
                        }
                        
                        $data['fio'] = $post['fio'];
                        $data['username'] = strtolower($this->translit(htmlspecialchars($post['fio'])));
                        $data['position'] = $post['position'];
                        $data['phone'] = $post['phone'];
                        $data['office_id'] = $post['office_id'];
                        $data['passport'] = $post['passport'];
                        $data['date_birth'] = $birthday;
                        $data['number_card'] = $post['number_card'];
                        $data['email'] = $post['email'];
                        $data['comment'] = $post['comment'];
                        $res = $user->update_user($user_id, $data);
                        $user = $user->get_user_no_role(array('user_id' => $user_id));
                        if(isset($user[0]))
                        {
                            $user =  array(
                                        'id' => $user[0]['id'],
                                        'fio' => $user[0]['fio'],
                                        'img_save' => '/img/edit.png',
                                        'js_save' => 'userSalaryEdit(this)',
                                        'img_del' => '/img/del.png',
                                        'js_del' => 'userSalaryDel(this)'
                                    );
                        }
                        else 
                        {
                            $user = null;
                            $this->template->warning = 'Для редактирования сотрудника перейдите в раздел Менеджеры/офисы';
                        }
                        $msg = 'Данные о сотруднике обновлены';
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
            $this->template->user_act = $user_act;
            $this->template->user = $user;
	}
        
        public function action_del_user()
	{
            $msg = '';
            try
            {
                $user = Model::factory('Admin_User');  
                $user_id = (int)$this->request->param('user_id');
                if(!isset($user_id) || $user_id == 0)
                {
                    throw new Exception('Ошибка: Неопределен идентификатор сотрудника!');
                }
                $res = $user->del_user($user_id);
                if(!$res)
                {
                    throw new Exception('Ошибка: Сотрудник не удален из базы!');
                }
                $msg = 'Сотрудник удален';
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
        
        private function translit($str) 
        {
            $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 
                         'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 
                         'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 
                         'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 
                         'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 
                         'ъ', 'ы', 'ь', 'э', 'ю', 'я');
            $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 
                         'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 
                         'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 
                         'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 
                         'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 
                         'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
            return str_replace($rus, $lat, $str);
        }
}
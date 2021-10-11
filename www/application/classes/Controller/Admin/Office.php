<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Office extends Controller_Template {
            
        public $template = 'admin/VPanelCenterOfficeOffice';
            
        public function action_office_add()
	{
            $office =  array(
                            'title' => 'Добавление офиса',
                            'id' => 0,
                            'name' => '',
                            'phone' => '',
                            'comment' => '',
                            'js_save' => 'officeSave(this)'
                        );

            $this->template->office = $office;
	}
        
        public function action_office_edit()
	{
            $office = Model::factory('Admin_Office');
            $office_id = (int)$this->request->param('office_id');
            $office = $office->get_office(array('office_id' => $office_id));
            if(isset($office[0]))
            {
                $office =  array(
                                'title' => 'Редактирование офиса',
                                'id' => $office[0]['id'],
                                'name' => $office[0]['name'],
                                'phone' => $office[0]['phone'],
                                'comment' => $office[0]['comment'],
                                'js_save' => 'officeUpdate(this)'
                            );
            }
            else 
            {
                $office = null;
            }
            $this->template->office = $office;
	}
        
        public function action_office_link()
	{
            $office = Model::factory('Admin_Office');
            $office_id = (int)$this->request->param('office_id');
            $office_one = $office->get_office(array('office_id' => $office_id));
            $office_groups = $office->get_office_groups();
            if(isset($office_one[0]['id']))
            {
                $office_link =  array(
                                'title' => 'Связать офиса с группой',
                                'id' => $office_one[0]['id'],
                                'office_groups' => $office_groups,
                                'js_save' => 'officeLinkSave(this)'
                            );
            }
            else 
            {
                $office_link = null;
            }
            $this->template->office_link = $office_link;
	}
        
        public function action_save_office()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $office = Model::factory('Admin_Office');                  
                    $data = array();   
                    if ($post['action'] == 'add')
                    {
                        $data['name'] = $post['name'];
                        $data['phone'] = $post['phone'];
                        $data['comment'] = $post['comment'];
                        $res = $office->save_office($data);
                        if(!$res) 
                        {
                            throw new Exception('Ошибка: Офис не добавлен!');
                        }
                        $msg = 'Данные о офисе добавлены';
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $office_id = (int)$this->request->param('office_id');
                        if(!isset($office_id) || $office_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор офиса!');
                        }                      
                        $data['name'] = $post['name'];
                        $data['phone'] = $post['phone'];
                        $data['comment'] = $post['comment'];
                        $res = $office->update_office($office_id, $data);
                        $msg = 'Данные о офисе обновлены';
                    }
                    elseif ($post['action'] == 'link')
                    {
                        $office_id = (int)$this->request->param('office_id');
                        if(!isset($office_id) || $office_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор офиса!');
                        }                      
                        $data['office_group_id'] = $post['group_id'];
                        $data['office_id'] = $office_id;
                        $res = $office->save_office_belong_group($data);
                        if(!$res) 
                        {
                            throw new Exception('Ошибка: Офис не связан!');
                        }
                        $msg = 'Офис связан с группой';
                    }
                    elseif ($post['action'] == 'unlink')
                    {
                        $office_id = (int)$this->request->param('office_id');
                        if(!isset($office_id) || $office_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор офиса!');
                        }                      
                        $res = $office->del_office_belong_group($office_id);
                        if(!$res) 
                        {
                            throw new Exception('Ошибка: Офис не отвязан!');
                        }
                        $msg = 'Офис отвязан от группы';
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
        
        public function action_del_office()
	{
            $msg = '';
            try
            {
                $office = Model::factory('Admin_Office');  
                $office_id = (int)$this->request->param('office_id');
                if(!isset($office_id) || $office_id == 0)
                {
                    throw new Exception('Ошибка: Неопределен идентификатор офиса!');
                }
                $res = $office->del_office($office_id);
                if(!$res)
                {
                    throw new Exception('Ошибка: Офис не удален из базы!');
                }
                $msg = 'Офис удален';
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
}
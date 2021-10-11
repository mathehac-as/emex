<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Typeoper extends Controller_Template {
            
        public $template = 'admin/VPanelCenterTypeoperTypeoper';
            
        public function action_typeoper_add()
	{
            $typeoper=  array(
                            'title' => 'Добавление операции',
                            'id' => 0,
                            'name' => '',
                            'js_save' => 'typeoperSave(this)'
                        );

            $this->template->typeoper = $typeoper;
	}

        public function action_typeoper_edit()
	{
            $typeoper = Model::factory('Admin_Typeoper');
            $typeoper_id = (int)$this->request->param('typeoper_id');
            $typeoper = $typeoper->get_typeoper(array('typeoper_id' => $typeoper_id));  
            if(isset($typeoper[0]))
            {
                $typeoper =  array(
                            'title' => 'Редактирование операции',
                            'id' => $typeoper[0]['id'],
                            'name' => $typeoper[0]['name'],
                            'js_save' => 'typeoperUpdate(this)'
                        );
            }
            else 
            {
                $typeoper = null;
            }
            $this->template->typeoper = $typeoper;
	}        
        
        public function action_save_typeoper()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $typeoper = Model::factory('Admin_Typeoper');                  
                    $data = array();   
                    if ($post['action'] == 'add')
                    {
                        $data['name'] = $post['name'];
                        $res = $typeoper->save_typeoper($data);
                        if(!$res) 
                        {
                            throw new Exception('Ошибка:Операция не добавлена!');
                        }
                        $msg = 'Данные о операции добавлены';
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $typeoper_id = (int)$this->request->param('typeoper_id');
                        if(!isset($typeoper_id) || $typeoper_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор операции!');
                        }
   
                        $data['name'] = $post['name'];
                        $res = $typeoper->update_typeoper($typeoper_id, $data);
                        $msg = 'Данные о операции обновлены';
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
        
        public function action_del_typeoper()
	{
            $msg = '';
            try
            {
                $typeoper = Model::factory('Admin_Typeoper');  
                $typeoper_id = (int)$this->request->param('typeoper_id');
                if(!isset($typeoper_id) || $typeoper_id == 0)
                {
                    throw new Exception('Ошибка: Неопределен идентификатор операции!');
                }
                $res = $typeoper->del_typeoper($typeoper_id);
                if(!$res)
                {
                    throw new Exception('Ошибка: Операция не удалена из базы!');
                }
                $msg = 'Операция удалена';
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
}
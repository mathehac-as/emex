<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Typeexpenses extends Controller_Template {
            
        public $template = 'manager/VPanelCenterTypeExpenses';
            
        public function action_get_typeexpenses()
	{
            $typeexpenses = Model::factory('Manager_Typeexpenses');
            $typeexpenses_id = (int)$this->request->param('typeexpenses_id');
            $typeexpenses = $typeexpenses->get_typeexpenses(array('typeexpenses_id' => $typeexpenses_id));
            $typeexpenses_act = array('img' => '/img/payment.png', 'js' => 'expensesGive()'); 
            $this->template->typeexpenses_act = $typeexpenses_act;
            if(isset($typeexpenses[0]))
            {
                $typeexpenses =  array(
                            'id' => $typeexpenses[0]['id'],
                            'name' => $typeexpenses[0]['name'],
                            'img_save' => '/img/save.png',
                            'js_save' => 'typeExpensesUpdate(this)',
                            'img_del' => '/img/del.png',
                            'js_del' => 'typeExpensesDel(this)'
                        );
            }
            else 
            {
                $typeexpenses = null;
            }
            $this->template->typeexpenses = $typeexpenses;
        }

        public function action_typeexpenses_add()
	{
            $typeexpenses =  array(
                            'id' => 0,
                            'name' => '',
                            'img_save' => '/img/save.png',
                            'js_save' => 'typeExpensesSave(this)',
                            'img_cansel' => '/img/cansel.png',
                            'js_cansel' => 'typeExpensesCansel(this)'
                        );
            $this->template->typeexpenses = $typeexpenses;
	}        
        
        public function action_save_typeexpenses()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $typeexpenses = Model::factory('Manager_Typeexpenses');                  
                    $data = array();   
                    if ($post['action'] == 'add')
                    {
                        $data['name'] = $post['name'];
                        $res = $typeexpenses->save_typeexpenses($data);
                        if(!$res) 
                        {
                            throw new Exception('Ошибка: Тип расходов не добавлен!');
                        }
                        $msg = 'Данные о типе расходов добавлены';
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $typeexpenses_id = (int)$this->request->param('typeexpenses_id');
                        if(!isset($typeexpenses_id) || $typeexpenses_id == 0)
                        {
                            throw new Exception('Ошибка: Неопределен идентификатор типа расходов!');
                        }
                        
                        $data['name'] = $post['name'];
                        $res = $typeexpenses->update_typeexpenses($typeexpenses_id, $data);
                        $msg = 'Данные о типе расходов обновлены';
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
        
        public function action_del_typeexpenses()
	{
            $msg = '';
            try
            {
                $typeexpenses = Model::factory('Manager_Typeexpenses');  
                $typeexpenses_id = (int)$this->request->param('typeexpenses_id');
                if(!isset($typeexpenses_id) || $typeexpenses_id == 0)
                {
                    throw new Exception('Ошибка: Неопределен идентификатор типа расходов!');
                }
                $res = $typeexpenses->del_typeexpenses($typeexpenses_id);
                if(!$res)
                {
                    throw new Exception('Ошибка: Тип расходов не удален из базы!');
                }
                $msg = 'Тип расходов удален';
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
}
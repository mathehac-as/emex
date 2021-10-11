<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Access extends Controller_Template {
            
    public $template = 'admin/VPanelCenterAccessAccess';

    public function action_get_accesses()
    {
        $access = Model::factory('Admin_Access');
        $user_id = (int)$this->request->param('user_id');
        $access_lists = $access->get_accesses(array('user_id' => $user_id));
        $this->template->access_lists = $access_lists;
    }

    public function action_access_check()
    { 
        $msg = '';
        try
        {
            if($post = $this->request->post())
            {
                $data['user_id'] = $post['user_id'];
                $data['access_id'] = $post['access_id'];
                
                $access = Model::factory('Admin_Access');
                if($post['check'])
                {
                    $res = $access->save_user($data);
                }
                else 
                {
                    $res = $access->del_user($data);
                }
                if(!$res) 
                {
                    throw new Exception('Ошибка: Данные о доступе не обновлены!');
                }
                $msg = 'Данные о доступе обновлены';
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
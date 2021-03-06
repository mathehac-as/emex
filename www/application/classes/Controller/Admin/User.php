<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Template {
            
        public $template = 'admin/VPanelCenterOfficeUser';
            
        public function action_get_user()
	{
            $user = Model::factory('Admin_User');
            $user_id = (int)$this->request->param('user_id');
            $user = $user->get_user(array('user_id' => $user_id));
            if(isset($user[0]))
            {
                $user =  array(
                            'id' => $user[0]['id'],
                            'fio' => $user[0]['fio'],
                            'login' => $user[0]['login'],
                            'is_active' => $user[0]['is_active'],
                            'office_id' => $user[0]['office_id'],
                            'img_save' => '/img/save.png',
                            'js_save' => 'userUpdate(this)',
                            'img_emex' => '/img/emex.png',
                            'js_emex' => 'userEmexEdit(this)',
                            'img_del' => '/img/del.png',
                            'js_del' => 'userDel(this)'
                        );
            }
            else 
            {
                $user = null;
            }
            
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $this->template->user = $user;
            $this->template->offices = $offices;
	}

        public function action_user_add()
	{
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            
            $user =  array(
                            'id' => 0,
                            'fio' => '',
                            'login' => '',
                            'is_active' => 0,
                            'office_id' => '',
                            'img_save' => '/img/save.png',
                            'js_save' => 'userSave(this)',
                            'img_cansel' => '/img/cansel.png',
                            'js_cansel' => 'userCansel(this)'
                        );
            
            $this->template->user = $user;
            $this->template->offices = $offices;
	}      
        
        public function action_user_edit_emex()
	{
            $user = Model::factory('Admin_User');
            $user_id = (int)$this->request->param('user_id');
            $user = $user->get_user(array('user_id' => $user_id));

            if(isset($user[0]))
            {
                $user_emex =  array(
                                'title' => '???????????????????????????? ?????????????? ?? emex',
                                'id' => $user[0]['id'],
                                'emex_id' => $user[0]['emex_id'],
                                'emex_pass' => $user[0]['emex_pass'],
                                'js_save' => 'userEmexSave(this)'
                            );
            }
            else 
            {
                $user_emex = null;
            }
            
            $this->template->user_emex = $user_emex;
	}  
        
        public function action_save_user()
	{
            $msg = '';
            try
            {
                if($post = $this->request->post())
                {
                    $user = Model::factory('Admin_User');                  
                    $data = array();   
                    if ($post['action'] == 'add')
                    {
                        $data['fio'] = $post['fio'];
                        $data['username'] = $post['username'];
                        $data['password'] = Auth::instance()->hash($post['password']);
                        $data['office_id'] = ((int)$post['office_id'] ? (int)$post['office_id'] : null);
                        $data['is_active'] = ($post['is_active'] == "true" ? 1 : 0);

                        $res = $user->save_user($data);
                        if(!$res) 
                        {
                            throw new Exception('????????????: ???????????????? ???? ????????????????!');
                        }
                        else
                        {
                            $res = $user->save_user_role(array('user_id' => $res[0], 'role_id' => 1));
                            if(!$res) 
                            {
                                throw new Exception('????????????: ???????? ?????????????????? ???? ??????????????????!');
                            }
                        }
                        $msg = '???????????? ?? ?????????????????? ??????????????????';
                    }
                    elseif ($post['action'] == 'edit')
                    {
                        $user_id = (int)$this->request->param('user_id');
                        if(!isset($user_id) || $user_id == 0)
                        {
                            throw new Exception('????????????: ?????????????????????? ?????????????????????????? ??????????????????!');
                        }
                        
                        $data['fio'] = $post['fio'];
                        $data['username'] = $post['username'];
                        if(isset($post['password']) && !empty($post['password']))
                        {
                            $data['password'] = Auth::instance()->hash($post['password']);
                        }
                        $data['office_id'] = ((int)$post['office_id'] ? (int)$post['office_id'] : null);
                        $data['is_active'] = ($post['is_active'] == "true" ? 1 : 0);
                        $res = $user->update_user($user_id, $data);
                        $msg = '???????????? ?? ?????????????????? ??????????????????';
                    }
                    elseif ($post['action'] == 'emex_edit')
                    {
                        $user_id = (int)$this->request->param('user_id');
                        if(!isset($user_id) || $user_id == 0)
                        {
                            throw new Exception('????????????: ?????????????????????? ?????????????????????????? ??????????????????!');
                        }
                        
                        $data['emex_id'] = $post['emex_id'];
                        $data['emex_pass'] = $post['emex_pass'];
                        if(empty($post['emex_pass']) || empty($post['emex_id']))
                        {
                            throw new Exception('????????????: ?????????? ?? ???????????? ???? ?????????? ???????? ??????????????!');
                        }
                        $res = $user->update_user($user_id, $data);
                        $msg = '???????????? ?? ?????????????????? ??????????????????';
                    }
                    else 
                    {
                        throw new Exception('????????????: ???????????????????????? ????????????????!');
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
        
        public function action_del_user()
	{
            $msg = '';
            try
            {
                $user = Model::factory('Admin_User');  
                $user_id = (int)$this->request->param('user_id');
                if(!isset($user_id) || $user_id == 0)
                {
                    throw new Exception('????????????: ?????????????????????? ?????????????????????????? ??????????????????!');
                }
                $res = $user->del_user($user_id);
                if(!$res)
                {
                    throw new Exception('????????????: ???????????????? ???? ???????????? ???? ????????!');
                }
                $msg = '???????????????? ????????????';
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
	}
}
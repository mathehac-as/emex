<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Base {
       
    public function action_login()
    {
        $errors = null;
        if($post = $this->request->post())
        {
            $is_active = ORM::factory('User', array('username' => $post['username'], 'is_active' => 1));
            if($is_active->loaded())
            {
                $user = Auth::instance()->login($post['username'], $post['password']);
                if($user)
                {
                    $this->redirect('/');
                }
                else 
                {
                    $errors = array('Ошибка авторизации: Неверный логин/пароль!');
                }
            }
            else 
            {
                $errors = array('Ошибка авторизации: Пользователь не активен!');
            }
        }
        $this->template->title_page = 'Вход';
        $content_center = View::factory('VLogin')->set('errors', $errors);
        $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');
        $this->template->center_blocks = array($content_center);
        $this->template->left_blocks = array($content_left);
    }   
    
    public function action_logout()
    {
        $this->auto_render = false;
        Auth::instance()->logout();
        $this->redirect('auth/login');
    }  
    
    public function action_registration()
    {
        $errors = null;
        if ($post = $this->request->post())
        {
            try 
            {
                $user = ORM::factory('user')->create_user($_POST, array('username','email','password'));
                if (isset($_POST['role']))
                {
                    $user->add('roles',ORM::factory('role',array('name'=>$_POST['role'])));
                }
     
                // Отправляем письмо пользователю с логином и паролем
                //mail($post['email'],'Регистрация на сайте SiteName','Вы были зерегестрированы на сайте SiteName, ваш логин: '.$post['username'].' Ваш пароль: '.$post['password']);
               
                $this->redirect("auth/login");
            } 
            catch (ORM_Validtion_Exception $e) 
            {
                $errors = $e->errors('models');
                // echo Debug::vars($errors);
            }
        }
     
        $this->template->title_page = 'Добавление пользователя';
        $content_center = View::factory('VRegistration')->set('errors', $errors);
        $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');
        $this->template->center_blocks = array($content_center);
        $this->template->left_blocks = array($content_left);
    }
}
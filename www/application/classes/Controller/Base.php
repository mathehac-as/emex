<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template {
    
        public $template = 'VBase';
        
	public function before()
	{
            parent::before();
           
            if(Request::current()->controller() != 'Auth')
            {
                if(!Auth::instance()->logged_in())
                {
                    $this->redirect('auth/login');
                }
                else
                {
                    if(Auth::instance()->logged_in('admin') && Request::current()->directory() != 'Admin')
                    {
                        $this->redirect('admin/index');
                    }
                    elseif(Auth::instance()->logged_in('login') && Request::current()->directory() != 'Manager')
                    {
                        $this->redirect('manager/index');
                    }                    
                }
            }
            
            $scripts = '';
            $title_site = 'Авторизация';
            if(Auth::instance()->logged_in('admin'))
            {
                $title_site = 'Админ-панель';
                $scripts  = 'js/afunction.js';
            }
            elseif (Auth::instance()->logged_in('login')) 
            {
                $title_site = 'Менеджер-панель';
                $scripts  = 'js/function.js';
            }

            $this->template->title_site = 'Учет автозапчастей: '.$title_site;
            $this->template->description  = '';
            $this->template->title_page  = null;
            
            $this->template->scripts  = array(
                                                'js/jquery-2.2.min.js', 
                                                'js/shifty.jquery.js', 
                                                'js/bootstrap.min.js', 
                                                'js/bootstrap-datepicker.min.js',
                                                'js/bootstrap-datepicker.ru.min.js',
                                                $scripts
                                            );
            $this->template->styles  = array(
                                            'css/index.css', 
                                            'css/bootstrap.min.css', 
                                            'css/bootstrap-theme.min.css', 
                                            'css/bootstrap-datepicker.min.css'
                                        );
            
            $this->template->left_blocks  = null;
            $this->template->center_blocks  = null;
            $this->template->right_blocks  = null;
	}
}
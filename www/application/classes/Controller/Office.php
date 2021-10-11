<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Office extends Controller_Template {
            
        public $template = 'VPanelCenterOfficeUser';
            
        public function action_get_user()
	{
            $user =  array(
                        'id' => 1,
                        'name' => 'Иван',
                        'login' => 'ivan',
                        'password' => '1111',
                        'is_active' => 1,
                        'office' => 1,
                        'img_save' => '/img/save.png',
                        'js_save' => 'officesSave(this)',
                        'img_del' => '/img/del.png',
                        'js_del' => 'officesDel(this)'
                    );
            $offices = array(
                        array('id' => 1, 'name' => 'Темрюк'),
                        array('id' => 2, 'name' => 'Славянск-на-Кубани'),
                        array('id' => 3, 'name' => 'Анапа')
                    );
            $this->template->user = $user;
            $this->template->offices = $offices;
	}
}
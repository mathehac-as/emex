<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Officelist extends Controller_Template {
            
        public $template = 'admin/VPanelCenterOffice';
            
        public function action_get_office_list()
	{
            $office = Model::factory('Admin_Office');
            $office_lists = $office->get_offices();
            $total = $office->get_total();
            $offices_act = array('img' => '/img/add.png', 'js' => 'officeAdd()'); 
            $offices =  array(
                                'data' => $office_lists,
                                'act' => array(
                                                'img_link' => '/img/link.png',
                                                'js_link' => 'officeLink(this)',
                                                'img_unlink' => '/img/unlink.png',
                                                'js_unlink' => 'officeUnlink(this)',
                                                'img_edit' => '/img/edit.png',
                                                'js_edit' => 'officeEdit(this)',
                                                'img_del' => '/img/del.png',
                                                'js_del' => 'officeDel(this)'
                                              )
                             );
            $this->template->offices = $offices;
            $this->template->offices_act = $offices_act;
            $this->template->total = $total;
	}
}
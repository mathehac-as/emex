<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Typeoperlist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftTypeoper';
            
        public function action_get_typeoper_list()
	{
            $typeoper_id = (int)$this->request->param('typeoper_id');
            $typeoper = Model::factory('Admin_Typeoper');
            $typeoper_lists = $typeoper->get_typeopers($typeoper_id);
            $typeoper_lists_act = array(
                                    'img_add' => '/img/add.png',
                                    'js_add' => 'typeoperAdd(this)',
                                    'img_edit' => '/img/edit.png',
                                    'js_edit' => 'typeoperEdit(this)',
                                    'img_del' => '/img/del.png',
                                    'js_del' => 'typeoperDel(this)'
                                );
            
            $this->template->typeopers = $typeoper_lists;
            $this->template->typeoper_lists_act = $typeoper_lists_act;
	}
}
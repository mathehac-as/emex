<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Discountlist extends Controller_Template {
            
        public $template = 'manager/VPanelLeftDiscount';
            
        public function action_get_discount_list()
	{
            $user_name = Auth::instance()->get_user();
            $discount = Model::factory('Manager_Discount');
            $discount_lists = $discount->get_discounts();
            $discount_lists_act = array(
                                    'add' => array(
                                                'title' => 'Добавление карты',
                                                'img' => '/img/add.png', 
                                                'js' => 'discountAdd()'),
                                    'refresh' => array(
                                                'title' => 'Обновление списка карт',
                                                'img' => '/img/refresh.png', 
                                                'js' => 'discountRefresh()')
                                );
            $this->template->discount_lists = $discount_lists;
            $this->template->discount_lists_act = $discount_lists_act;
	}
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Discountchangehistory extends Controller_Template {
            
        public $template = 'manager/VPanelCenterDiscountChangeHistory';
            
        public function action_get_discountchangehistorys()
	{
            $discount = Model::factory('Manager_Discount');
            $discount_id = (int)$this->request->param('discount_id');
            $discountchangehistorys = null;
            if($discount_id != 0)
            {
                $discountchangehistorys = $discount->get_discount_change_history(array('discount_id' => $discount_id));
            }
            $this->template->discountchangehistorys = $discountchangehistorys;
        }
}
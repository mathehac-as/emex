<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Journallist extends Controller_Template {
            
        public $template = 'admin/VPanelLeftJournal';
            
        public function action_get_journal_list()
	{
            $office_id = (int)$this->request->param('office_id');
            $order = Model::factory('Admin_Order');
            $order_date_lists = $order->get_order_dates($office_id);
            rsort($order_date_lists);
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            
            $this->template->order_date_lists = $order_date_lists;
            $this->template->offices = $offices;
            $this->template->office_id = $office_id;
	}
}
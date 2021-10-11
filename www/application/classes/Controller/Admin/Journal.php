<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Journal extends Controller_Template {
            
        public $template = 'admin/VPanelCenterJournal';
            
        public function action_get_journals()
	{
            $office_id = (int)$this->request->param('office_id');
            $office_historys = null;
            $order = Model::factory('Admin_Order');
            if($post = $this->request->post())
            {
                if(isset($post['date']))
                {
                    $office_historys = $order->get_order_office_historys($office_id, $post['date']);
                    //$order_lists = $order->get_order_historys($office_id, $post['date']);
                    $journal_lists = $order->get_order_journal_historys($office_id, $post['date']);
                    $order_lists = array();
                    $journal_history_lists = array();
                    foreach ($journal_lists as $value)
                    {
                        $order_lists[$value['order_id']] = array_slice($value, 0, 6);
                        $journal_history_lists[$value['order_id']][] = array_slice($value, 6, 6);
                    }
                }
            }
            $journals =  array(
                                'office_historys' => $office_historys,
                                'order_historys' => array(
                                    'order_lists' => $order_lists,
                                    'journal_lists' => $journal_history_lists
                                )
                             );
            $this->template->journals = $journals;
	}
}
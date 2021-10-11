<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Journal extends Controller_Template {
            
        public $template = 'manager/VPanelCenterJournal';
            
        public function action_get_journals()
	{
            $office_id = (int)$this->request->param('office_id');
            $office_historys = null;
            $order = Model::factory('Manager_Order');
            if($post = $this->request->post())
            {
                if(isset($post['date']))
                {
                    $office_historys = $order->get_order_office_historys($office_id, $post['date']);
                    //$order_lists = $order->get_order_historys($office_id, $post['date']);
                    
                    $sum['journal_coins_add'] = $order->get_order_journal_historys_sum($office_id, $post['date'], "'coins_add'");
                    $sum['journal_coins_add_card'] = $order->get_order_journal_historys_sum($office_id, $post['date'], "'coins_add_card'");
                    $sum['journal_introduction_cash'] = $order->get_order_journal_historys_sum($office_id, $post['date'], "'introduction_cash'");
                    $sum['journal_return_cash'] = $order->get_order_journal_historys_sum($office_id, $post['date'], "'return_cash'");
                    $sum['journal_pay_card'] = $order->get_order_journal_historys_sum($office_id, $post['date'], "'pay_card'");
                    $sum['journal_transfer_card'] = $order->get_order_journal_historys_sum($office_id, $post['date'], "'transfer_card'");
                    
                    $journal_lists = $order->get_order_journal_historys($office_id, $post['date']);
                    $order_lists = array();
                    $journal_history_lists = array();
                    foreach ($journal_lists as $value) 
                    {
                        $order_lists[$value['order_id']] = array_slice($value, 0, 6);
                        $journal_history_lists[$value['order_id']][] = array_slice($value, 6, 7);
                    }
                }
            }
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            $journals =  array(
                                'office_historys' => $office_historys,
                                'order_historys' => array(
                                    'order_lists' => $order_lists,
                                    'journal_lists' => $journal_history_lists
                                )
                             );
            $this->template->journals = $journals;
            $this->template->sum = $sum;
            $this->template->accesses = $accesses;
	}
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Discounthistory extends Controller_Template {
            
        public $template = 'manager/VPanelCenterDiscountHistory';
            
        public function action_get_discounthistorys()
	{
            $discount = Model::factory('Manager_Discount');
            $discount_id = (int)$this->request->param('discount_id');
            $discounthistorys_act = array(
                                        'clear' => array(
                                                'title' => 'Отчистка истории по карте',
                                                'img' => '/img/clear.png', 
                                                'js' => 'discounthistorysClear()'
                                            )
                                    );
            $discounthistorys = null;
            $user_name = Auth::instance()->get_user();
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_name->id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            if($discount_id != 0)
            {
                $discounthistorys = $discount->get_discounthistorys(array('discount_id' => $discount_id));
                $discounthistorys_sum = $discount->get_discounthistorys_sum(array('discount_id' => $discount_id));
            }
            $this->template->discounthistorys_act = $discounthistorys_act;
            $this->template->discounthistorys = $discounthistorys;
            $this->template->discounthistorys_sum = $discounthistorys_sum;
            $this->template->accesses = $accesses;
        }
        
        public function action_clear_discounthistory()
	{
            $msg = '';
            try
            {
                $discount = Model::factory('Manager_Discount');
                $discount_id = (int)$this->request->param('discount_id');
                if($discount_id != 0)
                {
                    if($discount->сlear_discounthistory($discount_id))
                    {
                        $msg = 'История по карте удалена';
                    }
                    else 
                    {
                        throw new Exception('Ошибка: История по карте не удалена!');
                    }
                }
                else 
                {
                    throw new Exception('Ошибка: Неопределен идентификатор карты!');
                }
            }
            catch (Exception $e)
            {
                $errors = $e->getMessage();
                $this->template->errors = $errors;
            }
            $this->template->msg = $msg;
        }
}
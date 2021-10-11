<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manager_Index extends Controller_Base {

	public function action_index()
	{
            $user_name = Auth::instance()->get_user();
            $manager = Model::factory('Manager_User');
            $office = $manager->get_office_for_manager(array('user_id' => $user_name->id));
            $client = Model::factory('Manager_Client');
            $client_lists = null;
            $office_id = 0;
            if(isset($office[0]['id']) && (int)$office[0]['id'] != 0)
            {
                $office_id = (int)$office[0]['id'];
                $group_id = $client->get_group_id($office_id);
                $group_id = (int)$group_id[0]['id'];
                $client_lists = $client->get_clients($office_id, $group_id);
            }
            $access = $this->get_access($user_name->id);
            $orders = View::factory('manager/VPanelCenterClientOrder')->set('order_lists', null);
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(0))->set('access', $access)->set('user_perm', 'user');
            $lists = View::factory('manager/VPanelLeftClient')->set('client_lists', $client_lists)->
                    set('client_lists_act', 
                            array(
                                'add' => array(
                                            'title' => 'Добавление клиента',
                                            'img' => '/img/add.png', 
                                            'js' => 'clientAdd()'),
                                'refresh' => array(
                                            'title' => 'Оновление списка клиентов',
                                            'img' => '/img/refresh.png', 
                                            'js' => 'clientRefresh()')
                        ))->
                    set('office_id', $office_id);
            $client_one = View::factory('manager/VPanelCenterClientClient');
            $panels = View::factory('manager/VPanelCenterClient')->set('orders',$orders)->set('client', $client_one);
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Менеджер панель')->
                    set('user_type','Менеджер')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Клиенты';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_journal()
	{
            $user_name = Auth::instance()->get_user();
            $manager = Model::factory('Manager_User');
            $offices = $manager->get_office_for_manager(array('user_id' => $user_name->id));
            $order = Model::factory('Manager_Order');
            $office_id = 0;
            $order_date_lists = null;
            if(isset($offices[0]['id']))
            {
                $office_id = $offices[0]['id'];
                $order_date_lists = $order->get_order_dates($office_id);
                rsort($order_date_lists);
            }
            $access = $this->get_access($user_name->id);
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(1))->set('access', $access)->set('user_perm', 'user');
            $lists = View::factory('manager/VPanelLeftJournal')->set('order_date_lists', $order_date_lists)->
                        set('office_id', $office_id);
            $panels = View::factory('manager/VPanelCenterJournal')->set('journals', null);           
            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Менеджер панель')->
                    set('user_type','Менеджер')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Журнал';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_office()
	{
            $user_name = Auth::instance()->get_user();
            $manager = Model::factory('Manager_User');
            $offices = $manager->get_office_for_manager(array('user_id' => $user_name->id));
            $office_one = null;
            if(isset($offices[0]['id']))
            {
                $office = Model::factory('Manager_Office');
                $office_one = $office->get_balance($offices[0]['id']);
            }
            $access = $this->get_access($user_name->id);
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(2))->set('access', $access)->set('user_perm', 'user');
            $lists = View::factory('manager/VPanelLeftOffice')->set('offices', $office_one);
            $panels = View::factory('manager/VPanelCenterOffice')->set('offices', $office_one);
            
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Менеджер панель')->
                    set('user_type','Менеджер')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Офис';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
        }
        
        public function action_expenses()
	{
            $user_name = Auth::instance()->get_user();
            $typeexpenses = Model::factory('Manager_Typeexpenses');
            $typeexpensess = $typeexpenses->get_typeexpensess();
            $access = $this->get_access($user_name->id);
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(3))->set('access', $access)->set('user_perm', 'user');
            $lists = View::factory('manager/VPanelLeftExpenses')->set('typeexpensess', $typeexpensess)->
                        set('typeexpenses_lists_act', array('img' => '/img/add.png', 'js' => 'typeExpensesAdd()'));
            $type_expenses_one = View::factory('manager/VPanelCenterTypeExpenses');
            $expenses = View::factory('manager/VPanelCenterExpensesExpenses');
            $panels = View::factory('manager/VPanelCenterExpenses')->set('expenses', $expenses)->
                    set('type_expenses', $type_expenses_one);

            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Менеджер панель')->set('user_type','Менеджер')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Расходы';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_discounts()
	{
            $user_name = Auth::instance()->get_user();
            $discount = Model::factory('Manager_Discount');
            $discount_lists = $discount->get_discounts();
            $access = $this->get_access($user_name->id);
            $historys = View::factory('manager/VPanelCenterDiscountHistory');
            $changehistorys = View::factory('manager/VPanelCenterDiscountHistory');
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(4))->set('access', $access)->set('user_perm', 'user');
            $lists = View::factory('manager/VPanelLeftDiscount')->set('discount_lists', $discount_lists)->
                     set('discount_lists_act', 
                            array(
                                'add' => array(
                                            'title' => 'Добавление карты',
                                            'img' => '/img/add.png', 
                                            'js' => 'discountAdd()'),
                                'refresh' => array(
                                            'title' => 'Обновление списка карт',
                                            'img' => '/img/refresh.png', 
                                            'js' => 'discountRefresh()')
                        ));
            $discount_one = View::factory('manager/VPanelCenterDiscountDiscount');
            $panels = View::factory('manager/VPanelCenterDiscount')->set('historys', $historys)->
                        set('changehistorys', $changehistorys)->set('discount', $discount_one);
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Менеджер панель')->
                    set('user_type','Менеджер')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Дисконт';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_history_sms()
	{
            $user_name = Auth::instance()->get_user();
            $manager = Model::factory('Manager_User');
            $office = $manager->get_office_for_manager(array('user_id' => $user_name->id));
            $office_id = 0;
            $client_lists = null;
            if(isset($office[0]['id']) && (int)$office[0]['id'] != 0)
            {
                $office_id = (int)$office[0]['id'];
                $client = Model::factory('Manager_Client');
                $group_id = $client->get_group_id($office_id);
                $group_id = (int)$group_id[0]['id'];
                $history_sms = Model::factory('Manager_Historysms');
                $client_lists = $history_sms->get_clients($office_id, $group_id);
            }
            $access = $this->get_access($user_name->id);
            $history = View::factory('manager/VPanelCenterHistorySMSHistory')->set('historys', null);
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(5))->set('access', $access)->set('user_perm', 'user');
            $lists = View::factory('manager/VPanelLeftHistorySMS')->set('client_lists', $client_lists)->
                        set('client_lists_act', 
                            array(
                                'send' => array(
                                            'title' => 'Послать СМС',
                                            'img' => '/img/send.png', 
                                            'js' => 'getSendSmsOne()'),
                                'delivery' => array(
                                            'title' => 'Рассылка СМС',
                                            'img' => '/img/delivery.png', 
                                            'js' => 'getDeliverySMS()')
                        ));
            $panels = View::factory('manager/VPanelCenterHistorySMS')->set('history', $history);
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Менеджер панель')->
                    set('user_type','Менеджер')->set('user_name', $user_name->fio);
            
            $this->template->title_page = (isset($menu[5]['name']) ? $menu[5]['name'] : '');
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        private function get_menus($active)
	{
            $menus = array(
                            array('active' => 0, 'act' => 'index', 'name' => 'Клиенты/заказы'),
                            array('active' => 0, 'act' => 'journal', 'name' => 'Журнал'),
                            array('active' => 0, 'act' => 'office', 'name' => 'Офис'),
                            array('active' => 0, 'act' => 'expenses', 'name' => 'Расходы'),
                            array('active' => 0, 'act' => 'discounts', 'name' => 'Дисконт'),
                            array('active' => 0, 'act' => 'history_sms', 'name' => 'История СМС')
                        );
            $menus[$active]['active'] = 1;
            return $menus;
        }
        
        public function action_logout()
	{
            $this->redirect('auth/logout');
        }
        
        private function get_access($user_id)
	{
            $access = Model::factory('Manager_Access');
            $accesses_user = $access->get_accesses($user_id);
            $accesses = array();
            foreach ($accesses_user as $value) 
            {
                $accesses[] = $value['access_id'];
            }
            return $accesses;
        }
}
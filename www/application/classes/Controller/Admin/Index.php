<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Base {

	public function action_index()
	{
            $user = Model::factory('Admin_User');
            $user_lists = $user->get_users_for_login();          
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $total = $office->get_total();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(0))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftOffice')->set('user_lists', $user_lists)->
                        set('user_lists_act', array('img' => '/img/add.png', 'js' => 'userAdd()'));
            $user = View::factory('admin/VPanelCenterOfficeUser');
            $panels = View::factory('admin/VPanelCenterOffice')->
                        set('offices', 
                                array(
                                    'data' => $offices,
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
                                    )
                            )->
                        set('offices_act', array('img' => '/img/add.png', 'js' => 'officeAdd()'))->
                        set('total', $total)->set('user', $user);
            
            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Админ панель')->
                    set('user_type','Администратор')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Менеджеры/офисы';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_client()
	{
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $client = Model::factory('Admin_Client');
            $office_id = 0;
            $client_lists = null;
            if(isset($offices[0]['id']))
            {
                $client_lists = $client->get_clients($offices[0]['id']);
                $office_id = $offices[0]['id'];
            }

            $orders = View::factory('admin/VPanelCenterClientOrder')->set('order_lists', null);
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(1))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftClient')->set('client_lists', $client_lists)->
                    set('offices', $offices)->set('office_id', $office_id);
            $client_one = View::factory('admin/VPanelCenterClientClient');
            $panels = View::factory('admin/VPanelCenterClient')->set('orders',$orders)->set('client', $client_one);
            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Админ панель')->
                    set('user_type','Администратор')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Клиенты';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_journal()
	{
            $office = Model::factory('Admin_Office');
            $offices = $office->get_offices();
            $order = Model::factory('Admin_Order');
            $office_id = 0;
            $order_date_list = null;
            if(isset($offices[0]['id']))
            {
                $office_id = $offices[0]['id'];
                $order_date_lists = $order->get_order_dates($office_id);
                rsort($order_date_lists);
            }

            $menus = View::factory('VMenu')->set('menus', $this->get_menus(2))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftJournal')->set('order_date_lists', $order_date_lists)->
                        set('offices', $offices)->set('office_id', $office_id);
            $panels = View::factory('admin/VPanelCenterJournal')->set('journals', null);           
            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->set('lists', $lists)->
                    set('panels', $panels)->set('panel_name', 'Админ панель')->
                    set('user_type','Администратор')->set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Журнал';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_typeoper()
	{        
            $typeoper = Model::factory('Admin_Typeoper');
            $typeopers = $typeoper->get_typeopers();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(3))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftTypeoper')->
                        set('typeopers', $typeopers)->
                        set('typeoper_lists_act', 
                                array(
                                    'img_add' => '/img/add.png',
                                    'js_add' => 'typeoperAdd(this)',
                                    'img_edit' => '/img/edit.png',
                                    'js_edit' => 'typeoperEdit(this)',
                                    'img_del' => '/img/del.png',
                                    'js_del' => 'typeoperDel(this)'
                                )
                            );
            $panels = View::factory('admin/VPanelCenterTypeoper');
            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Админ панель')->set('user_type','Администратор')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Типовые операции';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_salary()
	{
            $user = Model::factory('Admin_User');
            $users = $user->get_users();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(4))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftSalary')->set('users', $users)->
                        set('user_lists_act', array('img' => '/img/add.png', 'js' => 'userSalaryAdd()'));
            $user_one = View::factory('admin/VPanelCenterSalaryUser');
            $salarys = View::factory('admin/VPanelCenterSalarySalary');
            $panels = View::factory('admin/VPanelCenterSalary')->set('salarys', $salarys)->set('user', $user_one);

            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Админ панель')->set('user_type','Администратор')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Зарплата';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_expenses()
	{
            $typeexpenses = Model::factory('Admin_Typeexpenses');
            $typeexpensess = $typeexpenses->get_typeexpensess();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(5))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftExpenses')->set('typeexpensess', $typeexpensess)->
                        set('typeexpenses_lists_act', array('img' => '/img/add.png', 'js' => 'typeExpensesAdd()'));
            $type_expenses_one = View::factory('admin/VPanelCenterTypeExpenses');
            $expenses = View::factory('admin/VPanelCenterExpensesExpenses');
            $panels = View::factory('admin/VPanelCenterExpenses')->set('expenses', $expenses)->
                    set('type_expenses', $type_expenses_one);

            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Админ панель')->set('user_type','Администратор')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Расходы';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_statistic()
	{
            $statistic = Model::factory('Admin_Statistic');
            $statistics = $statistic->get_statistics();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(6))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftStatistic')->
                        set('statistics', $statistics)->
                        set('statistic_lists_act', 
                                array(
                                    'img_add' => '/img/add.png',
                                    'js_add' => 'statisticAdd(this)',
                                    'img_edit' => '/img/edit.png',
                                    'js_edit' => 'statisticEdit(this)',
                                    'img_del' => '/img/del.png',
                                    'js_del' => 'statisticDel(this)'
                                )
                            );
            $panels = View::factory('admin/VPanelCenterStatistic');
            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Админ панель')->set('user_type','Администратор')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Статистика';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_access()
	{
            $user = Model::factory('Admin_User');
            $user_lists = $user->get_users_for_login();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(7))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftAccess')->set('user_lists', $user_lists);
            $accesses = View::factory('admin/VPanelCenterAccessAccess');
            $panels = View::factory('admin/VPanelCenterAccess')->set('accesses', $accesses);

            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Админ панель')->set('user_type','Администратор')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Права доступа';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        public function action_settings()
	{
            $settings = Model::factory('Admin_Settings');
            $settings_lists = $settings->get_settings();
            $menus = View::factory('VMenu')->set('menus', $this->get_menus(8))->set('user_perm', 'admin');
            $lists = View::factory('admin/VPanelLeftSettings')->set('settings_lists', $settings_lists);
            $settingses = View::factory('admin/VPanelCenterSettingsSettings');
            $panels = View::factory('admin/VPanelCenterSettings')->set('settingses', $settingses);

            $user_name = Auth::instance()->get_user();
            $content_left = View::factory('VSidebarLeft')->set('img', '/img/sidebar_left.png');           
            $content_center = View::factory('VPanel')->set('menus', $menus)->
                    set('lists', $lists)->set('panels', $panels)->
                    set('panel_name', 'Админ панель')->set('user_type','Администратор')->
                    set('user_name', $user_name->fio);
            
            $this->template->title_page = 'Настройки';
            $this->template->left_blocks = array($content_left);
            $this->template->center_blocks = array($content_center);
	}
        
        private function get_menus($active)
	{
            $menus = array(
                            array('active' => 0, 'act' => 'index', 'name' => 'Менеджеры/офисы'),
                            array('active' => 0, 'act' => 'client', 'name' => 'Клиенты'),
                            array('active' => 0, 'act' => 'journal', 'name' => 'Журнал'),
                            array('active' => 0, 'act' => 'typeoper', 'name' => 'Типовые операции'),
                            array('active' => 0, 'act' => 'salary', 'name' => 'Зарплата'),
                            array('active' => 0, 'act' => 'expenses', 'name' => 'Расходы'),
                            array('active' => 0, 'act' => 'statistic', 'name' => 'Статистика'),
                            array('active' => 0, 'act' => 'access', 'name' => 'Права доступа'),
                            array('active' => 0, 'act' => 'settings', 'name' => 'Настройки')
                        );
            $menus[$active]['active'] = 1;
            return $menus;
        }
        
        public function action_logout()
	{
            $this->redirect('auth/logout');
        }
}
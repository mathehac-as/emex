<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Statistic extends Controller_Template {
            
        public $template = 'admin/VPanelCenterStatisticStatistic';
       
        public function action_get_statistic()
	{
            $statistic_model = Model::factory('Admin_Statistic');
            $statistic_id = (int)$this->request->param('statistic_id');
            $statistic_str_code = $statistic_model->get_statistic(array('statistic_id' => $statistic_id));
            if(isset($statistic_str_code[0]['str_code']))
            {
                switch ($statistic_str_code[0]['str_code']) 
                {
                    case 'debts':
                        $statistic = $statistic_model->get_debts();
                        $clients = $statistic_model->get_debt_clients();
                        if(isset($statistic[0]))
                        {
                            $statistic =  array(
                                                'sum' => array(
                                                        'fields' => array('Задолжность', 'Количество должников'),
                                                        'values' => array($statistic[0]['sum_balance'], $statistic[0]['cnt_client'])
                                                    ),
                                                'info_act' => array(
                                                        'src' => '/img/plus.png',
                                                        'title' => 'Раскрыть список',
                                                        'onclick' => 'getOrderList(this)'
                                                    ),
                                                'info' => array(
                                                        'fields' => array('ID', 'ФИО', 'Телефон', 'Задолжность'),
                                                        'values' => $clients
                                                    ),
                                                'title' => $statistic_str_code[0]['name'],
                                                'str_code' => $statistic_str_code[0]['str_code'],
                                                'title_export' => 'Экспорт CSV',
                                                'img_export' => '/img/export.png',
                                                'js_export' => 'exportCSV(this)'
                                            );
                        }
                        else 
                        {
                            $statistic = null;
                        }
                        break;
                    case 'debts_for_manager':
                        $statistic = $statistic_model->get_debts();
                        $managers = $statistic_model->get_debt_managers();
                        if(isset($statistic[0]))
                        {
                            $statistic =  array(
                                                'sum' => array(
                                                        'fields' => array('Задолжность', 'Количество должников'),
                                                        'values' => array($statistic[0]['sum_balance'], $statistic[0]['cnt_client'])
                                                    ),
                                                'info_act' => array(
                                                        'src' => '/img/plus.png',
                                                        'title' => 'Раскрыть список',
                                                        'onclick' => 'getOrderList(this)'
                                                    ),
                                                'info' => array(
                                                        'fields' => array('ID', 'ФИО', 'Телефон', 'Задолжность'),
                                                        'values' => $managers
                                                    ),
                                                'title' => $statistic_str_code[0]['name'],
                                                'str_code' => $statistic_str_code[0]['str_code'],
                                                'title_export' => 'Экспорт CSV',
                                                'img_export' => '/img/export.png',
                                                'js_export' => 'exportCSV(this)'
                                            );
                        }
                        else 
                        {
                            $statistic = null;
                        }
                        break;
                    case 'reporting_for_period':
                        $statistic = $statistic_model->get_debts();
                        $values_offices = $statistic_model->get_debt_offices();
                        $values_office_incash = $statistic_model->get_debt_office_incash();
                        $values_office_outcash = $statistic_model->get_debt_office_outcash();
                        $values_journals_card = $statistic_model->get_debt_journals_card();
                        $values_journals_balans = $statistic_model->get_debt_journals_balans();

                        var_dump($values_offices[0]);
                        var_dump($values_office_incash[0]);
                        var_dump($values_office_outcash[0]);
                        var_dump($values_journals[0]);
                        exit;
                        if(isset($statistic[0]))
                        {
                            $statistic =  array(
                                                'sum' => array(
                                                        'fields' => array('Задолжность', 'Количество должников'),
                                                        'values' => array($statistic[0]['sum_balance'], $statistic[0]['cnt_client'])
                                                    ),
                                                'info_act' => array(
                                                        'src' => '/img/plus.png',
                                                        'title' => 'Раскрыть список',
                                                        'onclick' => 'getOrderList(this)'
                                                    ),
                                                'info' => array(
                                                        'fields' => array('ID','Офис','Общая сумма созданных заказов', 'В кассу', 'Из кассы', 'Оплачено картой', 'Пополнение баланса', 'Из кассы', 'Общая задолженность', 'Общая сумма скидок'),
                                                        'values' => $values
                                                    ),
                                                'title' => $statistic_str_code[0]['name'],
                                                'str_code' => $statistic_str_code[0]['str_code'],
                                                'title_export' => 'Экспорт CSV',
                                                'img_export' => '/img/export.png',
                                                'js_export' => 'exportCSV(this)'
                                            );
                        }
                        else 
                        {
                            $statistic = null;
                        }
                        break;
                    default:
                        $statistic = null;
                        break;
                }
            }
            else 
            {
                $statistic = null;
            }
            $this->template->statistic = $statistic;
	}
        
        public function action_get_order_list()
	{
            $statistic_model = Model::factory('Admin_Statistic');
            $id = (int)$this->request->param('id');
            $post = $this->request->post();
            $str_code = (isset($post['str_code']) ? $post['str_code'] : '');
            if(isset($str_code))
            {
                switch ($str_code) 
                {
                    case 'debts':
                        $client_id = (int)$this->request->param('id');
                        $order_list = $statistic_model->get_order_list(array('client_id' => $id));
                        if(isset($order_list[0]))
                        {
                            $order_list =  array(
                                                'info' => array(
                                                        'fields' => array('ID заказа', 'Дата добавления', 'Основание', 'Сумма заказа', 'Баланс по заказу', 'Менеджер'),
                                                        'values' => $order_list
                                                    )
                                            );
                        }
                        else 
                        {
                            $order_list = null;
                        }
                        break;
                    case 'debts_for_manager':
                        $order_list = $statistic_model->get_order_list_for_manager(array('manager_id' => $id));
                        if(isset($order_list[0]))
                        {
                            $order_list =  array(
                                                'info' => array(
                                                        'fields' => array('ID заказа', 'Дата добавления', 'Основание', 'Сумма заказа', 'Баланс по заказу', 'Клиент'),
                                                        'values' => $order_list
                                                    )
                                            );
                        }
                        else 
                        {
                            $order_list = null;
                        }
                        break;
                    default:
                        $order_list = null;
                        break;
                }
            }
            else 
            {
                $order_list = null;
            }
            $this->template->order_list = $order_list;
	}
}
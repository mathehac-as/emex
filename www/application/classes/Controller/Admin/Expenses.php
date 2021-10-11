<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Expenses extends Controller_Template {
            
    public $template = 'admin/VPanelCenterExpensesExpenses';

    public function action_get_expenses()
    {
        $expenses = Model::factory('Admin_Expenses');
        $typeexpenses_id = (int)$this->request->param('typeexpenses_id');
        $expensess = null;
        $sums = 0;
        $date = null;
        if($typeexpenses_id != 0)
        {
            $expenses_lists = $expenses->get_expenses(array('typeexpenses_id' => $typeexpenses_id));
            $date = array( 
                    1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
                    5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
                    9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
                );
            $expensess = array();
            $sums = array();
            foreach ($expenses_lists as $key => $value) 
            {
                $date_id = idate('m', strtotime($value['expenses_date']));
                $year_id = idate('Y', strtotime($value['expenses_date']));
                $expensess[$year_id][$date_id][] = $value;
                if(isset($sums[$year_id][$date_id]))
                {
                    $sums[$year_id][$date_id] += $value['sum'];
                }
                else 
                {
                    $sums[$year_id][$date_id] = $value['sum'];
                }
            }
        }
        $expenses_act = array('img' => '/img/payment.png', 'js' => 'expensesGive()'); 
        $this->template->expensess = $expensess;
        $this->template->expenses_act = $expenses_act;
        $this->template->date = $date;
        $this->template->sums = $sums;
    }

    public function action_expenses_add()
    {
        $office = Model::factory('Admin_Office');
        $offices = $office->get_offices();
        $expensess =  array(
                        'title' => 'Выдача зарплаты',
                        'id' => 0,
                        'offices' => $offices,
                        'sum' => '',
                        'comment' => '',
                        'js_save' => 'expensesGiveSave(this)'
                    );
        $this->template->expensess = $expensess;
        $this->template->act = 'add';
    }

    public function action_save_expenses()
    { 
        $msg = '';
        try
        {
            if($post = $this->request->post())
            {
                $user_name = Auth::instance()->get_user();
                $office_id =$post['office_id'];
                $sum = (int)$post['sum'];
                $office = Model::factory('Admin_Office'); 
                $balance = $office->get_balance($office_id);
                $balance = (isset($balance[0]['balance']) ? $balance[0]['balance'] : 0 );
                $data['balance'] = $balance-$sum;
                if($data['balance'] < 0)
                {
                    throw new Exception('Ошибка: Не достаточно сдредств в офисе!');
                }
                $res = $office->update_office($office_id, $data);
                
                $officehistory = Model::factory('Admin_Officehistory'); 
                $data = array();
                $data['sum'] = $sum;
                $data['comment'] = $post['comment'];
                $data['date_change'] = date('Y-m-d H:i:s');
                $data['office_id'] = $office_id;
                $data['type_history'] = 'outcash';
                $data['user_id'] = $user_name->id;
                $res = $officehistory->save_office_history($data);
                
                $expenses = Model::factory('Admin_Expenses'); 
                $data = array();
                $data['typeexpenses_id'] = $post['typeexpenses_id'];
                $data['sum'] = $sum;
                $data['office_id'] = $office_id;
                $data['expenses_date'] = date('Y-m-d H:i:s');
                $data['comment'] = $post['comment'];
                $data['user_id'] = $user_name->id;
                $res = $expenses->save_expenses($data);
                if(!$res) 
                {
                    throw new Exception('Ошибка: Данные о зарплате не добавлен!');
                }
                $msg = 'Данные о зарплате добавлены';
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
<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Statistic extends Kohana_Model
{
    public function get_statistics($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('statistics')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_statistic($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('statistics')->
                    where('id', '=', $arr_values['statistic_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debts($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array(DB::expr('SUM(o.balance)'), 'sum_balance'),
                            array(DB::expr('COUNT(distinct c.id)'), 'cnt_client')
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        where('o.balance','<','0')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_clients($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('c.id', 'id'),
                            array('c.fio', 'fio'),
                            array('c.phone', 'phone'),
                            array(DB::expr('SUM(o.balance)'), 'balance')
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        where('o.balance','<','0')->group_by('c.id')->
                        order_by(DB::expr('SUM(o.balance)'))->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_managers($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('u.id', 'id'),
                            array('u.fio', 'fio'),
                            array('u.phone', 'phone'),
                            array(DB::expr('SUM(o.balance)'), 'balance')
                        )->from(array('users', 'u'))->
                        join(array('roles_users', 'ru'))->on('ru.user_id', '=', 'u.id')->
                        join(array('roles', 'r'))->on('r.id', '=', 'ru.role_id')->
                        join(array('journals', 'j'))->on('j.user_id', '=', 'u.id')->
                        join(array('orders', 'o'))->on('o.id', '=', 'j.order_id')->
                        where('r.name','=','login')->and_where('o.balance','<','0')->and_where('j.journal_type_id','=','1')->
                        group_by('u.id')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_offices($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('of.id', 'id'),
                            array('of.name', 'name'),
                            array(DB::expr('SUM(o.sum)'), 'orders_sum')
                        )->from(array('offices', 'of'))->
                        join(array('clients', 'c'))->on('c.office_id', '=', 'of.id')->
                        join(array('orders', 'o'))->on('o.client_id', '=', 'c.id')->
                        where('o.order_type_id', '=', null)->
                        group_by('of.id')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_office_incash($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('of.id', 'id'),
                            array('of.name', 'name'),
                            array(DB::expr('SUM(oh.sum)'), 'office_incash_sum')
                        )->from(array('offices', 'of'))->
                        join(array('office_history', 'oh'),'Left')->on('oh.office_id', '=', 'of.id')->on('oh.type_history', '=', DB::expr("'incash'"))->
                        group_by('of.id')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_office_outcash($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('of.id', 'id'),
                            array('of.name', 'name'),
                            array(DB::expr('SUM(oh.sum)'), 'office_outcash_sum')
                        )->from(array('offices', 'of'))->
                        join(array('office_history', 'oh'),'Left')->on('oh.office_id', '=', 'of.id')->on('oh.type_history', '=', DB::expr("'outcash'"))->
                        group_by('of.id')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_journals_card($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('of.id', 'id'),
                            array('of.name', 'name'),
                            array(DB::expr('SUM(j.sum)'), 'journals_card_sum')
                        )->from(array('offices', 'of'))->
                        join(array('clients', 'c'))->on('c.office_id', '=', 'of.id')->
                        join(array('orders', 'o'))->on('o.client_id', '=', 'c.id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('journal_types', 'jt'))->on('jt.id', '=', 'j.journal_type_id')->
                        where('jt.code', '=', DB::expr("'pay_card'"))->
                        group_by('of.id')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
        public function get_debt_journals_balans($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('of.id', 'id'),
                            array('of.name', 'name'),
                            array(DB::expr('SUM(j.sum)'), 'journals_balans_sum')
                        )->from(array('offices', 'of'))->
                        join(array('clients', 'c'))->on('c.office_id', '=', 'of.id')->
                        join(array('orders', 'o'))->on('o.client_id', '=', 'c.id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('journal_types', 'jt'))->on('jt.id', '=', 'j.journal_type_id')->
                        where('jt.code', '=', DB::expr("'coins_add'"))->
                        group_by('of.id')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_list($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('o.id', 'id'),
                            array('o.date_create', 'date_create'),
                            array('o.comment', 'comment'),
                            array('o.sum', 'sum'),
                            array('o.balance', 'balance'),
                            array('u.fio', 'manager') 
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('users', 'u'),'LEFT')->on('u.id', '=', 'j.user_id')->
                        where('o.balance','<','0')->and_where('c.id', '=', $arr_values['client_id'])->
                        group_by('o.id')->order_by('o.date_create')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_list_for_manager($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('o.id', 'id'),
                            array('o.date_create', 'date_create'),
                            array('o.comment', 'comment'),
                            array('o.sum', 'sum'),
                            array('o.balance', 'balance'),
                            array('c.fio', 'fio')
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        where('o.balance','<','0')->and_where('j.user_id', '=', $arr_values['manager_id'])->
                        and_where('j.journal_type_id','=','1')->
                        group_by('o.id')->order_by('o.date_create')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_clients_export_csv($arr_values = array())
    { 
        try 
        {         
            return DB::select(
                            array('c.id', 'id'),
                            array('c.fio', 'fio'),
                            array('o.id', 'order_id'),
                            array('o.date_create', 'date_create'),
                            array('o.comment', 'comment'),
                            array('o.sum', 'sum'),
                            array('o.balance', 'balance'),
                            array('u.fio', 'manager') 
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('users', 'u'),'LEFT')->on('u.id', '=', 'j.user_id')->
                        where('o.balance','<','0')->group_by('o.id')->order_by('o.date_create')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_list_export_csv($arr_values = array())
    {
        try 
        {         
            return DB::select(
                            array('u.id', 'id'),
                            array('u.fio', 'fio'),
                            array('o.id', 'order_id'),
                            array('o.date_create', 'date_create'),
                            array('o.comment', 'comment'),
                            array('o.sum', 'sum'),
                            array('o.balance', 'balance'),
                            array('c.fio', 'client_fio')
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('users', 'u'))->on('u.id', '=', 'j.user_id')->
                        where('o.balance','<','0')->and_where('j.journal_type_id','=','1')->
                        group_by('o.id')->order_by('o.date_create')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

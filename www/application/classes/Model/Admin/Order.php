<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Order extends Kohana_Model
{
    public function get_orders($client_id)
    { 
        try 
        {
            return DB::select(
                            array('o.id', 'id'),
                            array('o.sum', 'sum'),
                            array('o.balance', 'balance'),
                            array('o.comment', 'comment'),
                            array('o.delivery', 'delivery'),
                            array('o.date_create', 'date_create'),
                            array('o.order_type_id', 'order_type_id')
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        where('c.id', '=', $client_id)->
                        group_by('o.id')->order_by('o.date_create','desc')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_journals($client_id)
    { 
        try 
        {
            return DB::select(
                            array('o.id', 'order_id'),
                            array('j.id', 'id'),
                            array('j.base', 'base'),
                            array('j.sum', 'sum'),
                            array('j.date_history', 'date_history'),
                            array('j.comment', 'comment'),
                            array('jt.color', 'color'),
                            array('u.fio', 'manager')                          
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('journal_types', 'jt'),'LEFT')->on('jt.id', '=', 'j.journal_type_id')->
                        join(array('users', 'u'),'LEFT')->on('u.id', '=', 'j.user_id')->
                        where('c.id', '=', $client_id)->
                        order_by('o.id')->order_by('j.date_history')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_dates($office_id)
    { 
        try 
        {
            $query = DB::select(array(DB::expr('date(od.date_create)'), 'date_sel'))->
                        from(array('offices', 'o'))->
                        join(array('clients', 'c'))->on('c.office_id', '=', 'o.id')->
                        join(array('orders', 'od'))->on('od.client_id', '=', 'c.id')->
                        where('o.id', '=', $office_id)->and_where('od.date_create', '!=', null)->
                        distinct('date_sel');
                    
            return DB::select(array(DB::expr('date(date_change)'), 'date_sel'))->
                        from('office_history')->
                        where('office_id', '=', $office_id)->and_where('date_change', '!=', null)->
                        distinct('date_sel')->union($query, false)->order_by('date_sel','desc')->execute()->as_array();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_office_historys($office_id, $date)
    { 
        try 
        {
            return DB::select(
                            array('o.id', 'id'),
                            array('o.type_history', 'type_history'),
                            array('o.sum', 'sum'),
                            array('o.date_change', 'date_change'),
                            array('o.comment', 'comment'),
                            array('u.fio', 'fio')
                        )->from(array('office_history','o'))->
                        join(array('users', 'u'),'LEFT')->on('u.id', '=', 'o.user_id')->
                        where('o.office_id', '=', $office_id)->
                        and_where(DB::expr('date(o.date_change)'), '=', $date)->
                        order_by('o.date_change','desc')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_historys($office_id, $date)
    { 
        try 
        {
            return DB::select(
                            array('o.id', 'id'),
                            array('o.sum', 'sum'),
                            array('o.balance', 'balance'),
                            array('o.comment', 'comment'),
                            array('o.date_create', 'date_create'),
                            array('c.fio', 'fio')
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        where('c.office_id', '=', $office_id)->
                        and_where(DB::expr('date(o.date_create)'), '=', $date)->
                        group_by('o.id')->order_by('o.date_create','desc')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order_journal_historys($office_id, $date)
    { 
        try 
        {
            return DB::select(
                            array('o.id', 'order_id'),
                            array('o.sum', 'order_sum'),
                            array('o.balance', 'order_balance'),
                            array('o.comment', 'order_comment'),
                            array('o.date_create', 'order_date_create'),
                            array('c.fio', 'fio'),
                            array('j.id', 'id'),
                            array('j.base', 'base'),
                            array('j.comment', 'comment'),
                            array('j.sum', 'sum'),
                            array('j.date_history', 'date_history'),
                            array('jt.color', 'color'),
                            array('u.fio', 'manager')                           
                        )->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('journal_types', 'jt'),'LEFT')->on('jt.id', '=', 'j.journal_type_id')->
                        join(array('users', 'u'),'LEFT')->on('u.id', '=', 'j.user_id')->
                        where('c.office_id', '=', $office_id)->
                        and_where(DB::expr('date(j.date_history)'), '=', $date)->
                        order_by('j.date_history','desc')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_order($order_id)
    { 
        try 
        {
            return DB::select()->from('orders')->where('id', '=', $order_id)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_client_for_order_id($order_id)
    { 
        try 
        {
            return DB::select()->from(array('orders','o'))->
                    join(array('clients','c'))->on('c.id', '=', 'o.client_id')->
                    where('o.id', '=', $order_id)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
}

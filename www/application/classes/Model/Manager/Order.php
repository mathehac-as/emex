<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_Order extends Kohana_Model
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
                            array('o.order_type_id', 'order_type_id'),
                            array('o.abcp_number', 'abcp_number'),
                            array(DB::expr('max(if(coalesce(j.journal_type_id, 0) = 6, 1, 0))'), 'journal_type')
                        )->distinct(TRUE)->from(array('orders', 'o'))->
                        join(array('clients', 'c'))->on('c.id', '=', 'o.client_id')->
                        join(array('journals', 'j'),'LEFT')->on('j.order_id', '=', 'o.id')->
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
                            array('j.sum', 'sum'),
                            array('j.comment', 'comment'),
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
        
    public function get_order_journal_historys_sum($office_id, $date, $type_history)
    { 
        try 
        {
            return DB::select(
                            array(DB::expr('SUM(j.sum)'), 'journals_sum')
                        )->from(array('offices', 'of'))->
                        join(array('clients', 'c'))->on('c.office_id', '=', 'of.id')->
                        join(array('orders', 'o'))->on('o.client_id', '=', 'c.id')->
                        join(array('journals', 'j'))->on('j.order_id', '=', 'o.id')->
                        join(array('journal_types', 'jt'))->on('jt.id', '=', 'j.journal_type_id')->
                        where('c.office_id', '=', $office_id)->
                        and_where('jt.code', '=', DB::expr($type_history))->
                        and_where(DB::expr('date(j.date_history)'), '=', $date)->
                        execute()->get('journals_sum');
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_order($order_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$order_id) return false;
            return DB::update('orders')->set($arr_values)->where('id', '=', $order_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_order($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('orders', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
     public function get_balance($order_id)
    { 
        try 
        {
            return DB::select(array('balance', 'balance'))->from('orders')->
                    where('id', '=', $order_id)->execute();
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
    
    public function get_client_for_order_abcp_id($order_abcp_id)
    { 
        try 
        {
            return DB::select()->from(array('orders','o'))->
                    join(array('clients','c'))->on('c.id', '=', 'o.client_id')->
                    where('o.abcp_number', '=', $order_abcp_id)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_address_office_for_user($user_id)
    { 
        try 
        {
            return DB::select(
                            array('o.name', 'name'), 
                            array('o.phone', 'phone')
                        )->from(array('offices','o'))->
                        join(array('users','u'))->on('u.office_id', '=', 'o.id')->
                        where('u.id', '=', $user_id)->execute();
        }
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_config($str_code)
    {
        try 
        {
            return DB::select()->from('config')->
                    where('str_code', '=', $str_code)->execute();
        }
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_Historysms extends Kohana_Model
{
    public function get_phones($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('journals')->where('journal_type_id', '=', '10')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_clients($office_id, $group_id)
    { 
        try 
        {
            return DB::select('c.*')->from(array('clients','c'))->distinct(true)->
                    join(array('office_belong_group', 'obg'), 'LEFT')->on('obg.office_id', '=', 'c.office_id')->
                    where('c.office_id', '=', $office_id)->or_where('obg.office_group_id', '=', $group_id)->
                    order_by('c.fio')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_historys($client_id)
    { 
        try 
        {
            return DB::select(
                        array('j.id', 'id'),
                        array('j.base', 'base'),
                        array('j.date_history', 'date_history'),
                        array('j.comment', 'comment'),
                        array('u.fio', 'fio'),
                        array('o.id', 'order_id')
                    )->from(array('journals','j'))->
                    join(array('orders','o'))->on('o.id', '=', 'j.order_id')->
                    join(array('users','u'))->on('u.id', '=', 'j.user_id')->
                    where('j.journal_type_id', '=', '10')->and_where('o.client_id', '=', $client_id)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_historys_zero()
    { 
        try 
        {
            return DB::select(
                        array('j.id', 'id'),
                        array('j.base', 'base'),
                        array('j.date_history', 'date_history'),
                        array('j.comment', 'comment'),
                        array('u.fio', 'fio')
                    )->from(array('journals','j'))->
                    join(array('users','u'))->on('u.id', '=', 'j.user_id')->
                    where('j.journal_type_id', '=', '10')->and_where(DB::expr('coalesce(j.order_id,0)'), '=', 0)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

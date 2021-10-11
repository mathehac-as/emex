<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_Client extends Kohana_Model
{
    public function get_group_id($office_id)
    { 
        try 
        {
            return DB::select(array('office_group_id','id'))->from('office_belong_group')->
                    where('office_id', '=', $office_id)->execute();
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
            return DB::select('c.*', array(DB::expr('SUM(o.balance)'), 'sum_debt'))->from(array('clients','c'))->distinct(true)->
                    join(array('office_belong_group', 'obg'), 'LEFT')->on('obg.office_id', '=', 'c.office_id')->
                    join(array('orders', 'o'), 'LEFT')->on('o.client_id', '=', 'c.id')->on('o.balance', '<', DB::expr('0'))->
                    where('c.office_id', '=', $office_id)->or_where('obg.office_group_id', '=', $group_id)->
                    group_by('c.id')->order_by('c.fio')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_client($client_id)
    { 
        try 
        {
            return DB::select()->from('clients')->where('id', '=', $client_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_debt_for_client($client_id)
    { 
        try 
        {         
            return DB::select(array(DB::expr('SUM(balance)'), 'sum_debt'))->from('orders')->
                    where('balance','<','0')->and_where('client_id', '=', $client_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_sum_order_for_client($client_id)
    { 
        try 
        {         
            return DB::select(array(DB::expr('SUM(sum)'), 'sum_order'))->from('orders')->
                    where('client_id', '=', $client_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_client_for_order($order_id)
    { 
        try 
        {
            return DB::select(
                            array('c.id', 'id'),
                            array('c.fio', 'fio'),
                            array('c.phone', 'phone'),
                            array('c.marka_avto', 'marka_avto'),
                            array('c.vin', 'vin'),
                            array('c.percent_discount', 'percent_discount')
                        )->from(array('clients', 'c'))->
                        join(array('orders', 'o'))->on('o.client_id', '=', 'c.id')->
                        where('o.id', '=', $order_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_client($client_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$client_id) return false;
            return DB::update('clients')->set($arr_values)->where('id', '=', $client_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_client($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('clients', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function exists_client($fio)
    { 
        try 
        {
            return DB::select()->from('clients')->where('fio', '=', $fio)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Client extends Kohana_Model
{
    public function get_clients($office_id, $arr_values = array())
    { 
        try 
        {
            return DB::select('c.*', array(DB::expr('SUM(o.balance)'), 'sum_debt'))->from(array('clients','c'))->
                    join(array('orders', 'o'), 'LEFT')->on('o.client_id', '=', 'c.id')->on('o.balance', '<', DB::expr('0'))->
                    where('c.office_id', '=', $office_id)->group_by('c.id')->order_by('c.fio')->execute();
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
    
}

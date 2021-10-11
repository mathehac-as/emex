<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_Office extends Kohana_Model
{
    public function get_offices($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('offices')->order_by('name')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_office($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('id', 'id'),
                            array('name', 'name'),
                            array('comment', 'comment')            
                        )->from('offices')->
                        where('id', '=', $arr_values['office_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_office($office_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$office_id) return false;
            return DB::update('offices')->set($arr_values)->where('id', '=', $office_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_balance($office_id)
    { 
        try 
        {
            if(!$office_id) return false;
            return DB::select()->from('offices')->where('id', '=', $office_id)->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Typeoper extends Kohana_Model
{
    public function get_typeopers($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('typeopers')->order_by('name')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_typeoper($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('id', 'id'),
                            array('name', 'name')           
                        )->from('typeopers')->
                        where('id', '=', $arr_values['typeoper_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_typeoper($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('typeopers', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_typeoper($typeoper_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$typeoper_id) return false;
            return DB::update('typeopers')->set($arr_values)->where('id', '=', $typeoper_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function del_typeoper($typeoper_id)
    { 
        try 
        {
            if(!$typeoper_id) return false;
            return DB::delete('typeopers')->where('id', '=', $typeoper_id)->execute();    
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB1'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

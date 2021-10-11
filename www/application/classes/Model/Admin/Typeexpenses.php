<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Typeexpenses extends Kohana_Model
{
    public function get_typeexpensess($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('typeexpensess')->order_by('name')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
      
    public function get_typeexpenses($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('typeexpensess')->where('id', '=', $arr_values['typeexpenses_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_typeexpenses($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('typeexpensess', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_typeexpenses($typeexpenses_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$typeexpenses_id) return false;
            return DB::update('typeexpensess')->set($arr_values)->
                    where('id', '=', $typeexpenses_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function del_typeexpenses($typeexpenses_id)
    { 
        try 
        {
            if(!$typeexpenses_id) return false;
            return DB::delete('typeexpensess')->where('id', '=', $typeexpenses_id)->execute();    
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB1'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

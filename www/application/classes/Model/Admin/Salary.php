<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Salary extends Kohana_Model
{
    public function get_salarys($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('salarys')->
                    where('user_id', '=', $arr_values['user_id'])->
                    order_by('salary_date','desc')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_salary($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('salarys', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

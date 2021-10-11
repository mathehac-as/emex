<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Expenses extends Kohana_Model
{
    public function get_expenses($arr_values = array())
    { 
        try
        {
            return DB::select(
                        array('e.id', 'id'),
                        array('e.sum', 'sum'),
                        array('e.comment', 'comment'),
                        array('e.expenses_date', 'expenses_date'),
                        array('u.fio', 'fio')
                    )->from(array('expensess','e'))->
                    join(array('users', 'u'),'LEFT')->on('u.id', '=', 'e.user_id')->
                    where('e.typeexpenses_id', '=', $arr_values['typeexpenses_id'])->
                    order_by('e.expenses_date','desc')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_expenses($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('expensess', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

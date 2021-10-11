<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Access extends Kohana_Model
{
    public function get_accesses($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('a.id', 'id'),
                            array('a.name', 'name'),
                            array(DB::expr('coalesce(u.id,0)'), 'user_check')
                        )->from(array('accesses', 'a'))->
                        join(array('accesses_users', 'au'), 'left')->on('au.access_id', '=', 'a.id')->
                            on('au.user_id', '=', DB::expr($arr_values['user_id']))->
                        join(array('users', 'u'), 'left')->on('u.id', '=', 'au.user_id')->
                            on('u.id', '=', DB::expr($arr_values['user_id']))->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_user($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('accesses_users', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }

    public function del_user($arr_values = array())
    { 
        try 
        {
            if(!isset($arr_values['user_id']) || !$arr_values['user_id'] 
               || !isset($arr_values['access_id']) || !$arr_values['access_id']) return false;
            return DB::delete('accesses_users')->where('user_id', '=', $arr_values['user_id'])->
                    and_where('access_id', '=', $arr_values['access_id'])->execute();    
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB1'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_User extends Kohana_Model
{
    public function get_office_for_manager($arr_values = array())
    { 
        try 
        {
            return DB::select(array('o.id', 'id'))->from(array('users', 'u'))->
                        join(array('offices', 'o'), 'LEFT')->on('o.id', '=', 'u.office_id')->
                        where('u.id', '=', $arr_values['user_id'])->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_account_emex_for_manager($user_id)
    { 
        try 
        {
            return DB::select()->from('users')->where('id', '=', $user_id)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

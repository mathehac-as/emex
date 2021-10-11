<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_Access extends Kohana_Model
{
    public function get_accesses($user_id)
    { 
        try 
        {
            return DB::select()->from('accesses_users')->where('user_id', '=', $user_id)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

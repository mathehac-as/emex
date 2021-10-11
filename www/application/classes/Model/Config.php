<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Config extends Kohana_Model
{
    public function get_config($str_code)
    { 
        try 
        {
            return DB::select()->from('config')->where('str_code', '=', $str_code)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

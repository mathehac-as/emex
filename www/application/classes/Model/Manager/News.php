<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_News extends Kohana_Model
{    
    public function get_news($type_news)
    { 
        try 
        {
            return DB::select()->from('news')->where('str_code', '=', $type_news)->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

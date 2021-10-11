<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Settings extends Kohana_Model
{
    public function get_settings($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('discounts_config')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_setting($setting_id)
    { 
        try 
        {
            return DB::select()->from('discounts_config')->where('dc_id', '=', $setting_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_setting($setting_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$setting_id) return false;
            return DB::update('discounts_config')->set($arr_values)->where('dc_id', '=', $setting_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

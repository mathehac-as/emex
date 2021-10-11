<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Office extends Kohana_Model
{
    public function get_offices($arr_values = array())
    { 
        try 
        {
            return DB::select(
                        array('o.id', 'id'),
                        array('o.name', 'name'),
                        array('o.phone', 'phone'),
                        array('o.balance', 'balance'),
                        array('o.comment', 'comment'),
                        array('og.id', 'group_id'),
                        array('og.name', 'group_name')
                    )->from(array('offices','o'))->
                    join(array('office_belong_group','obg'), 'LEFT')->on('obg.office_id', '=', 'o.id')->
                    join(array('office_group','og'), 'LEFT')->on('og.id', '=', 'obg.office_group_id')->
                    order_by('o.name')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_office($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('id', 'id'),
                            array('name', 'name'),
                            array('phone', 'phone'),
                            array('comment', 'comment')            
                        )->from('offices')->
                        where('id', '=', $arr_values['office_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_total($arr_values = array())
    { 
        try 
        {
            return DB::select(array(DB::expr('SUM(balance)'), 'sum'))->from('offices')->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_balance($office_id)
    { 
        try 
        {
            if(!$office_id) return false;
            return DB::select()->from('offices')->where('id', '=', $office_id)->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_office($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('offices', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_office_belong_group($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('office_belong_group', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function del_office_belong_group($office_id)
    { 
        try 
        {
            if(!$office_id) return false;
            return DB::delete('office_belong_group')->where('office_id', '=', $office_id)->execute();    
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB1'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_office($office_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$office_id) return false;
            return DB::update('offices')->set($arr_values)->where('id', '=', $office_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function del_office($office_id)
    { 
        try 
        {
            if(!$office_id) return false;
            return DB::delete('offices')->where('id', '=', $office_id)->execute();    
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB1'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_office_link($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('id', 'id'),
                            array('name', 'name'),
                            array('phone', 'phone')
                        )->from(array('offices','o'))->
                        join(array('office_belong_group', 'obg'))->on('obg.office_id', '=', 'o.id')->
                        where('o.id', '=', $arr_values['office_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_office_groups()
    { 
        try 
        {
            return DB::select()->from('office_group')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

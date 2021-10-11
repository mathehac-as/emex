<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Manager_Discount extends Kohana_Model
{
    public function get_discounts($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('discounts')->order_by('d_number')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount($discount_id)
    { 
        try 
        {
            return DB::select()->from('discounts')->where('d_id', '=', $discount_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount_for_order_id($order_id)
    { 
        try 
        {
            return DB::select()->from(array('discounts','d'))->
                    join(array('orders','o'))->on('o.discount_id', '=', 'd.d_id')->
                    where('o.id', '=', $order_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount_for_number($creditcard)
    { 
        try 
        {
            return DB::select()->from('discounts')->
                    where('d_number', '=', $creditcard)->
                    or_where('d_number_code', '=', $creditcard)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_discount($discount_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$discount_id) return false;
            return DB::update('discounts')->set($arr_values)->where('d_id', '=', $discount_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_discount($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('discounts', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function exists_discount($number)
    { 
        try 
        {
            return DB::select()->from('discounts')->where('d_number', '=', $number)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_discounts_history($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('discounts_history', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function сlear_discounthistory($discount_id)
    { 
        try 
        {
            if(!$discount_id) return false;
            return DB::delete('discounts_history')->where('dh_discount_id', '=', $discount_id)->execute();         
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
        
    public function get_discount_config($discount_code)
    { 
        try 
        {
            return DB::select()->from('discounts_config')->
                    where('dc_strcode', '=', $discount_code)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discounthistorys($discount_id)
    { 
        try 
        {
            return DB::select('dh.*', array('c.fio', 'client_fio'))->
                   from(array('discounts_history','dh'))->
                   join(array('orders','o'))->on('o.id', '=', 'dh.dh_order_id')->
                   join(array('clients','c'))->on('c.id', '=', 'o.client_id')->
                   where('dh.dh_discount_id', '=', $discount_id)->
                   order_by('dh.dh_date_create')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discounthistorys_sum($discount_id)
    { 
        try 
        {
            return DB::select(
                        array(DB::expr('SUM(dh_discount_sum)'), 'discount_sum'),
                        array(DB::expr('SUM(dh_order_sum)'), 'order_sum')
                    )->
                   from('discounts_history')->where('dh_discount_id', '=', $discount_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount_for_history($order_id)
    { 
        try 
        {
            return DB::select(
                        array('dh.dh_discount_sum','discount_sum'), 
                        array('d.d_number','discount_number'),
                        array('dh.dh_percent','discount_percent')
                    )->
                    from(array('discounts_history','dh'))->
                    join(array('discounts','d'))->on('d.d_id', '=', 'dh.dh_discount_id')->
                    join(array('orders','o'))->on('o.id', '=', 'dh.dh_order_id')->on('o.discount_id', '=', 'd.d_id')->
                    where('dh.dh_order_id', '=', $order_id)->
                    and_where('dh.dh_discounts_history_type_id', '=', '2')->
                    order_by('dh.dh_date_create','desc')->limit(1)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount_bonus_sum($order_id)
    { 
        try 
        {
            return DB::select(
                        array(DB::expr('SUM(dh_bonus)'), 'bonus_sum')
                    )->
                    from('discounts_history')->
                    where('dh_order_id', '=', $order_id)->
                    and_where('dh_discounts_history_type_id', '=', '3')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount_bonus_writeoff($order_id)
    { 
        try 
        {
            return DB::select(
                        array(DB::expr('SUM(dh_bonus)'), 'bonus_writeoff')
                    )->
                    from('discounts_history')->
                    where('dh_order_id', '=', $order_id)->
                    and_where('dh_discounts_history_type_id', '=', '4')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_discount_change_history($discount_id)
    { 
        try 
        {
            return DB::select('dl.*', array('u.fio','dl_user_name'))->
                    from(array('discounts_log','dl'))->
                    join(array('users','u'))->on('u.id', '=', 'dl.user_id')->
                    where('dl.dl_discount_id', '=', $discount_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_discount_change_history($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('discounts_log', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

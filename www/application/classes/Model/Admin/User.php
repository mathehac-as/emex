<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_User extends Kohana_Model
{
    public function get_users($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('users')->order_by('fio')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_users_for_login($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('u.id', 'id'),
                            array('u.fio', 'fio')
                        )->from(array('users', 'u'))->
                        join(array('roles_users', 'ru'))->on('ru.user_id', '=', 'u.id')->
                        join(array('roles', 'r'))->on('r.id', '=', 'ru.role_id')->
                        where('r.name', '=', 'login')->
                        order_by('u.fio')->execute();
        }
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_user($arr_values = array())
    { 
        try 
        {
            return DB::select(
                            array('u.id', 'id'),
                            array('u.fio', 'fio'),
                            array('u.username', 'login'),
                            array('u.is_active', 'is_active'),
                            array('u.position', 'position'),
                            array('u.phone', 'phone'),
                            array('u.passport', 'passport'),
                            array('u.date_birth', 'date_birth'),
                            array('u.number_card', 'number_card'),
                            array('u.email', 'email'),
                            array('u.emex_id', 'emex_id'),
                            array('u.emex_pass', 'emex_pass'),
                            array('u.comment', 'comment'),
                            array('u.office_id', 'office_id')             
                        )->from(array('users', 'u'))->
                        join(array('offices', 'o'), 'LEFT')->on('o.id', '=', 'u.office_id')->
                        where('u.id', '=', $arr_values['user_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_user_no_role($arr_values = array())
    { 
        try 
        {
            return DB::select()->from(array('users', 'u'))->
                        join(array('roles_users', 'ru'), 'LEFT')->on('ru.user_id', '=', 'u.id')->
                        where('u.id', '=', $arr_values['user_id'])->
                        and_where('ru.user_id', '=', null)->execute();
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
            return DB::insert('users', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function save_user_role($arr_values = array())
    { 
        try 
        {
            if(!$arr_values) return false;
            foreach($arr_values as $k=>$v)
            {
                $key[] = $k;
                $value[] = $v;
            }
            return DB::insert('roles_users', $key)->values($value)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function update_user($user_id, $arr_values = array())
    { 
        try 
        {
            if(!$arr_values || !$user_id) return false;
            return DB::update('users')->set($arr_values)->where('id', '=', $user_id)->execute();           
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function del_user($user_id)
    { 
        try 
        {
            if(!$user_id) return false;
            return DB::delete('users')->where('id', '=', $user_id)->execute();    
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB1'.$e->getMessage().$e->getCode(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
}

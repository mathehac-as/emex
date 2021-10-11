<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Index extends Kohana_Model
{
    public function get_menu($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('actions')->
                        join('action_types')->on('at_id', '=', 'a_type')->
                        where('at_code', '=', 'menu')->
                        order_by('a_order')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_tab($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('actions')->
                        join('action_types')->on('at_id', '=', 'a_type')->
                        where('at_code', '=', 'tab')->
                        and_where('a_parent', '=', $arr_values['menu_id'])->
                        order_by('a_order')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_toolbar($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('toolbars')->
                        join('toolbar_types')->on('tbt_id', '=', 'tb_type')->
                        where('tb_actions', '=', $arr_values['tab_id'])->
                        order_by('tb_order')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_menu_id($tab_id)
    { 
        try 
        {
            return DB::select()->from('actions')->
                        join('action_types')->on('at_id', '=', 'a_type')->
                        where('at_code', '=', 'tab')->
                        and_where('a_id', '=', $tab_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw    new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_table($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('tables')->
                    join('table_types')->on('tt_id', '=', 't_type')->
                    where('tt_code', '=', 'view')->
                    and_where('t_actions', '=', $arr_values['tab_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_fields($arr_values = array())
    { 
        try 
        {
            return DB::select()->from('fields')->
                    join('field_types')->on('ft_id', '=', 'f_type')->
                    where('f_table', '=', $arr_values['table_id'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_data($arr_values = array())
    { 
        try 
        {
            return DB::select()->from($arr_values['table_code'])->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function is_exists($arr_values = array())
    { 
        try 
        {
            return Database::instance('alternate')->
                    query(Database::SELECT, "SELECT count(1) cnt FROM `TABLES` "
                            . "where TABLE_SCHEMA = 'virtual-helper' and TABLE_NAME = '{$arr_values['table_name']}'");
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function get_accounting($filter = null)
    {
        try 
        {
            $query = DB::select(
                            array('number_product', 'number_product'), 
                            array('a_date', 'a_date'), 
                            array('s_name', 'a_scorekeeper'), 
                            array('a_cost', 'a_cost'), 
                            array('a_payment_date', 'a_payment_date')
                        )->from('accounting')->
                        join('staff', 'left')->on('s_id', '=', 'a_scorekeeper');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_delivery($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'), 
                    array('d_date', 'd_date'), 
                    array('d_where', 'd_where'), 
                    array('s_name', 'd_provider'), 
                    array('d_cost', 'd_cost'),
                    array('d_min_selling_price', 'd_min_selling_price'),
                    array('d_payment_date_supplier', 'd_payment_date_supplier')
                    )->from('delivery')->
                    join('staff', 'left')->on('s_id', '=', 'd_provider');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_storage($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'),
                    array('s_name', 's_storekeeper'),
                    array('s_cost', 's_cost'), 
                    array('s_date_pay_storekeeper', 's_date_pay_storekeeper'), 
                    array('s_number_storage', 's_number_storage'), 
                    array('s_number_places', 's_number_places'),
                    array('s_number_product', 's_number_product'),
                    array('s_temporary_places', 's_temporary_places'),
                    array('s_questions_manager', 's_questions_manager'),
                    array('s_questions_storekeeper', 's_questions_storekeeper')
                    )->from('storage')->
                    join('staff', 'left')->on('s_id', '=', 's_storekeeper');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_repair($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'),
                    array('r_type', 'r_type'),
                    array('r_description', 'r_description'), 
                    array('s_name', 'r_repairman'), 
                    array('r_date', 'r_date'), 
                    array('r_cost', 'r_cost'),
                    array('r_date_pay_repairman', 'r_date_pay_repairman')
                    )->from('repair')->
                    join('staff', 'left')->on('s_id', '=', 'r_repairman');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_cutting($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'),
                    array('c_type', 'c_type'),
                    array('c_reason_not_cutting', 'c_reason_not_cutting'), 
                    array('c_protector_initially', 'c_protector_initially'), 
                    array('c_protector_completely', 'c_protector_completely'), 
                    array('s_name', 'c_cutter'),
                    array('c_date_notice_cutter', 'c_date_notice_cutter'),
                    array('c_cost', 'c_cost'),
                    array('c_date_pay_cutter', 'c_date_pay_cutter')
                    )->from('cutting')->
                    join('staff', 'left')->on('s_id', '=', 'c_cutter');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_characteristics_tires($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'),
                    array('ct_initial_state', 'ct_initial_state'), 
                    array('ct_where_previously_used', 'ct_where_previously_used'), 
                    array('ct_brand_name', 'ct_brand_name'),
                    array('ct_model', 'ct_model'),
                    array('co_name', 'ct_producing_country'),
                    array('ct_year_release', 'ct_year_release'),
                    array('ct_profile_width', 'ct_profile_width'),
                    array('ct_profile_height', 'ct_profile_height'),
                    array('ct_rim_diameter', 'ct_rim_diameter'),
                    array('ct_design_type_cord', 'ct_design_type_cord'),
                    array('ct_load_index_and_speed', 'ct_load_index_and_speed'),
                    array('ct_seasonal', 'ct_seasonal'),
                    array('ct_remained_spikes', 'ct_remained_spikes'),
                    array('ct_chamber_tire', 'ct_chamber_tire'),
                    array('ct_only_spare_dokatka', 'ct_only_spare_dokatka'),
                    array('ct_name_tire', 'ct_name_tire'),
                    array('ct_sale_price_new', 'ct_sale_price_new'),
                    array('ct_sale_price_this', 'ct_sale_price_this')
                    )->from('characteristics_tires')->
                    join('country', 'left')->on('co_id', '=', 'ct_producing_country');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_characteristics_disk($filter = null)
    {
        try 
        {
            $query = DB::select()->from('characteristics_disk');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_advert($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'),
                    array('ad_date', 'ad_date'),
                    array('ad_text_bulletin_avito', 'ad_text_bulletin_avito'), 
                    array('s_name', 'ad_advertiser'), 
                    array('ad_cost', 'ad_cost'), 
                    array('ad_pay_date_advertiser', 'ad_pay_date_advertiser'),
                    array('ad_link_avito', 'ad_link_avito'),
                    array('ad_settlement_avito', 'ad_settlement_avito'),
                    array('ad_link_auto_ru', 'ad_link_auto_ru'),
                    array('ad_renewal_date_auto_ru', 'ad_renewal_date_auto_ru'),
                    array('ad_note', 'ad_note')
                    )->from('advert')->
                    join('staff', 'left')->on('s_id', '=', 'ad_advertiser');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_transaction_support($filter = null)
    {
        try 
        {
            $query = DB::select()->from('transaction_support');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_removal_goods($filter = null)
    {
        try 
        {
            $query = DB::select(
                    array('number_product', 'number_product'),
                    array('rg_date', 'rg_date'),
                    array('rg_reason_withdrawal', 'rg_reason_withdrawal'), 
                    array('s1.s_name', 'rg_releaser'), 
                    array('rg_cost_release', 'rg_cost_release'), 
                    array('rg_date_pay_release', 'rg_date_pay_release'),
                    array('s2.s_name', 'rg_manager'),
                    array('rg_cost_manager', 'rg_cost_manager'),
                    array('rg_date_pay_manager', 'rg_date_pay_manager')
                    )->from('removal_goods')->
                    join(array('staff', 's1'), 'left')->on('s1.s_id', '=', 'rg_releaser')->
                    join(array('staff', 's2'), 'left')->on('s2.s_id', '=', 'rg_manager');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_salary_sales($filter = null)
    {
        try 
        {
            $query = DB::select()->from('salary_sales');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_salary_actions($filter = null)
    {
        try 
        {
            $query = DB::select()->from('salary_actions');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_record($filter = null)
    {
        try 
        {
            $query = DB::select()->from('record');
            if(isset($filter) && count($filter) > 0)
            {
                $cnt = 0;
                foreach ($filter as $key => $value) 
                {
                    if($cnt > 0)
                    {
                        $query->and_where($key, '=', $value);
                    }
                    else
                    {
                        $query->where($key, '=', $value);
                    }
                    $cnt++;
                }
            }
            return $query->execute();
        } 
        catch (Exception $e)
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
        
    public function get_insert_id()
    { 
        try 
        {
            return mysql_insert_id();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    
    public function accounting($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('accounting', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('accounting')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('accounting')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function delivery($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('delivery', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('delivery')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('delivery')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function storage($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('storage', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('storage')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('storage')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function repair($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('repair', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('repair')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('repair')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function cutting($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('cutting', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('cutting')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('cutting')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }

    public function characteristics_tires($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('characteristics_tires', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('characteristics_tires')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('characteristics_tires')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function characteristics_disk($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('characteristics_disk', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('characteristics_disk')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('characteristics_disk')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function advert($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('advert', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('advert')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('advert')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function transaction_support($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('transaction_support', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('transaction_support')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('transaction_support')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function removal_goods($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('removal_goods', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('removal_goods')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('removal_goods')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function salary_sales($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('salary_sales', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('salary_sales')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('salary_sales')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    public function salary_actions($arr_values, $act, $id = null)
    { 
        try 
        {
            if($act == 'save')
            {
                if(!$arr_values) return false;
                foreach($arr_values as $k=>$v)
                {
                    $key[] = $k;
                    $value[] = $v;
                }
                return DB::insert('salary_actions', $key)->values($value)->execute();
            }
            elseif($act == 'update')
            {
                return DB::update('salary_actions')->set($arr_values)->where('number_product', '=', $id)->execute(); 
            }
            elseif($act == 'del')
            {
                if((int)$arr_values['id'] == 0) return false;
                return DB::delete('salary_actions')->where('number_product', '=', (int)$arr_values['id'])->execute(); 
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.$e->getMessage(), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }
    }
    
    function get_scorekeeper()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 1)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_provider()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 2)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_storekeeper()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 3)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_storages()
    {
        try 
        {
            return DB::select(
                    array('st_id', 'id'),
                    array('st_number', 'name')
                    )->from('storages')->where('st_status', '=', 1)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_repairman()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 8)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_cutter()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 4)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_country()
    {
        try 
        {
            return DB::select(
                    array('co_id', 'id'),
                    array('co_name', 'name')
                    )->from('country')->order_by('co_name')->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_advertiser()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 5)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_releaser()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 6)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    function get_manager()
    {
        try 
        {
            return DB::select(
                    array('s_id', 'id'),
                    array('s_name', 'name')
                    )->from('staff')->where('s_type', '=', 7)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }

    public function get_act_url($tab_id)
    {
        try 
        {
            return DB::select()->from('actions')->where('a_id', '=', $tab_id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_accounting_for_id($table, $id)
    {
        try 
        {
            return DB::select()->from($table)->where('number_product', '=', $id)->execute();
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }
    
    public function get_current_user($login)
    {
        try 
        {
            return DB::select('s_id')->from('staff')->where('s_login', '=', $login)->execute()->get('s_id');
        } 
        catch (Exception $e) 
        {
            throw new Exception('error DB'.($e->getMessage()), 102);
            Kohana::$log->add(Log::ERROR, $e->getCode().': '.$e->getMessage());
        }  
    }  
}

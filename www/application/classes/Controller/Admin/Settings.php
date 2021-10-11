<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Template {
            
    public $template = 'admin/VPanelCenterSettingsSettings';

    public function action_get_settings()
    {
        $settings = Model::factory('Admin_Settings');
        $settings_id = (int)$this->request->param('settings_id');
        $setting = $settings->get_setting(array('settings_id' => $settings_id));
        if(isset($setting[0]))
        {
            $setting =  array(
                        'id' => $setting[0]['dc_id'],
                        'sum' => $setting[0]['dc_sum'],
                        'percent' => $setting[0]['dc_percent'],
                        'comment' => $setting[0]['dc_comment'],
                        'title_save' => 'Редактирование настроек',
                        'img_save' => '/img/edit.png',
                        'js_save' => 'settingEdit(this)'
                    );
        }
        else 
        {
            $setting = null;
        }
        $this->template->setting = $setting;
    }

    public function action_setting_edit()
    {
        $settings = Model::factory('Admin_Settings');
        $setting_id = (int)$this->request->param('setting_id');
        $setting = $settings->get_setting(array('$setting_id' => $setting_id));  
        if(isset($setting[0]))
        {
            $setting =  array(
                        'title' => 'Редактирование настроек',
                        'id' => $setting[0]['dc_id'],
                        'sum' => $setting[0]['dc_sum'],
                        'percent' => $setting[0]['dc_percent'],
                        'comment' => $setting[0]['dc_comment'],
                        'js_save' => 'settingUpdate(this)'
                    );
        }
        else 
        {
            $setting = null;
        }
        $this->template->setting = $setting;
        $this->template->act = 'edit';
    }        

    public function action_save_setting()
    {
        $msg = '';
        $setting_one = null;
        try
        {
            if($post = $this->request->post())
            {
                $settings = Model::factory('Admin_Settings');                  
                $data = array();   
                if ($post['action'] == 'edit')
                {
                    $setting_id = (int)$this->request->param('setting_id');
                    if(!isset($setting_id) || $setting_id == 0)
                    {
                        throw new Exception('Ошибка: Неопределен идентификатор настройки!');
                    }

                    $data['dc_comment'] = $post['comment'];
                    $data['dc_percent'] = $post['percent'];
                    $data['dc_sum'] = $post['sum'];
                    $res = $settings->update_setting($setting_id, $data);
                    $setting = $settings->get_setting(array('setting_id' => $setting_id));     
                    if(isset($setting[0]))
                    {
                        $setting_one =  array(
                                    'id' => $setting[0]['dc_id'],
                                    'sum' => $setting[0]['dc_sum'],
                                    'percent' => $setting[0]['dc_percent'],
                                    'comment' => $setting[0]['dc_comment'],
                                    'title_save' => 'Редактирование настройки',
                                    'img_save' => '/img/edit.png',
                                    'js_save' => 'settingEdit(this)'
                                );
                    }
                    $msg = 'Данные о настройке обновлены';
                }
                else 
                {
                    throw new Exception('Ошибка: Неопределено действия!');
                }
            }
        }
        catch (Exception $e)
        {
            $errors = $e->getMessage();
            $this->template->errors = $errors;
        }
        $this->template->setting = $setting_one;
        $this->template->msg = $msg;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Action extends Controller {
       
        public function action_export_csv()
        { 
            $str_code = $this->request->param('str_code');
            $now = gmdate("D, d M Y H:i:s");
            $filename = $str_code.'.csv';
            $headers = array(
                    'Expires' => 'Tue, 03 Jul 2001 06:00:00 GMT',
                    'Cache-Control' => 'max-age=0, no-cache, must-revalidate, proxy-revalidate',
                    'Last-Modified' => $now.' GMT',
                    'Content-Type' => 'application/force-download',
                    'Content-Type' => 'application/octet-stream',
                    'Content-Type' => 'application/download',
                    'Content-Disposition' => 'attachment;filename='.$filename,
                    'Content-Transfer-Encoding' => 'binary'
            );
            
            try
            {
                $all_titles = array(
                        'debts' => array("ID клиента", "ФИО клиента", "ID заказа", "Дата добавления", "Основание", "Сумма заказа", "Баланс по заказу", "Менеджер"),
                        'debts_for_manager' => array("ID менеджера", "ФИО менеджера", "ID заказа", "Дата добавления", "Основание", "Сумма заказа", "Баланс по заказу", "Клиент")
                    );
                
                $statistic_model = Model::factory('Admin_Statistic');
                switch ($str_code) 
                {
                    case 'debts':
                        $statistic = $statistic_model->get_debt_clients_export_csv();
                        break;
                    case 'debts_for_manager':
                        $statistic = $statistic_model->get_order_list_export_csv();
                        break;
                    default:
                        $statistic = null;
                        break;
                }
                $stats = array();
                $titles = isset($all_titles[$str_code]) ? $all_titles[$str_code] : '';
                ob_start();
                $df = fopen("php://output", 'w');
                foreach ($titles as $key => $value)
                {
                  $titles[$key] = iconv("UTF-8", "CP1251//IGNORE", $value);
                }
                foreach ($statistic as $key => $value)
                {
                    foreach ($value as $k => $v)
                    {
                        $stats[$key][$k] = iconv("UTF-8", "CP1251//IGNORE", $v);
                    }
                }
                fputcsv($df, $titles, ';');
                foreach ($stats as $row) 
                {
                    fputcsv($df, $row, ';');
                }
                fclose($df);
                $resutl = ob_get_clean();
            }
            catch (Exception $e)
            {
                $resutl = $e->getMessage();
            }
            foreach ($headers as $key => $value) 
            {
                $this->response->headers($key, $value);
            }
            $this->response->body($resutl);
        }
}
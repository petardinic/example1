<?php

include_once 'models/ArticlesModel.php';

class ArticlesController
{
    public $model;
	
    public function __construct()  
    {  
        $this->model = new ArticlesModel();
    } 
    
    /**
     * Page Action -- 
     * @param array $config 
     * 
     * @return redirect to page
     * 
     */
    public function pageAction($config)
    {
        $support_format = array('xml', 'csv', 'json', 'all');
        
        if(isset($_GET['task']) && in_array($_GET['task'], $support_format))
        {
            if($_GET['task'] == $support_format[0])
            {
                $value_from_xml = simplexml_load_file($config['file_storage'] . '/xml_test.xml');
                $array_for_insert = array();
                
                $count = 0;
                
                foreach($value_from_xml as $value_from_xml_key => $value_from_xml_value)
                {
                    $array_for_insert[$count]['doi'] = $value_from_xml_value->doi;
                    $array_for_insert[$count]['title'] = $value_from_xml_value->title;
                    $array_for_insert[$count]['abstract'] = $value_from_xml_value->abstract;
                    $array_for_insert[$count]['publicationDate'] = $value_from_xml_value->publicationDate;
                    $count++;
                }
                
                $insert_data = $this->model->insertToArticle($array_for_insert);
                
                $this->showMessage($insert_data);  
                
            }
            else if($_GET['task'] == $support_format[1])
            {
                $csv_for_insert = array();
                
                $csv_file_value = file($config['file_storage'] . '/csv_test.csv', FILE_IGNORE_NEW_LINES);
                
                foreach ($csv_file_value as $csv_file_value_key => $csv_file_value_value)
                {
                    if($csv_file_value_key > 0)
                    {
                        $csv_for_insert[$csv_file_value_key] = str_getcsv($csv_file_value_value);
                    }
                    
                }

                $insert_data = $this->model->insertToArticle(false, $csv_for_insert);
                $this->showMessage($insert_data);

            }
            else if($_GET['task'] == $support_format[2])
            {
                $api_content = file_get_contents($config['apiurl']);
                $api_result  = json_decode($api_content, true);
                $array_for_insert = array();
                
                foreach($api_result as $api_result_key => $api_result_value)
                {
                    if(is_array($api_result_value))
                    {
                        foreach ($api_result_value as $api_result_value_key => $api_result_value_value)
                    {
                        $array_for_insert[$api_result_value_key]['doi'] = $api_result_value_value['doi'];
                        $array_for_insert[$api_result_value_key]['title'] = $api_result_value_value['title'];
                        $array_for_insert[$api_result_value_key]['abstract'] = $api_result_value_value['abstract'];
                        $array_for_insert[$api_result_value_key]['publicationDate'] =  date('y/m/d', $api_result_value_value['publication_year']);
                    }
                    }
                    
                }
              
                $insert_data = $this->model->insertToArticle($array_for_insert);
                $this->showMessage($insert_data);
            }
            else if($_GET['task'] == $support_format[3])
            {
                $show_all_data = $this->model->getAllArticle();
                
                include 'views/all.html.php';
            }
        }
       
        else
        {  
            include 'views/index.html.php';
        }
    }
    
    /**
     * Redirect to messages page
     * @param boolean $value 
     * @return page
     */
    public function showMessage($value)
    {
        if($value)
        {
            include 'views/success-page.php';
        }
        else
        {
            include 'views/error-page.php';
        }
    }
    
}
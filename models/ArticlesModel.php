<?php

include 'config/db-config.php';

class ArticlesModel
{
    public function getAllArticle() 
    {
        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();
        
        $stmt = $conn->prepare("SELECT * FROM articles"); 
        $stmt->execute();
         
        $result = $stmt->fetchAll (PDO::FETCH_ASSOC); 
        return $result;
       
    }
    
    public function insertToArticle($data = false, $csv = false)
    {
        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();
       
        if($csv)
        {
            foreach ($csv as $csv_value)
            {
                if(sizeof($csv_value) == 4)
                {
                    $sql = "INSERT INTO articles 
                                (doi, 
                                title, 
                                abstract,
                                pub_date)
                            VALUES 
                                 ('" . $csv_value[2] . "', 
                                '" . $csv_value[0] ."', 
                                '" . $csv_value[1] ."', 
                                '" . $csv_value[3] ."')";

                    $status = $conn->exec($sql);
                    return $status;
                }
            }
        }
        
        if($data)
        {
            foreach ($data as $data_value)
            {
                $sql = "INSERT INTO articles 
                            (doi, 
                            title, 
                            abstract,
                            pub_date)
                        VALUES 
                            ('" . $data_value['doi'] . "', 
                            '" . $data_value['title'] ."', 
                            '" . $data_value['abstract'] ."', 
                            '" . $data_value['publicationDate'] ."')";

                $status = $conn->exec($sql);
                return $status;
            }
        }  
    }
}

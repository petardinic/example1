<?php 

include_once ("controllers/ArticlesController.php");
include_once ('config/config.php');

$action = new ArticlesController();

$action->pageAction($config);



//include_once 'config.php';
//
//if(file_exists(__DIR__."/views/" . $config['task'] . ".html.php"))
//{
//    include_once "views/" . $config['task'] . ".html.php";
//}
//else 
//{
//    $config['error'] = "Requeste View page views/" . $config['task'] . ".html.php do not exists!";
//    
//    include_once "views/error.html.php";
//}
//




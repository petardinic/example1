<?php 

include_once ("controllers/ArticlesController.php");
include_once ('config/config.php');

$action = new ArticlesController();

$action->pageAction($config);

<?php
require_once "stimulsoft/helper.php";

// Please configure the security level as you required.
// By default is to allow any requests from any domains.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token");

$handler = new StiHandler();
$handler->registerErrorHandlers();

$handler->onBeginProcessData = function ($args) {
    
	if(isset($_GET["param"])&&$dataSource=="cois"){
	   $args->queryString="SELECT *  FROM cois INNER JOIN  coi_goods ON coi_goods.orderID = cois.orderID WHERE cois.orderID= ".$_GET["param"]." order by coi_goods.id ASC";
	}

	return StiResult::success();
};

$handler->process();
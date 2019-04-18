<?php 
require_once(dirname(__FILE__)."/../lib/Http_Helper.php");
require_once(dirname(__FILE__)."/StringStocker.php");

class ExcelParamGetter{

    function Get(){
        $stocker = new StringStocker();
        $url = $stocker->URL_TO_SPREAD_SHEET;
        $httpaction = new Http_Helper();
        $obj = $httpaction->Get($url);
       
        return $obj;
    }
}
?>
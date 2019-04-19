<?php
// ini_set("display_errors", On);
// error_reporting(E_ALL & ~E_NOTICE);
require_once(dirname(__FILE__) . "/App/LotController.php");
header("Content-Type: application/json; charset=UTF-8");
header("X-Content-Type-Options: nosniff");

$json_string = file_get_contents('php://input');

// DialogFlowからパラメータを取得
$json = json_decode($json_string, true);
$GhomeParam = $json["queryResult"]["parameters"];
// $GhomeParam = array("JOBS" => "ヒーラー", "EQUIP" => "手");

// ロット権のある人を判定
$fulfillmentText = "";
try {
    $controller = new LotController();
    $fulfillmentText = $controller->LotSearch(["job" => $GhomeParam["JOBS"], "equip" => $GhomeParam["EQUIP"]]);
} catch (\Throwable $th) {
    $fulfillmentText = $th->getMessage();
}

$contents = [
                "fulfillmentText" => $fulfillmentText
                , "source" => "EchoService"
            ];

$res = json_encode($contents, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
echo $res;

?>
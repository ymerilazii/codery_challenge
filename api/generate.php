<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../database/db.php');
include_once('../database/dataCRUD.php');

$db = new Database();
$connection = $db->connect();

$genData = new dataCRUD($connection);

$data = json_decode(file_get_contents("php://input"));

$genData->firstname = $data->firstname;
$genData->lastname = $data->lastname;
$genData->email = $data->email;
$genData->phone = $data->phone;
$genData->martialstatus = $data->martialstatus;

$result = $genData->createDataAPI();
if ($result) {
    echo json_encode(array('id' => $result));
} else {
    echo json_encode(array('message' => 'This Name already exists!'));
}
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../database/db.php');
include_once('../database/dataCRUD.php');

$db = new Database();
$connection = $db->connect();

$getData = new dataCRUD($connection);
$getData->id = isset($_GET['id']) ? $_GET['id'] : die();
$getData->getInfoId();
if ($getData->firstname != null) {
    $emp_arr = array(
        "id" => $getData->id,
        "firstname" => $getData->firstname,
        "lastname" => $getData->lastname,
        "email" => $getData->email,
        "phone" => $getData->phone,
        "martialstatus" => $getData->martialstatus
    );
    http_response_code(200);
    print_r(json_encode($emp_arr));
} else {
    http_response_code(404);
    echo json_encode("User not found!");
}
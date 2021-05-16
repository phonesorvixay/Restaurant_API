<?php

error_reporting(E_ALL ^ E_NOTICE);
include_once 'common.inc.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,token,m,database_name,Authorization");

function PrintJSON($data, $message, $status)
{

    $f = '{"data":"%s","message":"%s","status":"%s"}';
    if ($data) {
        if (sizeof($data) > 0) {
            printf($f, json_encode($data), $message, $status);
        } else {
            printf($f, json_encode([$data]), $message, $status);
        }

    } else {
        printf($f, "[]", $message, $status);
    }
}
function Initialization()
{
    $token = isset(getallheaders()['token']) ? getallheaders()['token'] : die(json_encode(array("status" => "There is no authorization")));

    if ((isset($token) and checkToken($token))) {
        $tokenuid = -1;
        if (isset($token)) {
            $tokenuid = checkToken($token);
        }
        if ($tokenuid > -1) {
            $user_id = $tokenuid;
            $_SESSION["uid"] = $user_id;
            $_SESSION['pass'] = authorizeToken($token);
        } else {
            echo json_encode(array('status' => 0, 'message' => 'you have no Authorize'));
            die();
        }

    } else {

        echo json_encode(array('status' => 0, 'message' => 'No Authorize'));
        die();
    }
}

function GetMethod()
{
    return isset(getallheaders()['m']) ? getallheaders()['m'] : die(json_encode(array("status" => "wrong method")));
}
function getDatabaseName()
{
    $database_name = isset(getallheaders()['database_name']) ? getallheaders()['database_name'] : die(json_encode(array("status" => "you don't have database name")));
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";

    $conn = new mysqli($dbhost, $dbuser, $dbpass);

    $db = mysqli_fetch_all(mysqli_query($conn, "SHOW DATABASES"), MYSQLI_ASSOC);
    $conn->close();

    $dbname = [];

    for ($i = 0; $i < count($db); $i++) {
        $dbname[] = $db[$i]["Database"];
    }

    if (in_array($database_name, $dbname)) {
        $_SESSION['dbname'] = $database_name;
    } else {
        PrintJSON("", "database name {$database_name} is not available!", 0);
        die();
    }
}
function base64_to_jpeg($base64_string, $output_file)
{
    $ifp = fopen($output_file, "wb");
    fwrite($ifp, base64_decode($base64_string));
    fclose($ifp);
    return ($output_file);
}
define("MY_PATH", "../image/");

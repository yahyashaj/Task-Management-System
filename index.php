<?php
require 'vendor/autoload.php';

require_once("etc/config.php");

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$json = (array) json_decode(file_get_contents("php://input"), true);

$parts = explode("/", $_SERVER["REQUEST_URI"]);
$requestName = $parts[3];

if ($requestName != "tasks" && $requestName != "users") {
    http_response_code(404);
    exit;
}
$database = new Database();
$TaskGateway = new Tasks($database);
$usersGateway = new Users($database);
$userId = $json['userId'];
$token = $json['token'];
$id = $parts[4] ?? 0;

if ($id != 'login') {
    if (!empty($userId)) { // check send userId with request
        $userInfo = $usersGateway->getUserById($userId)[0];
        if (!empty($userInfo)) { // check user exist
            if (!empty($token)) {
                try {
                    $decode = JWT::decode($token, new key(JWT_SEC_KEY, 'HS256'));
                    if (($userInfo['email'] != $decode->userEmail && $userInfo['password'] != $decode->password) || empty($decode)) {
                        echo json_encode(["error_msg" => "invalid token ", "success" => 0, "logout" => 1]);
                        exit;
                    }
                } catch (Exception $e) {
                    // Token is invalid
                    echo json_encode(['error' => 'Invalid token: ' . $e->getMessage(), "success" => 0, "logout" => 1]);
                    exit;
                }
            } else {
                echo json_encode(["error_msg" => " please send token ", "success" => 0, "logout" => 1]);
                exit;
            }
        } else {
            echo json_encode(["error_msg" => "user does not exist", "success" => 0, "logout" => 1]);
            exit;
        }
    } else {
        echo json_encode(["error_msg" => " please send userId ", "success" => 0, "logout" => 1]);
        exit;
    }
}

if (empty($userInfo['is_Admin']) && $requestName == "users" &&  $id != 'login') {
    echo json_encode(["error_msg" => "you don't have  permission", "success" => 0, "logout" => 1]);
    exit;
}


switch ($requestName) {
    case "tasks":
        $taskControllerobj = new TaskController($TaskGateway);
        $taskControllerobj->processRequest($_SERVER["REQUEST_METHOD"], $id);

        break;
    case "users":
        $userControllerobj = new UserController($usersGateway);
        $userControllerobj->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;
}
if (empty($data)) {
    $data = array();
}
header("Content-type: application/json");
echo json_encode($data);
exit();

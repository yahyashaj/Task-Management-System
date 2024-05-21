<?php


use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class UserController
{
    public function __construct(private Users $userGateway)
    {
    }
    public function processRequest(string $method, ?string $login): void
    {
        if ($login) {

            $this->loginUser();
        } else {

            $this->processCollectionRequest($method);
        }
    }
    public function processCollectionRequest(string $method): void
    {
        $json = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case "GET":
                $dataUsers = $this->userGateway->getAll($json);
                $data['data'] = $dataUsers;
                $data['success'] = 1;
                echo json_encode($data);
                exit;
                break;
            case "POST":
                $this->getValidationErrors($json, true);
                $json['password'] = md5($json['password'] . PASS_KEY);
                $this->userGateway->create($json);
                $data['data'] = '';
                $data['success'] = 1;
                echo json_encode($data);
                exit;
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    public function loginUser(): void
    {
        $json = json_decode(file_get_contents('php://input'), true);
        $userInfo = $this->userGateway->getUserByEmail($json['userEmail'])[0];
        if (!empty($userInfo)) {
            if ($userInfo['password'] == md5($json['password'] . PASS_KEY)) {
                $payload = array(
                    'isd' => 'localhost',
                    'aud' => 'localhost',
                    'userEmail' => $json['userEmail'],
                    'password' => $userInfo['password'],
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + (24 * 60 * 60)
                );
                $userToken = JWT::encode($payload, JWT_SEC_KEY, 'HS256');
                $dataRes['userName'] = $userInfo['username'];
                $dataRes['userEmail'] = $userInfo['email'];
                $dataRes['userId'] = $userInfo['id'];
                $dataRes['token'] = $userToken;
                $data['data'] = $dataRes;
                $data['success'] = 1;
                echo json_encode($data);
                exit;
            } else {
                echo json_encode(["error_msg" => "Password incorrect", "success" => 0]);
                exit;
            }
        } else {
            echo json_encode(["error_msg" => "user email does not exist", "success" => 0]);
            exit;
        }
    }

    private function getValidationErrors(array $dataOfTask): array
    {
        $userExist =  $this->userGateway->getUserByEmail($dataOfTask['userEmail']);
        $errors = [];
        if (!empty($userExist)) {
            $errors[] = "user email exist already";
        } elseif (!is_string($dataOfTask['userName']) || empty($dataOfTask['userName'])) {
            $errors[] = "user name must be a string and not empty";
        } elseif (!filter_var($dataOfTask['userEmail'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "user email name must be a valid ";
        } elseif (!is_bool($dataOfTask['isAdmin'])) {
            $errors[] = "isAdmin must be a bool";
        }

        if (!empty($errors)) {
            $data['error_msg'] = $errors[0];
            $data['success'] = 0;
            echo json_encode($data);
            exit;
        }

        return $errors;
    }
}

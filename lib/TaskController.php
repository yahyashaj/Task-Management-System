<?php
class TaskController
{
    public function __construct(private Tasks $taskGateway)
    {
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {

            $this->processResourceRequest($method, $id);
        } else {

            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $json = (array) json_decode(file_get_contents("php://input"), true);

        $task = $this->taskGateway->get($id);

        if (!$task) {
            echo json_encode(["error_msg" => "task not found", "success" => 0]);
            exit;
            return;
        }

        switch ($method) {
            case "GET":
                $data['data'] = $task;
                $data['success'] = 1;
                echo json_encode($data);
                exit;
                break;

            case "PUT":
                $this->getValidationErrors($json, false);
                $this->taskGateway->update($id, $json);
                $data['data'] = '';
                $data['success'] = 0;
                echo json_encode($data);
                exit;
                break;

            case "DELETE":
                $rows =  $this->taskGateway->delete($id);
                $data['data'] = '';
                $data['success'] = 0;
                echo json_encode($data);
                exit;
                break;
            case "POST":
                if (empty($json['userIdAssigned'])) {
                    echo json_encode(["error_msg" => "please select user to assign", "success" => 1]);
                    exit;
                }
                $this->taskGateway->assignTaskToUser($id, $json['userIdAssigned']);
                $data['data'] = '';
                $data['success'] = 0;
                echo json_encode($data);
                exit;
                break;
            default:
                http_response_code(405);
                header("Allow: GET, PUT, DELETE, POST");
        }
    }
    private function processCollectionRequest(string $method): void
    {
        $json = json_decode(file_get_contents('php://input'), true);
        switch ($method) {
            case "GET":
                $this->handleFilterParams($json);
                $dataTasks = $this->taskGateway->getAllWithFilter($json);
                $data['data'] = $dataTasks;
                $data['success'] = 1;
                echo json_encode($data);
                exit;
                break;

            case "POST":
                $this->getValidationErrors($json, true);
                $this->taskGateway->create($json);
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

    function handleFilterParams(array &$arrayOfSearch)
    {
        $errors = [];
        if (!is_string($arrayOfSearch['status'])) {
            $errors[] = "status must be a string";
        } elseif (!is_string($arrayOfSearch['userAssignedName'])) {
            $errors[] = "user name must be a string";
        } elseif ($arrayOfSearch['dueDateFrom'] > $arrayOfSearch['dueDateTo'] && !empty($arrayOfSearch['dueDateTo'])) {
            $errors[] = "Please select a valid date period";
        }
        if (!empty($errors)) {
            $data['error_msg'] = $errors[0];
            $data['success'] = 0;
            echo json_encode($data);
            exit;
        }
    }

    private function getValidationErrors(array $dataOfTask, bool $newTask): array
    {
        $errors = [];
        if (!is_string($dataOfTask['title']) || empty($dataOfTask['title'])) { // check title not empty and valid  
            $errors[] = "title must be a string and not empty";
        } elseif (!is_string($dataOfTask['description']) || empty($dataOfTask['description'])) { // check description not empty and valid
            $errors[] = "description name must be a string and not empty";
        } elseif ((!is_string($dataOfTask['status']) && $newTask == true) || ((!is_string($dataOfTask['status']) || empty(($dataOfTask['status']))) && $newTask == false)) { // check status valid and the default is Pending
            $errors[] = "status must be a string and not empty";
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

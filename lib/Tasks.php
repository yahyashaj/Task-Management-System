<?php
class Tasks
{

    private  $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database;
    }


    public function create(array $list)
    {

        $sql = "INSERT INTO tasks (title, description, due_date , status)
        VALUES ('" . $list['title'] . "','" . $list['description'] . "','" . $list['dueDate'] . "','" . $list['status'] . "')";

        $this->conn->executeNonQuery($sql);
    }

    public function update(int $id, array $list)
    {
        $sql = "UPDATE tasks  SET title = '" . $list['title'] . "', description = '" . $list['description'] . "', due_date = '" . $list['dueDate'] . "',status = '"
            . $list['status'] . "' WHERE id = " . $id;

        $this->conn->executeNonQuery($sql);
    }
    public function assignTaskToUser(int $id, int $userIdAssigned)
    {
        $sql = "UPDATE tasks  SET user_id = " . $userIdAssigned .  " WHERE id = " . $id;

        $this->conn->executeNonQuery($sql);
    }

    public function delete(int $id)
    {
        $sql = "delete from  tasks   WHERE id = " . $id;
        $this->conn->executeNonQuery($sql);
    }


    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM tasks
                WHERE id = " . $id;

        $data = $this->conn->executeQuery($sql);

        return $data;
    }
    public function getAllWithFilter(array $list): array | false
    {

        $sql = "SELECT a.* ,b.username as userAssignedName FROM tasks a  ";
        $sql .= (!empty($list['userAssignedName']) ? " inner join users b " : " left join users b ") . "on b.id=a.user_id";
        $sql .= " where a.id!= 0 ";
        $sql .= (!empty($list['dueDateTo']) ? " AND a.due_date <= '" . $list['dueDateTo'] . "'" : "") . (!empty($list['dueDateFrom']) ? " AND a.due_date >= '" . $list['dueDateFrom'] . "'" : "");
        $sql .= (!empty($list['status']) ? " AND a.status = '" . $list['status'] . "'" : "");
        $sql .= (!empty($list['userAssignedName']) ? " AND b.username like '%" . $list['userAssignedName'] . "%' " : "");
        
        $data = $this->conn->executeQuery($sql);

        return $data;
    }
}

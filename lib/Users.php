<?php

//admin = 2 => Orders Admin
//admin = 3 => Shipping Admin
class Users
{

    private  $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database;
    }

    public function create(array $list)
    {

        $sql = "INSERT INTO users (username, email , is_Admin,password )
        VALUES ('" . $list['userName'] . "','" . $list['userEmail'] . "'," . $list['isAdmin'] . ",'" . $list['password'] .  "')";

        $this->conn->executeNonQuery($sql);
    }

    public function getUserByEmail(string $email): array | false
    {
        $sql = "SELECT *
                FROM users where email = '" . $email . "'";

        $data = $this->conn->executeQuery($sql);

        return $data;
    }
    public function getUserById(int $userId): array | false
    {
        $sql = "SELECT *
                FROM users where id = " . $userId . "";

        $data = $this->conn->executeQuery($sql);

        return $data;
    }

    public function getAll(): array | false
    {
        $sql = "SELECT *
                FROM users";

        $data = $this->conn->executeQuery($sql);

        return $data;
    }
}

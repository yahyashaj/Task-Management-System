<?php
class Database
{
    static protected $instance;
    protected $connection;
    function __construct()
    {
        $this->connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if (!$this->connection)
            file_put_contents(ROOTPATH . "logs/" . "dbErrorDB.log", date('Y-m-d H:i') . "001" . " --\n Could Not Connect To The Database \n\r", FILE_APPEND);
        self::$instance = $this;
    }


    public function executeQuery($statment)
    {

        try {
            $result = mysqli_query($this->connection, $statment);

            while ($data[] = mysqli_fetch_assoc($result)) {
            }

            if (count($data) > 0) {
                foreach ($data as $id => $value) {
                    if (is_array($value)) {
                        if (count($value) > 0) {
                            foreach ($value as $i => $v) {
                                $data[$id][$i] = stripcslashes($v);
                            }
                        }
                    }
                }
            }
        } catch (Exception  $e) {
            file_put_contents(ROOTPATH . "logs/" . "dbErrorDB.log", date('Y-m-d H:i') . "004" . " --\n can't execute query \n\r", FILE_APPEND);
        }
        $data = empty($data) ? array() : $data;
        array_pop($data);

        return $data;
    }
    public function executeNonQuery($statment)
    {
        $result =  mysqli_query($this->connection, $statment);
        if (is_bool($result) !== true) {
            if ($data = mysqli_fetch_row($result)) {
                return $data;
            }
        } else {
            return mysqli_affected_rows($this->connection);
        }
    }
}

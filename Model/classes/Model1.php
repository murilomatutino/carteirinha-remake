<?php

class Model1
{
    public $conn;

    public function __construct() {
        require(__DIR__ . "/../connect.php");
        $this->conn = $conn;
    }

    protected function executeQuery($query, $params = [], $types = "") {
        $stmt = $this->conn->prepare($query);
        if ($params) { $stmt->bind_param($types, ...$params); }

        if (!$stmt->execute()) { return false;}

        if (stripos(trim($query), "SELECT") === 0) {
            $result = $stmt->get_result();
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        return $stmt->affected_rows;
    }

    protected function executeUpdate($query, $params = [], $types = "") {
        $stmt = $this->conn->prepare($query);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $success = $stmt->execute();
        return $success ? $stmt->affected_rows > 0 : false;
    }

}

?>
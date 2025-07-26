<?php
    require_once(__DIR__ . "/Model.php");

    class AuthModel extends Model
    {
        public function getDataByMatricula($matricula) {
            $query = "SELECT id, nome, email, matricula, categoria, telefone FROM usuario WHERE matricula = ?";
            $result = $this->executeQuery($query, [$matricula], "s");
            return $result ? $result[0] : false;
        }

        public function login($matricula, $pass) {
            $query = "SELECT senha FROM usuario WHERE matricula = ?";
            $result = $this->executeQuery($query, [$matricula], "s");
            return $result && md5($pass) === $result[0]['senha'];
        }
    }

?>
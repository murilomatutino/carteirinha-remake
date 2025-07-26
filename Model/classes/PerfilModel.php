<?php
    require_once(__DIR__ . "/Model.php");
    
    class PerfilModel extends Model
    {
        public function setPassword($newPassword, $idUser)
        {
            $query = "UPDATE usuario SET senha = md5(?) WHERE id = ?";
            return $this->executeUpdate($query, [$newPassword, $idUser], "si");
        }
    }
?>
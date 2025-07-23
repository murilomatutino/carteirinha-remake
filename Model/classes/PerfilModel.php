<?php
    require_once(__DIR__ . "/Model1.php");
    
    class PerfilModel extends Model1
    {
        public function setPassword($newPassword, $idUser)
        {
            $query = "UPDATE usuario SET senha = md5(?) WHERE id = ?";
            return $this->executeUpdate($query, [$newPassword, $idUser], "si");
        }
    }
?>
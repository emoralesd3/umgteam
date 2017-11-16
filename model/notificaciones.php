<?php
class NotificacionesModel extends Conexion
{
    public function obtenerNotificacion($session){
        $sql_noti = "SELECT * FROM notificaciones WHERE user2=:id_user AND leido = '0' ORDER BY id_not desc";
        $stmt_noti = Conexion::conectar()->prepare($sql_noti);
        $stmt_noti->bindParam(':id_user', $session, PDO::PARAM_STR);
        $stmt_noti->execute();
        return $stmt_noti->fetchAll();
    }

    public function obtenerUsuario($id_user){
        $sql_noti = "SELECT * FROM usuarios WHERE id_use=:id_use";
        $stmt_noti = Conexion::conectar()->prepare($sql_noti);
        $stmt_noti->bindParam(':id_use', $id_user, PDO::PARAM_STR);
        $stmt_noti->execute();
        return $stmt_noti->fetchAll();
    }
}
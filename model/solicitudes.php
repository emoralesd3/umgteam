<?php
class SolicitudesModel extends Conexion
{
    public function actualizarSolicitud($id)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE amigos SET estado = '1' WHERE id_ami = '$id'");
        $stmt->execute();
    }

    public function eliminarSolicitud($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM amigos WHERE id_ami = '$id'");
        $stmt->execute();
    }
}
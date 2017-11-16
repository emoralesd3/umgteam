<?php
class FotosModel extends Conexion
{
    public function obtenerAlbumesUsuario($id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM albumes WHERE usuario = '$id' ORDER BY id_alb asc");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerLasFotos($idAlbum)
    {
        $stmt = Conexion::conectar()->prepare("SELECT ruta FROM fotos WHERE album = '$idAlbum' ORDER BY id_fot DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerLasFotosAlbum($id,$album)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM fotos WHERE usuario = '$id' AND album = '$album' ORDER BY id_fot desc");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
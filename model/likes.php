<?php
class LikesModel extends Conexion
{
    public function comprobarLike($post,$usuario)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM likes WHERE post = '".$post."' AND usuario = ".$usuario."");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function agregarLike($usuario,$post)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO likes (usuario,post,fecha) values ('$usuario','$post',now())");
        $stmt->execute();
    }

    public function actualizarDandoLike($post)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE publicaciones SET likes = likes+1 WHERE id_pub = '".$post."'");
        $stmt->execute();
    }

    public function actualizarQuitandoLike($post)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE publicaciones SET likes = likes-1 WHERE id_pub = '".$post."'");
        $stmt->execute();
    }

    public function eliminarLike($post,$usuario)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM likes WHERE post = ".$post." AND usuario = ".$usuario."");
        $stmt->execute();
    }

    public function totalLikes($post)
    {
        $stmt = Conexion::conectar()->prepare("SELECT likes FROM publicaciones WHERE id_pub = ".$post."");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
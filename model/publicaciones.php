<?php
class PublicacionesModel extends Conexion
{
    public function showTablePublicaciones(){
        $result = Conexion::conectar()->prepare("SHOW TABLE STATUS WHERE `Name` = 'publicaciones'");
        $result->execute();
        return $result->fetchAll();
    }

    public function InsertarPublicacion($id_user,$publicacion,$id_img,$id_album)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO publicaciones (usuario,fecha,contenido,imagen,album,comentarios) values ('".$id_user."',now(),'$publicacion','".$id_img."','".$id_album."','1')");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function crearAlbum($id_user)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO albumes (usuario,fecha,nombre) values ('".$id_user."',now(),'Publicaciones')");
        return $stmt->execute();
    }

    public function obtenerNumeroAlbumesSegunUsuario($id_user)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM albumes WHERE usuario ='".$id_user."' AND nombre = 'Publicaciones'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function subirImg($id_user,$ruta,$idAlbum,$next_increment)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO fotos (usuario,fecha,ruta,album,publicacion) values ('".$id_user."',now(),'$ruta','".$idAlbum."','$next_increment')");
        return $stmt->execute();
    }

    public function obtenerImagenesSegunUsuario($id_user)
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_fot FROM fotos WHERE usuario = '".$id_user."' ORDER BY id_fot desc");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function todasLasPublicaciones()
    {
        $result = Conexion::conectar()->prepare("SELECT * FROM publicaciones");
        $result->execute();
        return $result->fetchAll();
    }

    public function todasLasPublicacionesSegunUsuario($aid)
    {
        $result = Conexion::conectar()->prepare("SELECT * FROM publicaciones WHERE usuario = '$aid'");
        $result->execute();
        return $result->fetchAll();
    }

    public function publicacionesMostrar($compag,$CantidadMostrar)
    {
        $consultavistas = "SELECT *
				FROM
				publicaciones
				ORDER BY
				id_pub DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
        $stmt = Conexion::conectar()->prepare($consultavistas);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function publicacionesMostrarSegunUsuario($aid,$compag,$CantidadMostrar)
    {
        $consultavistas ="SELECT *
            FROM
            publicaciones WHERE usuario = '$aid'
            ORDER BY
            id_pub DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
        $stmt = Conexion::conectar()->prepare($consultavistas);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserId($userid)
    {
        $usuariob = "SELECT * FROM usuarios WHERE id_use = '$userid'";
        $stmt = Conexion::conectar()->prepare($usuariob);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerFotosPorPublicacion($id_pub)
    {
        $fotos = "SELECT * FROM fotos WHERE publicacion = '$id_pub'";
        $stmt = Conexion::conectar()->prepare($fotos);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function numeroComentarios($id_pub)
    {
        $sql = "SELECT * FROM comentarios WHERE publicacion = '".$id_pub."'";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->execute();
        return count($stmt->fetchAll());
    }

    public function totalLikes($id_pub, $id_usuario)
    {
        $sql = "SELECT * FROM likes WHERE post = '".$id_pub."' AND usuario = '".$id_usuario."'";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function comentariosSegunPublicacion($id_pub)
    {
        $sql = "SELECT * FROM comentarios WHERE publicacion = '".$id_pub."' ORDER BY id_com desc LIMIT 2";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function agregarComentario($usuario,$comentario,$publicacion)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO comentarios (usuario, comentario, fecha, publicacion) VALUES ('$usuario', '$comentario', now(), '$publicacion')");
        $stmt->execute();
    }

    public function obtenerPublicacion($publicacion)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM publicaciones WHERE id_pub = '".$publicacion."'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function agregarNotificacionComentario($usuario,$usuario2,$publicacion)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO notificaciones (user1, user2, tipo, leido, fecha, id_pub) VALUES ('$usuario', '$usuario2', 'ha comentado', '0', now(), '$publicacion')");
        $stmt->execute();
    }
}
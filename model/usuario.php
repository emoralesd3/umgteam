<?php
class UsuarioModel extends Conexion
{
    public function verificarUsuario($username)
    {
        $sql = "SELECT usuario FROM usuarios WHERE usuario=:username";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(':username',$username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function verificarEmail($email)
    {
        $sql = "SELECT email FROM usuarios WHERE email=:email";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(':email',$email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function verificarIdGoogle($idAuth)
    {
        $stmt = Conexion::conectar()->prepare("select * from usuarios where oauth_uid=?");
        $stmt->bindParam(1, $idAuth);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insertarUsuarioAuthO($datos)
    {
        $sql = "INSERT INTO usuarios (oauth_uid,nombre,apellido,email,avatar,sexo,fecha_reg) values (:oauth_uid,:nombre,:apellido,:email,:avatar,:sexo,now())";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(':oauth_uid', $datos['oauth_uid'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido',$datos['apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':email',$datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(':avatar',$datos['avatar'], PDO::PARAM_STR);
        $stmt->bindParam(':sexo',$datos['sexo'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertarUsuario($datos)
    {
        $sql = "INSERT INTO usuarios(nombre,usuario,contrasena,avatar,email,sexo,fecha_reg) values(:nombre,:usuario,:contrasena,:avatar,:email,:sexo,now())";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':usuario',$datos['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(':contrasena',$datos['contrasena'], PDO::PARAM_STR);
        $stmt->bindParam(':avatar',$datos['avatar'], PDO::PARAM_STR);
        $stmt->bindParam(':email',$datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(':sexo',$datos['sexo'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function login($usuario,$pw){
        $sql = "SELECT * FROM usuarios WHERE usuario=:usuario AND contrasena=:pw";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(':usuario',$usuario, PDO::PARAM_STR);
        $stmt->bindParam(':pw',$pw, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function amistadDe($id_user)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM amigos WHERE para = '".$id_user."' AND estado = '0' order by id_ami desc LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function usuariosConSolicitud($amistadDe)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id_use = '".$amistadDe."'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ultimosRegistrados()
    {
        $stmt = Conexion::conectar()->prepare("SELECT id_use,avatar,usuario,fecha_reg FROM usuarios order by id_use desc limit 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerMiUsuario($id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id_use = '$id'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function comprobarUsuario($usuario,$id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE usuario = '$usuario' AND id_use != '$id'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function actualizarUsuario($nombre,$usuario,$email,$sexo,$nac,$nombrea,$id)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', email = '$email', sexo = '$sexo', nacimiento = '$nac', avatar = '$nombrea' WHERE id_use = '$id'");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function obtenerAmigos($idDe,$idPara)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM amigos WHERE de = '$idDe' AND para = '".$idPara."' OR de = '".$idPara."' AND para = '$idDe'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function seguir($de,$para)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO amigos (de,para,fecha,estado) values ('".$de."','$para',now(),'0')");
        $stmt->execute();
    }

    public function seguirDirecto($de,$para)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO amigos (de,para,fecha,estado) values ('".$de."','$para',now(),'1')");
        $stmt->execute();
    }

    public function dejarSeguir($de,$para)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM amigos WHERE de = '$de' AND para = '".$para."' OR de = '".$para."' AND para = '$de'");
        $stmt->execute();
    }
}
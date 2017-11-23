<?php
    require_once('model/config_google.php');
    require_once('lib/config.php');
    require_once('model/usuario.php');
    $usuarioAuth = new UsuarioModel;
    if(isset($_SESSION['access_token'])){
        $google_client->setAccessToken($_SESSION['access_token']);
        echo 'hola 1';
    }
    else if(isset($_GET['code'])){
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
        echo 'hola 2';
    }else{
        echo 'hola 3';
        header('Location: login.php');
        exit();
    }

    $oAuth = new Google_Service_Oauth2($google_client);
    $userData = $oAuth->userinfo_v2_me->get();

    /*$datos = array(
        "oauth_uid" => $userData['id'],
        "nombre" => $userData['name']['givenName'],
        "apellido" => $userData['name']['familyName'],
        "email" => $userData['verified'],
        "avatar" => $userData['image']['url'],
        "sexo" => $userData['gender']
    );

    $idUser = $usuarioAuth->verificarIdGoogle($datos['oauth_uid']);
    if($idUser['oauth_uid'] != $datos['oauth_uid']){
        $usuarioAuth->insertarUsuarioAuthO($datos);
    }
    */
    //$_SESSION['id'] = $datos['oauth_uid'];
    var_dump($userData);

    //header('Location: index.php');
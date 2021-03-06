<?php
    require_once('model/config_google.php');
    require_once('lib/config.php');
    require_once('model/usuario.php');
    $usuarioAuth = new UsuarioModel;
    if(isset($_GET['code'])){
        //$google_client->authenticate($_GET['code']);
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
        //$token = $google_client->getAccessToken();
        $_SESSION['access_token'] = $token;
        //$google_client->setAccessToken($token);
    }

    $oAuth = new Google_Service_Oauth2($google_client);
    $userData = $oAuth->userinfo_v2_me->get();
    
    $datos = array(
        "oauth_uid" => $userData['id'],
        "nombre" => $userData['givenName'],
        "apellido" => $userData['familyName'],
        "email" => $userData['email'],
        "avatar" => $userData['picture'],
        "sexo" => $userData['gender']
    );

    $_SESSION['access_token'] = $token;

    //$idUser = $usuarioAuth->verificarIdGoogle($datos['oauth_uid']);

    //if(!$idUser){
      //  $usuarioAuth->insertarUsuarioAuthO($datos);
    //}
    //var_dump($_SESSION['access_token']);
    //$_SESSION['id'] = $datos['oauth_uid'];

    header('Location: index.php');
    exit();
?>
<?php
session_start();
require_once('lib/config.php');
require_once('model/usuario.php');

//ini_set('error_reporting',0);

if(isset($_SESSION['usuario']))
{
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php //nombre red social ?> Registro</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/skins/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <center><img src="images/logotipo1.png" class="img-responsive"></center>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Regístrate en REDSOCIAL</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="<?php echo $_POST['nombre']; ?>" required>
        <span class="glyphicon glyphicon-star form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $_POST['email']; ?>" required>  
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $_POST['usuario']; ?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="checkbox">
        <label>
          <input type="radio" value="H" name="sexo" required> Hombre <br>
          <input type="radio" value="M" name="sexo" required> Mujer
        </label>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="repcontrasena" class="form-control" placeholder="Repita la contraseña" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-10">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="check" required> Acepto los <a href="#">términos y condiciones</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" name="registrar" class="btn btn-primary btn-block btn-flat">Registrarme</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


    <?php

    if(isset($_POST['registrar'])) {
      $usuarioModelo = new UsuarioModel;
      $avatar = '';
      if($_POST['sexo'] == 'H'){
        $avatar = 'male.png';
      }else{
        $avatar = 'female.png';
      }
      $datos = array(
        'nombre' => htmlspecialchars($_POST['nombre']),
        'email' => htmlspecialchars($_POST['email']),
        'avatar' => $avatar,
        'sexo' => htmlspecialchars($_POST['sexo']),
        'usuario' => htmlspecialchars($_POST['usuario']),
        'contrasena' => htmlspecialchars(md5($_POST['contrasena']))
      );
      var_dump($datos);
      $repcontrasena = htmlspecialchars(md5($_POST['repcontrasena']));

      $comprobarusuario = $usuarioModelo->verificarUsuario($datos['usuario']);
      
      $comprobaremail = $usuarioModelo->verificarEmail($datos['email']);

      if($comprobarusuario) { ?>
        <br>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          El nombre de usuario está en uso, por favor escoja otro
      </div>

     <?php } else {

        if($comprobaremail) { ?>

        <br>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          El email ya está en uso por favor escoja otro o verifique si tiene una cuenta
        </div>

        <?php } else {

          if($datos['contrasena'] != $repcontrasena) { ?>

          <br>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Las contraseñas no coinciden
          </div>

          <?php } else {


            $insertar = $usuarioModelo->insertarUsuario($datos);

            if($insertar) { ?>

            <br>
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Felicidades se ha registrado correctamente
            </div>

            <?php

            header("Refresh: 2; url = login.php");

            }

          }

        }

      }

    }

    ?>

    <br>
    <a href="login.php" class="text-center">Tengo actualmente una cuenta</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

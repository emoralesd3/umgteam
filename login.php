<?php
session_start();
require_once('lib/config.php');
require_once('model/usuario.php');
require_once('vendor/autoload.php');
require_once('model/google_auth.php');

$google_client = new Google_Client();
$auth = new GoogleAuth($google_client);

if($auth->checkRedirectCode()){
  //die($_GET['code']);
  header("Location: index.php");
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bienvenido a REDSOCIAL</title>
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <center><img src="images/logotipo1.png" class="img-responsive"></center>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Bienvenido a REDSOCIAL</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario" pattern="[A-Za-z_-0-9]{1,20}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" pattern="[A-Za-z_-0-9]{1,20}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
        </div>
        <div class="col-xs-12">
          <a href="<?php echo $auth->getAuthUrl(); ?>" class="btn btn-danger btn-block btn-flat">Iniciar Sesión con tu cuenta UMG</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <?php
    if(isset($_POST['login']))
    {
      $usuario = htmlspecialchars($_POST['usuario']);
      $usuario = strip_tags($_POST['usuario']);
      $usuario = trim($_POST['usuario']);

      $contrasena = htmlspecialchars(md5($_POST['contrasena']));
      $contrasena = strip_tags(md5($_POST['contrasena']));
      $contrasena = trim(md5($_POST['contrasena']));
      $usuarioModelo = new UsuarioModel;

      $contar = $usuarioModelo->login($usuario,$contrasena);

      if($contar)
      {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['avatar'] = $contar['avatar'];
        $_SESSION['id'] = $contar['id_use'];

        header('Location: index.php');
      }else{ ?>
        <br>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Los datos ingresados no son correctos
          </div>
      <?php }
    }

    ?>

    <br>

    <a href="#">Olvidé mi contraseña</a><br>
    <a href="registro.php" class="text-center">Registrarme en REDSOCIAL</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

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
<?php
session_start();
require_once('lib/config.php');
require_once('lib/socialnetwork-lib.php');
require_once('model/usuario.php');
require_once('vendor/autoload.php');
require_once('model/google_auth.php');

ini_set('error_reporting',0);

$google_client = new Google_Client();
$auth = new GoogleAuth($google_client);

if($auth->checkRedirectCode()){
  //die($_GET['code']);
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<htmL>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EDITAR MI PERFÍL</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php echo Headerb (); ?>

<?php echo Side (); ?>

<?php
if(isset($_GET['id']))
{
$id = htmlspecialchars($_GET['id']);

$use = UsuarioModel::obtenerMiUsuario($id);

if($_SESSION['id'] != $id) {
?>
<script type="text/javascript">window.location="login.php";</script>
<?php
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- /.box -->



          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar mi perfíl</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre completo</label>
                  <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="<?php echo $use[0]['nombre'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $use[0]['usuario'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $use[0]['email'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Cambiar mi avatar</label>
                  <input type="file" name="avatar">
                </div>
                <div class="checkbox">
                  <label>
                    <input type="radio" value="H" name="sexo" <?php if($use[0]['sexo'] == 'H') { echo 'checked'; } ?>> Hombre <br>
                    <input type="radio" value="M" name="sexo" <?php if($use[0]['sexo'] == 'M') { echo 'checked'; } ?>> Mujer
                  </label>
                </div>

                <!-- Date dd/mm/yyyy -->
              <div class="form-group">
                <label>Fecha de nacimiento</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="nacimiento" placeholder="<?php echo $use[0]['nacimiento'];?>" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask >
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar datos</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

          <?php
          if(isset($_POST['actualizar']))
          {
            $nombre = htmlspecialchars($_POST['nombre']);
            $usuario = htmlspecialchars($_POST['usuario']);
            $email = htmlspecialchars($_POST['email']);
            $sexo = htmlspecialchars($_POST['sexo']);
            $nacimiento = htmlspecialchars($_POST['nacimiento']);
            if($nacimiento != '') {$nac = $nacimiento;} else {$nac = $use['nacimiento'];}

            $comprobar = count(UsuarioModel::comprobarUsuario($usuario,$id));
            
            if($comprobar == 0){

            $type = 'jpg';
            $rfoto = $_FILES['avatar']['tmp_name'];
            $name = $id.'.'.$type;

            if(is_uploaded_file($rfoto))
            {
              $destino = 'avatars/'.$name;
              $nombrea = $name;
              copy($rfoto, $destino);
            }
            else
            {
              $nombrea = $use['avatar'];
            }

            $sql = UsuarioModel::actualizarUsuario($nombre,$usuario,$email,$sexo,$nac,$nombrea,$id);
            var_dump($sql);
            if($sql) {echo "<script type='text/javascript'>window.location='editarperfil.php?id=$_SESSION[id]';</script>";}

            } else {echo 'El nombre de usuario ya está en uso, escoja otro';}

          }
          ?>


        </div>

        <div class="col-md-4">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Últimos registrados</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  <?php $registrados = UsuarioModel::ultimosRegistrados();
                  foreach($registrados as $reg)
                  {
                  ?>
                    <li>
                      <img src="avatars/<?php echo $reg['avatar']; ?>" alt="User Image" width="100" height="200">
                      <a class="users-list-name" href="#"><?php echo $reg['usuario']; ?></a>
                      <span class="users-list-date">Hoy</span>
                    </li>
                  <?php
                  }
                  ?>

                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->


      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
  $(function () {
    $("[data-mask]").inputmask();
  });
</script>
</body>
</html>
<?php } ?>
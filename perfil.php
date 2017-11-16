<?php
session_start();
require_once('lib/config.php');
require_once('lib/socialnetwork-lib.php');
require_once('model/usuario.php');
require_once('model/fotos.php');

ini_set('error_reporting',0);

if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
}
?>

<?php
  if(isset($_GET['id']))
  {
    $id = htmlspecialchars($_GET['id']);
    if(isset($_GET['perfil'])){
      $pag = $_GET['perfil'];
    }
  $usuarioModelo = new UsuarioModel;

  $use = $usuarioModelo->obtenerMiUsuario($id);

  $ami = $usuarioModelo->obtenerAmigos($id,$_SESSION['id']);
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $use[0]['nombre']; ?> | REDSOCIAL</title>
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

    <!-- codigo scroll -->
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.jscroll.js"></script>
  <!-- codigo scroll -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php echo Headerb (); ?>

  <?php echo Side (); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="avatars/<?php echo $use[0]['avatar'];?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $use[0]['nombre'];?></h3> 
              <?php if($use[0]['verificado'] != 0) {?>
              <center><span class="glyphicon glyphicon-ok"></span></center>
              <?php } ?>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Seguidores</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Siguiendo</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Amigos</b> <a class="pull-right">13,287</a>
                </li>
              </ul>
              
              <?php if($_SESSION['id'] != $id) {?>
              <form action="" method="post">
              
              <?php if(count($ami) >= 1 AND $ami[0]['estado'] == 0) { ?>
              <center><h4>Esperando respuesta</h4></center>
              <?php } else { ?>

              <?php if($use[0]['privada'] == 1 AND $ami[0]['estado'] == 0) { ?>
              <input type="submit" class="btn btn-primary btn-block" name="seguir" value="Enviar solicitud de amistad">
              <?php } ?>
              <?php if($use[0]['privada'] == 1 AND $ami[0]['estado'] == 1) { ?>
              <input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">
              <?php } ?>
              <?php if($use[0]['privada'] == 0 AND $ami[0]['estado'] == 0) { ?>
              <input type="submit" class="btn btn-primary btn-block" name="seguirdirecto" value="Seguir">
              <?php } ?>
              <?php if($use[0]['privada'] == 0 AND $ami[0]['estado'] == 1) { ?>
              <input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">
              <?php } ?>


              <?php } ?>
              </form>
              <?php } ?>

              <?php
              if(isset($_POST['seguir'])) {
                $add = $usuarioModelo->seguir($_SESSION['id'],$id);
                if($add) {'<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>

              <?php
              if(isset($_POST['seguirdirecto'])) {
                $add = $usuarioModelo->seguirDirecto($_SESSION['id'],$id);
                if($add) {'<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>

              <?php
              if(isset($_POST['dejarseguir'])) {
                $add = $usuarioModelo->dejarSeguir($id,$_SESSION['id']);
                if($add) {'<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>
              
              <!--<br>
              <a href="chat.php?usuario=<?php //echo $id; ?>"><input type="button" class="btn btn-default btn-block" name="dejarseguir" value="Enviar chat"></a>
              -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box 
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div> -->
            <!-- /.box-header 
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>-->
            <!-- /.box-body 
          </div> -->
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php echo $pag == 'miactividad' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=miactividad">Actividad</a></li>
              <li class="<?php echo $pag == 'informacion' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=informacion">Información</a></li>
              <li class="<?php echo $pag == 'fotos' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=fotos">Fotos</a></li>
            </ul>
            <div class="tab-content">

                
          <!-- codigo scroll -->
          <div class="scroll">

          <?php
          
          if($use[0]['privada'] != 1) { ?>
          
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
            require_once $pagina.'.php';
            ?>

          <?php } elseif ($use[0]['privada'] == 1 AND $ami[0]['estado'] == 1) { ?>
              
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
            require_once $pagina.'.php';
            ?>

          <?php } elseif ($use[0]['privada'] == 1 AND $_SESSION['id'] == $id) { ?>
              
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
            require_once $pagina.'.php';
            ?>


          <?php } else { ?>

          <center><h2>Este perfil es privado, envia una solicitud</h2></center>

          <?php } ?>

          </div>

            
                
              </div>
  
          </div>
          <!-- /.nav-tabs-custom -->
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

<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php

} // finaliza if GET
?>
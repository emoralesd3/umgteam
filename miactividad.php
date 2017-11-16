<?php
session_start();
require_once('lib/config.php');
require_once('model/publicaciones.php');
?>
<script type="text/javascript" src="js/likes.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    $(".enviar-btn").keypress(function(event) {

      if ( event.which == 13 ) {

        var getpID =  $(this).parent().attr('id').replace('record-','');

        var usuario = $("input#usuario").val();
        var comentario = $("#comentario-"+getpID).val();
        var publicacion = getpID;
        var avatar = $("input#avatar").val();
        var nombre = $("input#nombre").val();
        var now = new Date();
        var date_show = now.getDate() + '-' + now.getMonth() + '-' + now.getFullYear() + ' ' + now.getHours() + ':' + + now.getMinutes() + ':' + + now.getSeconds();

        if (comentario == '') {
            alert('Debes añadir un comentario');
            return false;
        }

        var dataString = 'usuario=' + usuario + '&comentario=' + comentario + '&publicacion=' + publicacion;

        $.ajax({
                type: "POST",
                url: "agregarcomentario.php",
                data: dataString,
                success: function() {
                    $('#nuevocomentario'+getpID).append('<div class="box-comment"><img class="img-circle img-sm" src="avatars/'+ avatar +'"><div class="comment-text"><span class="username"> '+ nombre +'<span class="text-muted pull-right">' + date_show + '</span></span>' + comentario + '</div></div>');
                    $("#comentario-"+getpID).val('');
                }
        });
        return false;
      }
    });

});
</script>

<?php
$publicaciones = new PublicacionesModel;
$CantidadMostrar=5;
$aid = htmlspecialchars($_GET['id']);
     // Validado  la variable GET
    $compag         = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
    $totalr         = count($publicaciones->todasLasPublicacionesSegunUsuario($aid));
  //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
  $TotalRegistro  =ceil($totalr/$CantidadMostrar);
   //Operacion matematica para mostrar los siquientes datos.
  $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):0;
  //Consulta SQL

  $consulta = $publicaciones->publicacionesMostrarSegunUsuario($aid,$compag,$CantidadMostrar);
  foreach($consulta as $lista){

    $userid = htmlspecialchars($lista['usuario']);

    $use = $publicaciones->getUserId($userid);

    $fot = $publicaciones->obtenerFotosPorPublicacion($lista['id_pub']);
  ?>
  <!-- START PUBLICACIONES -->
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="avatars/<?php echo $use[0]['avatar']; ?>" alt="User Image">
                <span class="description" onclick="location.href='perfil.php?id=<?php echo $use[0]['id_use'];?>';" style="cursor:pointer; color: #3C8DBC;""><?php echo $use[0]['usuario'];?></span>
                <span class="description"><?php echo $lista['fecha'];?></span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- post text -->
              <p><?php echo $lista['contenido'];?></p>

              <?php 
              if($lista['imagen'] != 0)
              {
              ?>
              <img src="publicaciones/<?php echo $fot[0]['ruta'];?>" width="100%">
              <?php
              }
              ?>

              <br><br>
              <?php 
              $numcomen = $publicaciones->numeroComentarios($lista['id_pub']);
              ?>
              <!-- Social sharing buttons -->
            <ul class="list-inline">

              <?php
              $query = $publicaciones->totalLikes($lista['id_pub'],$_SESSION['id']);

              if (count($query) == 0) { ?>

                <li><div class="btn btn-default btn-xs like" id="<?php echo $lista['id_pub']; ?>"><i class="fa fa-thumbs-o-up"></i> Me gusta </div><span id="likes_<?php echo $lista['id_pub']; ?>"> (<?php echo $lista['likes']; ?>)</span></li>

              <?php } else { ?>
                
                <li><div class="btn btn-default btn-xs like" id="<?php echo $lista['id_pub']; ?>"><i class="fa fa-thumbs-o-up"></i> No me gusta </div><span id="likes_<?php echo $lista['id_pub']; ?>"> (<?php echo $lista['likes']; ?>)</span></li>

              <?php } ?>



                    <li class="pull-right">
                      <span href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comentarios
                        (<?php echo $numcomen; ?>)</span></li>
                  </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer box-comments">

            <?php 
            $comentarios = $publicaciones->comentariosSegunPublicacion($lista['id_pub']);
            foreach($comentarios as $com){
              $usec = $publicaciones->getUserId($com['usuario']);
              ?>


              <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="avatars/<?php echo $usec[0]['avatar'];?>">

                <div class="comment-text">
                      <span class="username">
                        <?php echo $usec[0]['usuario'];?>
                        <span class="text-muted pull-right"><?php echo $com['fecha'];?></span>
                      </span><!-- /.username -->
                  <?php echo $com['comentario'];?>
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
              <?php } ?>

              <?php if ($numcomen > 2) { ?> 
              <br>
                <center><span onclick="location.href='publicacion.php?id=<?php echo $lista['id_pub'];?>';" style="cursor:pointer; color: #3C8DBC;">Ver todos los comentarios</span></center>
              <?php } ?>

              <div id="nuevocomentario<?php  echo $lista['id_pub'];?>"></div>
              <br>
                <form method="post" action="">
                <label id="record-<?php  echo $lista['id_pub'];?>">
                <input type="text" class="enviar-btn form-control input-sm" style="width: 55em;" placeholder="Escribe un comentario" name="comentario" id="comentario-<?php  echo $lista['id_pub'];?>">
                <input type="hidden" name="usuario" value="<?php echo $_SESSION['id'];?>" id="usuario">
                <input type="hidden" name="publicacion" value="<?php echo $lista['id_pub'];?>" id="publicacion">
                <input type="hidden" name="avatar" value="<?php echo $_SESSION['avatar'];?>" id="avatar">
                <input type="hidden" name="nombre" value="<?php echo $_SESSION['usuario'];?>" id="nombre">
                </form>

              </div>

        </div>
        <!-- /.col -->
        <!-- END PUBLICACIONES -->
    
    <br><br>

  <?php
  }
  //Validmos el incrementador par que no genere error
  //de consulta.  
    if($IncrimentNum<=0){}else {
  echo "<a href=\"miactividad.php?id=$aid&pag=".$IncrimentNum."\">Seguiente</a>";
  }
?>
<script>
            //Simple codigo para hacer la paginacion scroll
            $(document).ready(function() {
              $('.scroll').jscroll({
                loadingHtml: '<img src="images/invisible.png" alt="Loading" />'
            });
            });
            </script>
          <!-- codigo scroll -->
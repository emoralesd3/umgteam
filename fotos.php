<?php
$id = htmlspecialchars($_GET['id']);
?>

                <center>
                <?php
                $fotosa = FotosModel::obtenerAlbumesUsuario($id);
                foreach($fotosa as $fot)
                {
                  $fotal = FotosModel::obtenerLasFotos($fot[id_alb]);
                  ?>
                    <a href="?id=<?php echo $id;?>&album=<?php echo $fot[id_alb]; ?>&perfil=albumes"><img src="publicaciones/<?php echo $fotal[0]['ruta'];?>" width="19%"> </a>
                    <br>
                    <?php echo $fot['nombre']; ?>
                  <?php
                }
                ?>
                </center>
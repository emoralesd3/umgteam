<?php
$id = htmlspecialchars($_GET['id']);
$album = htmlspecialchars($_GET['album']);
?>

                <center>
                <?php
                $fotosa = FotosModel::obtenerLasFotosAlbum($id,$album);
                foreach($fotosa as $fot)
                {
                  ?>
                    <a href="#"><img src="publicaciones/<?php echo $fot['ruta'];?>" width="19%"> </a>
                  <?php
                }
                ?>
                </center>
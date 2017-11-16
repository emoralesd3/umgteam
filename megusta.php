<?php
session_start();
require_once('lib/config.php');
require_once('model/likes.php');

$post = htmlspecialchars($_POST['id']);
$usuario = $_SESSION['id'];
$likesModelo = new LikesModel;


$count = $likesModelo->comprobarLike($post,$usuario);

if (count($count) == 0) {

	$insert = $likesModelo->agregarLike($usuario,$post);
	$update = $likesModelo->actualizarDandoLike($post);

}else
{

	$delete = $likesModelo->eliminarLike($post,$usuario);
	$update = $likesModelo->actualizarQuitandoLike($post);

}

$cont = $likesModelo->totalLikes($post);
$likes = $cont[0]['likes'];

if (count($count) >= 1) { $megusta = "<i class='fa fa-thumbs-o-up'></i> Me gusta"; $likes = " (".$likes++.")"; } else { $megusta = "<i class='fa fa-thumbs-o-up'></i> No me gusta"; $likes = " (".$likes--.")"; }

$datos = array('likes' =>$likes,'text' =>$megusta);

echo json_encode($datos);

?>
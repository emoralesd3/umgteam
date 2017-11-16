<?php
require('lib/config.php');
require_once('model/publicaciones.php');

$usuario = htmlspecialchars($_POST['usuario']);
$comentario = htmlspecialchars($_POST['comentario']);
$publicacion = htmlspecialchars($_POST['publicacion']);

$insert = PublicacionesModel::agregarComentario($usuario,$comentario,$publicacion);

$ll = PublicacionesModel::obtenerPublicacion($publicacion);

$usuario2 = htmlspecialchars($ll[0]['usuario']);

$insert2 = PublicacionesModel::agregarNotificacionComentario($usuario,$usuario2,$publicacion);
<?php
session_start();
require_once('lib/config.php');
require_once('lib/socialnetwork-lib.php');
require_once('model/solicitudes.php');

ini_set('error_reporting',0);

if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
}
?>

<?php
if(isset($_GET['id'])) {

	$id = htmlspecialchars($_GET['id']);
	$action = htmlspecialchars($_GET['action']);

	if($action == 'aceptar') {
		$update = SolicitudesModel::actualizarSolicitud($id);
		header('Location:' . getenv('HTTP_REFERER'));
	}

	if($action == 'rechazar') {
		$delete = SolicitudesModel::eliminarSolicitud($id);
		header('Location:' . getenv('HTTP_REFERER'));
	}
}
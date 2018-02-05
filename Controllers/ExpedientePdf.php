<?php 
	include_once('PlantillaExpedientePdf.php');
      include_once('../Models/Expediente.php');
      include_once('../Models/Seguimiento.php');
      include_once('../Models/Tramite.php');
      include_once('../Models/Solicitante.php');
      include_once('../Models/Area.php');
      include_once('../Models/Cargo.php');
      include_once('../Models/Usuario.php');
       require_once('../connection.php');
      $db=Db::getConnect();
	$expediente=Expediente::getById($_GET['idSeguimiento']);
      $tramite=Tramite::getById($expediente->getTramites_id());
      $solicitante=Solicitante::getById($expediente->getSolicitantes_id());
      $area=Area::getById($expediente->getAreas_id());
      $cargo=Cargo::getById($expediente->getCargos_id());
      $usuario=Usuario::getByCargo($expediente->getCargos_id());


	$seguimientos=Seguimiento::allByIdExpediente($_GET['idSeguimiento']);
      //var_dump($seguimientos);
      //die();

	$pdf = new PlantillaExpedientePdf();

      $pdf->AddPage();
      $pdf->encabezadoExpediente();
      $pdf->cuerpoExpediente($expediente, $tramite,$solicitante,$area,$cargo,$usuario);

     
      $numero_hc=$expediente->getNumero();
      //formato de salida para el nombre del archivo
      $nombre='EXPEDIENTE-'.$numero_hc.'-'.date("Y").'-'.date("m").'-'.date("d");
      $pdf->Output('D',$nombre.'.pdf');
      ob_end_flush();
 ?>
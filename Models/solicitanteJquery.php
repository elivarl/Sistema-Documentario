<?php 
	require_once('../connection.php');
    include_once('../Models/Solicitante.php');
    echo $_POST['patron'];	
	   $db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM solicitantes WHERE dni=:dni');
		$select->bindParam('dni',$_POST['patron']);
		$select->execute();

		$solicitanteDb=$select->fetch();
		$solicitante= new Solicitante($solicitanteDb['id'],$solicitanteDb['dni'],$solicitanteDb['nombres'],$solicitanteDb['apellidos'],$solicitanteDb['email'], $solicitanteDb['inactivo'],$solicitanteDb['curso'],$solicitanteDb['programa'],$solicitanteDb['direccion'],$solicitanteDb['telefono'],$solicitanteDb['carrera']);
		//var_dump($solicitante);
		//die();
		//return $solicitante
		if ($solicitante->getId()==NULL) {
			echo "<tr>
			<td class='id'> Sin datos</td>
			</tr>";
		} else {
			echo "<tr>
			<td class='id'>".$solicitante->getId()."</td>
			<td class='dni'>".$solicitante->getDni()."</td>
			<td>".$solicitante->getNombres()."</td>
			<td>".$solicitante->getApellidos()."</td>
			<td>".$solicitante->getCurso()."</td>
			<td>".$solicitante->getEmail()."</td>
			<td class='botonc'><button class='btn btn-success'>
			<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
			</button></td>
			</tr>";
		}
		

	

?>
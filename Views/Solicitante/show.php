<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<h1>Solicitantes Registrados</h1>
<form class="form-inline" action="?controller=solicitante&action=buscar" method="post">
	<div class="form-group row">
	  <div class="col-xs-4">
	    <input class="form-control" id="dni" name="dni" type="text" placeholder="Ingrese el DNI">
	  </div>
	</div>
	<div class="form-group row">
	 <div class="col-xs-4">
	    <button type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search"> </span> Buscar</button>
	  </div>
		</div>
	</form>
	<?php if (isset($_SESSION['mensaje'])) { //mensaje, cuando realiza alguna acción crud ?>
			<div class="alert alert-success">
				<strong><?php echo $_SESSION['mensaje']; ?></strong>
			</div>
		<?php } 
			unset($_SESSION['mensaje']);
		?>

<div class="container">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>DNI</th>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Programa</th>
					<th>Carrera</th>
					<th>Semestre/Año</th>
					<th>Dirección</th>					
					<th>Email</th>
					<th>Teléfono</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($lista_solicitantes as $solicitante)  {?>			
				<tr>
				<?php if ($solicitante->getId()!=""): ?>
					<td><?php echo $solicitante->getDni(); ?></td>
					<td><?php echo $solicitante->getNombres();?></td>
					<td><?php echo $solicitante->getApellidos();?></td>
					<td><?php //echo $solicitante->getPrograma();
							if ($solicitante->getPrograma()=='PR') {?>
								Programa Regular
							<?php } elseif ($solicitante->getPrograma()=='PD') {?>
								Profesionalización Docente
							<?php } else{?>
								Otros
							<?php } ?>
					</td>
					<td><?php //echo $solicitante->getCarrera();
							if ($solicitante->getCarrera()=='EI') {?>	
								Educación Inicial
							<?php } elseif ($solicitante->getCarrera()=='EIB') {?>
								Educación Inicial EIB
							<?php } elseif ($solicitante->getCarrera()=='EP') {?>
								Educación Primaria
							<?php } elseif ($solicitante->getCarrera()=='EPEIB') {?>
								Educación Primaria EIB
							<?php } elseif ($solicitante->getCarrera()=='EF') {?>
								Educación Física
							<?php } elseif ($solicitante->getCarrera()=='M') {?>
								Matemática
							<?php } elseif ($solicitante->getCarrera()=='CI') {?>
								Computación e Informática 
							<?php } else{?>
								Otros
							<?php } ?>
					</td>
					<td><?php echo $solicitante->getCurso();?></td>
					<td><?php echo $solicitante->getDireccion();?></td>
					<td><?php echo $solicitante->getEmail();?></td>
					<td><?php echo $solicitante->getTelefono();?></td>
					<td><?php if(strcmp($solicitante->getInactivo(),"checked")==0):  echo "Activo"?>
						<?php else: 
						echo "Inactivo"?>
					<?php endif ?></td>
					<td> <button type="button" class="btn btn-primary" onclick="location.href='?controller=solicitante&action=showupdate&id=<?php echo $solicitante->getId()?>'">Actualizar</button></td>
				<?php endif ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul class ="pagination">		
			<?php for ($i=1;$i<=$botones;$i++){ ?>
				<li><a href="?controller=solicitante&action=show&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
			<?php }?>			
		</ul>
	</div>
</div>
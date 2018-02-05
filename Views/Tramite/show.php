<?php if(!isset($_SESSION)) 
    { 
        session_start();   

    } ?>
<h1>Lista de Trámites</h1>
	<form class="form-inline" action="?controller=tramite&action=buscar" method="post">
	<div class="form-group row">
	  <div class="col-xs-4">
	    <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Por ej. Constancia">
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
					<th>Nombre del Trámite</th>
					<th>Precio del Trámite</th>					
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($lista_tramites as $tramite)  {?>

				<tr>
					<td><?php echo $tramite->getNombre(); ?></td>
					<td><?php echo $tramite->getCosto(); ?></td>
					<td><?php if(strcmp($tramite->getInactivo(),"checked")==0):  echo "Activo"?>
						<?php else: 
						echo "Inactivo"?>
					<?php endif ?></td>
					<td> <button type="button" class="btn btn-primary" onclick="location.href='?controller=tramite&action=showupdate&id=<?php echo $tramite->getId()?>'"><span class="glyphicon glyphicon-edit"> </span> Actualizar</button></td>					
					<td><button type="button" class="btn btn-success" onclick="location.href='?controller=tramite&action=showRequisito&idTramite=<?php echo $tramite->getId()?>'"><span class="glyphicon glyphicon-th"></span> Ver Requisitos</button></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul class ="pagination">		
			<?php for ($i=1;$i<=$botones;$i++){ ?>
				<li><a href="?controller=tramite&action=show&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
			<?php }?>			
		</ul>
	</div>
</div>
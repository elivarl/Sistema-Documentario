<?php if(!isset($_SESSION)) 
    { 
        session_start();   

    } ?>
<h1>Lista de Áreas</h1>
	<form class="form-inline" action="?controller=area&action=buscar" method="post">
	<div class="form-group row">
	  <div class="col-xs-4">
	    <input class="form-control" id="codigo" name="codigo" type="text" placeholder="Por ej. Dirección">
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
					<th>Código</th>
					<th>Nombre del Área</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($lista_areas as $area)  {?>

				<tr>
					<td><?php echo $area->getCodigo(); ?></td>
					<td><?php echo $area->getNombre(); ?></td>					
					<?php if ($area->getId()!=""): ?>
					<td><?php if(strcmp($area->getInactivo(),"checked")==0):  echo "Activo"?>
						<?php else: 
						echo "Inactivo"?>
					<?php endif ?></td>
					<td> <button type="button" class="btn btn-primary" onclick="location.href='?controller=area&action=showupdate&id=<?php echo $area->getId()?>'"><span class="glyphicon glyphicon-edit"> </span> Actualizar</button></td>					
					<td><button type="button" class="btn btn-success" onclick="location.href='?controller=area&action=showCargos&idArea=<?php echo $area->getId()?>'"><span class="glyphicon glyphicon-th"></span> Ver Cargos</button></td>
					<?php endif ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul class ="pagination">		
			<?php for ($i=1;$i<=$botones;$i++){ ?>
				<li><a href="?controller=area&action=show&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
			<?php }?>			
		</ul>
	</div>
</div>
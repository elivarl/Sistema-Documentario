<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<h1>Usuarios Registrados</h1>
<form class="form-inline" action="?controller=usuario&action=buscar" method="post">
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
					<th>Cargo</th>
					<th>Área</th>
					<th>Tipo</th>
					<th>Email</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($lista_usuarios as $usuario)  {?>			
				<tr>
					<td><?php echo $usuario->getDni(); ?></td>
					<td><?php echo $usuario->getNombres();?></td>
					<td><?php echo $usuario->getApellidos();?></td>
					<?php if ($usuario->getCargos_id()!=""): ?>				
						<?php
							foreach ($cargos as $cargo)  {
								if ( strcmp($cargo->getId(),$usuario->getCargos_id())==0 ) {?>
										<td><?php echo $cargo->getNombre();?></td>
									<?php
									foreach ($areas as $area)  {
				    					if ( strcmp($cargo->getAreas_id(),$area->getId())==0 ) {	
									?>	
									<td><?php echo $area->getNombre();?></td>
						<?php }} }}?>

						<?php if ($usuario->getCargos_id()==0) {?>
							<td></td>
							<td></td>
						<?php } ?>
					<td><?php if (strcmp($usuario->getTipo(),"A")==0): 
						echo "Administrador"
					?>
					<?php else: 
						echo "Usuario"?>
					<?php endif ?></td>

					<td><?php echo $usuario->getEmail();?></td>
					<td><?php if(strcmp($usuario->getInactivo(),"checked")==0):  echo "Activo"?>
						<?php else: 
						echo "Inactivo"?>
					<?php endif ?>
					</td>
					<td> <button type="button" class="btn btn-primary" onclick="location.href='?controller=usuario&action=showupdate&id=<?php echo $usuario->getId()?>'">Actualizar</button></td>
					<?php endif ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul class ="pagination">		
			<?php for ($i=1;$i<=$botones;$i++){ ?>
				<li><a href="?controller=usuario&action=showUser&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
			<?php }?>			
		</ul>
	</div>
</div>
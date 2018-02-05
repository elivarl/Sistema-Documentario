<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<h1>Buscar Expedientes Registrados</h1>
<form class="form-inline" action="?controller=usuario&action=consultar_exp" method="post">
	<div class="form-group row">
	  <div class="col-xs-4">
	    <input class="form-control" id="numero" name="numero" type="text" placeholder="Ingrese el Número de Expediente">
	  </div>
	</div>
	<div class="form-group row">
	 <div class="col-xs-4">
	    <button type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search"> </span> Buscar</button>
	  </div>
		</div>
	</form>
<div class="container">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Número</th>
					<th>Trámite</th>					
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>					
				<tr>
					<td><?php echo $expediente->getnumero(); ?></td>
					<?php foreach ($tramites as $tramite): ?>
						<?php if (strcmp($tramite->getId(),$expediente->getTramites_id())==0): ?>
							<td><?php echo $tramite->getNombre();?></td>
						<?php endif ?>
					<?php endforeach ?>
					
					<?php if (strcmp($expediente->getEstado(),"E")==0) {?>
						<td>Enviado Dirección General</td>
					<?php }?>
					<?php if (strcmp($expediente->getEstado(),"D")==0) {?>
						<td>Derivado Área</td>
					<?php }?>
					<?php if (strcmp($expediente->getEstado(),"A")==0) {?>
						<td>Atendido</td>				
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
	</div>
</div>
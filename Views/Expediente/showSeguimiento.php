<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<h1>Seguimiento Expedientes Registrados</h1>

<div class="container">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Numero Expediente</th>
					<th>Fecha envío</th>
					<th>Área Envía</th>
					<th>Área Recibe</th>				
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($seguimientos as $seguimiento)  {?>			
				<tr>
					<td><?php echo $expediente->getNumero(); ?></td>
					<td><?php echo $seguimiento->getFecha_envio(); ?></td>
					<?php foreach ($areas as $area): ?>
						<?php if (strcmp($area->getId(),$seguimiento->getArea_remitente_id())==0): ?>
							<td><?php echo $area->getNombre();?></td>
						<?php endif ?>
					<?php endforeach ?>
					<?php foreach ($areas as $area): ?>
						<?php if (strcmp($area->getId(),$seguimiento->getArea_recibe_id())==0): ?>
							<td><?php echo $area->getNombre();?></td>
						<?php endif ?>
					<?php endforeach ?>				
					
					<?php if (strcmp($seguimiento->getAccion(),"E")==0) {?>
						<td>Enviado</td>
					<?php }?>
					<?php if (strcmp($seguimiento->getAccion(),"D")==0) {?>
						<td>Derivado</td>
					<?php }?>
					<?php if (strcmp($seguimiento->getAccion(),"A")==0) {?>
						<td>Atendido</td>
					<?php }?>
				<td> </td>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
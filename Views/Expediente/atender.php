<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<div class="container">
	<h2>Atender Expediente</h2>
	  <form action='?controller=expediente&action=atender' method='post'>

	  	<div class="form-group">
	  		<label for="numero">Número:</label>
	  		<input type="hidden" class="form-control" id="id" name="id" required="true" readonly="false" autocomplete="off" value="<?php echo  $expediente->getId(); ?>">
		    <input type="number" class="form-control" id="numero" name="numero" required="true" value="<?php echo $expediente->getNumero(); ?>" readonly="false" autocomplete="off">
		</div>

	  	<div class="form-group">
	  		<label for="fecha">Fecha Registro:</label>
		    <input type="text" class="form-control" id="fecha_registro" name="fecha_registro" required="true" value="<?php echo  $expediente->getFecha_registro(); ?>" readonly="false" autocomplete="off">
		</div>
	  	
		<div class="form-group">
	  		<label for="dni">Solicitante:</label>
		    <input type="text" class="form-control" id="dni" name="dni" required="true" readonly="false" autocomplete="off" value=" <?php echo $solicitante->getNombres().' '.$solicitante->getApellidos() ?>">
		</div>
		<div class="form-group">
	  		<label for="dni">Trámite a derivar:</label>
		    <input type="text" class="form-control" id="dni" name="dni" required="true" readonly="false" autocomplete="off" value=" <?php echo $tramite->getNombre() ?>">
		</div>
		<div class="form-group">
	  		<label for="fecha">Fecha Atención:</label>
		    <input type="text" class="form-control" id="fecha_atencion" name="fecha_atencion" required="true" value="<?php echo  date('Y-m-d h:i:s') ; ?>" readonly="false" autocomplete="off">
		</div>
    	<div class="form-group">
	  		<label for="espacio"></label>		    
		</div>
		
		<div class="col-sm-2">
		    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar y Atender</button>
      </div>
      
	</form>
</div>

<!-- Modal Solicitante -->
	<div class="modal fade" id="modalSolicitante" role="dialog">
		<div class="modal-dialog" id="modalProductoTamanio">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Lista Solicitantes</h4>
					<div class="row">
						<div class="col-sm-8">
							<input type="text" class="form-control" maxlength="64"
								id="buscarSolicitanteDNI" placeholder="Escriba el DNI" />
						</div>
						<div class="col-sm-4">
							<button type="button" class="btn btn-default" id="buscar">
								<span class="glyphicon glyphicon-refresh"></span>
							</button>
						</div>
					</div>
				</div>

				<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-hover" id="tbProducto">
								<thead>
									<tr>
										<th>Id</th>
										<th>DNI</th>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Curso</th>
										<th>Email</th>
										<th>Acción</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="solicitante">
									<?php
										foreach ($lista_solicitantes as $solicitante)  {?>			
										<tr>
											<td class="id"><?php echo $solicitante->getId(); ?></td>
											<td class="dni"><?php echo $solicitante->getDni(); ?></td>
											<td><?php echo $solicitante->getNombres();?></td>
											<td><?php echo $solicitante->getApellidos();?></td>
											<td><?php echo $solicitante->getCurso();?></td>
											<td><?php echo $solicitante->getEmail();?></td>
											<td class="botonc"><button class="btn btn-success">
																	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																</button></td>
										</tr>
										<?php } ?>
								</tbody>
							</table>
						</div>
					<div id="paginar">
						<ul class ="pagination">		
							<?php for ($i=1;$i<=$botones;$i++){ ?>
								<li><a href="?controller=tramite&action=show&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
							<?php }?>			
						</ul>
					</div>
				</div>
				<div class="modal-footer">
					<!--Uso la funcion onclick para llamar a la funcion en javascript-->
					<button type="button" class="btn btn-default" data-dismiss="modal">Finalizar</button>
				</div>
			</div>
		</div>
	</div>
</div>


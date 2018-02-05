<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<style type="text/css">
#modalSolicitanteTamanio {
	width: 80% !important;
}
</style>
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<script type="text/javascript">
$(document).ready(
	function() {
	//añadir el dni de solicitante al expediente
		$("#solicitante").on(
			"click", ".botonc",	
								function() {
									var dni = "";
									var id = "";
									// Obtenemos todos los valores contenidos en los <td> de la fila
									// seleccionada
									$(this).parents("tr").find(".dni")
											.each(
													function() {
														dni += $(this).html()+ "\n";
													});
									$(this).parents("tr").find(".id")
											.each(
													function() {
														id += $(this).html()+ "\n";
													});
									
									$('#dni').val(dni);
									$('#id').val(id);

								});
//evento que obtiene una lista de productos por nombre
						$('#buscar').click(function() {
							var opcionVar = "buscarDNI";
							var nombreVar = $('#buscarSolicitanteDNI').val();
							$('#buscarSolicitanteDNI').val('');
							//obtiene y muestra la lista de productos para una página
							$.ajax({
								url : "../sdi/Models/solicitanteJquery.php",
								type : "POST",
								async : false,
								data : {
									patron : nombreVar,
									opcion : opcionVar
								},
								success : function(data) {
									$('#solicitante').html(data);
								},
								beforeSend : function() {
								},
								error : function(objXMLHttpRequest) {
								}
							});	
							});	

				});

</script>

<div class="container">
	<h2>Registro de Expediente</h2>
	  <form action='?controller=expediente&action=save' method='post'>

	  	<div class="form-group">
	  		<label for="numero">Número:</label>
		    <input type="number" class="form-control" id="numero" name="numero" required="true" value="<?php echo $numeroExpediente; ?>" readonly="false" autocomplete="off">
		</div>

	  	<div class="form-group">
	  		<label for="fecha">Fecha Registro:</label>
		    <input type="text" class="form-control" id="fecha_registro" name="fecha_registro" required="true" value="<?php echo date('Y-m-d h:i:s') ?>" readonly="false" autocomplete="off">
		</div>
	  	
		<div class="form-group">
	  		<label for="dni">DNI Solicitante:</label><!-- Trigger the modal with a button -->
			<button type="button" class="btn btn-primary" data-toggle="modal"
				data-target="#modalSolicitante">
				<span class="glyphicon glyphicon-search"></span> Buscar Solicitante
			</button>
		    <input type="text" class="form-control" id="dni" name="dni" required="true" readonly="false" autocomplete="off">
		    <input type="hidden" class="form-control" id="id" name="id" required="true" readonly="false" autocomplete="off">
		</div>
		
    	<div class="form-group">
	  		<label for="espacio"></label>		    
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="tramite">Trámite:</label>
			    <div class="col-sm-10"> 
			    	<select class="form-control" id="tramites_id" name="tramites_id">
				    	<?php
				    		foreach ($tramites as $tramite)  {?>
					        <option value=" <?php echo $tramite->getId(); ?>"> <?php echo $tramite->getNombre(); ?></option>
					    <?php } ?>
				    </select>  
				</div>
    	</div>

    	<div class="form-group">
	  		<label for="espacio"></label>		    
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2" for="remitida">Aréa remitida:</label>
			    <div class="col-sm-10"> 
			    	<select class="form-control" id="area_recibe_id" name="area_recibe_id">
				    	<?php
				    		foreach ($areas as $area)  {?>
					        <option value="<?php echo $area->getId(); ?>"><?php echo $area->getNombre(); ?></option>
					    <?php } ?>
				    </select>  
				</div>
    	</div>
		
		<div class="col-sm-2">
		    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar y Remitir</button>
      </div>
      
	</form>
</div>

<!-- Modal Solicitante -->
	<div class="modal fade" id="modalSolicitante" role="dialog">
		<div class="modal-dialog" id="modalSolicitanteTamanio">
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
							<table class="table table-hover" id="tbSolicitante">
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
										<tr>
											<td class="id">Sin datos
											</td>
										</tr>
								</tbody>s
							</table>
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


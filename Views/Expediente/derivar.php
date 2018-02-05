<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<div class="container">
	<h2>Derivar Expediente</h2>
	  <form action='?controller=expediente&action=derivar' method='post'>

	  	<div class="form-group">
	  		<label for="numero">Número:</label>
	  		<input type="hidden" class="form-control" id="id" name="id" required="true" readonly="false" autocomplete="off" value=" <?php echo  $expediente->getId(); ?>">
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
		    <input type="text" class="form-control" id="fecha_envio" name="fecha_envio" required="true" value="<?php echo  date('Y-m-d h:i:s') ; ?>" readonly="false" autocomplete="off">
		</div>
    	<div class="form-group">
	  		<label for="espacio"></label>		    
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2" for="remitida">Aréa derivar:</label>
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
		    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar y Derivar</button>
      </div>
      
	</form>
</div>




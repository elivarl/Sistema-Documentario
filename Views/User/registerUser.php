<div class="container">
	<h2>Registro de Usuario</h2>
	  <form action='?controller=usuario&action=save' method='post'>
	  <div class="form-group">
	  		<label for="dni">DNI:</label>
		    <input type="number" class="form-control" id="dni" name="dni" required="true"  placeholder="Ingrese su DNI" autocomplete="off">
		</div>
	  	<div class="form-group">
	  		<label for="alias">Alias:</label>
		    <input type="text" class="form-control" id="alias" name="alias" required="true" placeholder="Ingrese su alias" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="nombres">Nombres:</label>
		    <input type="text" class="form-control" id="nombres" name="nombres" required="true" placeholder="Ingrese sus nombres" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="apellidos">Apellidos:</label>
		    <input type="text" class="form-control" id="apellidos" name="apellidos" required="true" placeholder="Ingrese sus apellidos" autocomplete="off">
		</div>

		<div class="form-group">
		    <label for="email">Email:</label>
		    <input type="email" class="form-control" id="email" name="email" required="true" placeholder="Ingrese su email" autocomplete="off">
		</div>

		<div class="form-group">
		    <label for="pwd">Contraseña</label>
		    <input type="password" class="form-control" id="pwd" name="pwd" required="true" placeholder="Ingrese su contraseña">
		</div>

		<div class="form-group">
			<label class="control-label" for="remitida">Cargo/Área:</label>
			    	<select class="form-control" id="cargo_id" name="cargo_id">
				    	<?php
				    	foreach ($cargos as $cargo)  {
				    		foreach ($areas as $area)  {
				    			if ( strcmp($cargo->getAreas_id(),$area->getId())==0 ) {				    			
				    		?>
					        <option value="<?php echo $cargo->getId(); ?>"><?php echo $cargo->getNombre()." / ".$area->getNombre(); ?></option>
					    <?php 
					    	}
							}
					    } ?>
				    </select>
    	</div>

		<div class="form-group">
      		<label class="control-label" for="estcivil">Tipo de usuario:</label>
		      <select class="form-control" id="tipo" name="tipo">
		        <option value="A">Administrador</option>
		        <option value="U">Usuario</option>
		      </select> 
    	</div>
    	<div class="checkbox">
    		<label><input type="checkbox" name="inactivo" >Activo</label>
		</div>

		<div class="col-sm-2">
		    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar</button>
      </div>
      
	</form>
</div>
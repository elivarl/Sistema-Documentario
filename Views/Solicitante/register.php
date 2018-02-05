<div class="container">
	<h2>Registro de Solicitante</h2>
	  <form action='?controller=solicitante&action=save' method='post'>
	  <div class="form-group">
	  		<label for="alias">DNI:</label>
		    <input type="number" class="form-control" id="dni" name="dni" required="true"  placeholder="Ingrese su DNI" autocomplete="off">
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
      		<label class="control-label" for="programa">Programa:</label>
		      <select class="form-control" id="programa" name="programa">
		        <option value="PR">Programa Regular</option>
		        <option value="PD">Profesionalización Docente</option>
		        <option value="O">Otros</option>
		      </select> 
    	</div>

		<div class="form-group">
      		<label class="control-label" for="carrera">Carrera:</label>
		      <select class="form-control" id="carrera" name="carrera">
		        <option value="EI">Educación Inicial</option>
		        <option value="EIB">Educación Inicial EIB</option>
		        <option value="EP">Educación Primaria</option>
		        <option value="EPEIB">Educación Primaria EIB</option>
		        <option value="EF">Educación Física</option>
		        <option value="M">Matemática</option>
		        <option value="CI">Computación e Informática </option>
		        <option value="O">Otros</option>
		      </select> 
    	</div>
		<div class="form-group">
			<label for="curso">Semestre/Año:</label>
		    <input type="number" class="form-control" id="curso" name="curso" required="true" placeholder="Ingrese el curso si corresponde" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="direccion">Dirección:</label>
		    <input type="text" class="form-control" id="direccion" name="direccion" required="true" placeholder="Ingrese la direccion" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="telefono">Teléfono:</label>
		    <input type="text" class="form-control" id="telefono" name="telefono" required="true" placeholder="Ingrese el Teléfono" autocomplete="off">
		</div>
		<div class="checkbox">
        	<label><input type="checkbox" name="inactivo" >Activo</label>
    	</div>  
		<div class="col-sm-2">
		    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar</button>
      </div>
      
	</form>
</div>
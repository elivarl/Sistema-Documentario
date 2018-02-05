<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
<div class="container">
	 <h2>Actualizar Solicitante</h2>
	<form action='?controller=solicitante&action=update' method='post'>
		<input type='hidden' name='id' value='<?php echo $solicitante->getId(); ?>'>
		<div class="form-group">
		<div class="form-group">
	    	<label for="alias">DNI:</label>
	     	<input type="text" class="form-control" id="dni" name="dni" required="true" readonly="false" value="<?php echo $solicitante->getDni(); ?>">		

		<div class="form-group">
		    <label for="nombres">Nombres:</label>
		    <input type="text" class="form-control" id="nombres" name="nombres" required="true" value='<?php echo utf8_decode($solicitante->getNombres()); ?>' autocomplete="off">
		</div>
		<div class="form-group">
		    <label for="nombres">Apellidos:</label>
		    <input type="text" class="form-control" id="apellidos" name="apellidos" required="true" value='<?php echo utf8_decode($solicitante->getApellidos()); ?>' autocomplete="off">
		</div>

		<div class="form-group">
		    <label for="email">Email:</label>
		    <input type="email" class="form-control" id="email" name="email" required="true" value='<?php echo $solicitante->getEmail(); ?>'>
		</div>
		<div class="form-group">
	    	<label for="curso">Curso:</label>
	     	<input type="number" class="form-control" id="curso" name="curso" required="true" value="<?php echo $solicitante->getCurso(); ?>" >
		</div>

		 <div class="row">
		 	<div class="col-sm-2">
		 	    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"> </span> Guardar</button>
	      </div>
		 	<div class="col-sm-2">
		 	    <button type="button" class="btn btn-danger" onclick="location.href='?controller=solicitante&action=show'"><span class="glyphicon glyphicon-hand-left"></span> Cancelar</button>
		 	</div> 
		 </div>		
	</form>
</div>
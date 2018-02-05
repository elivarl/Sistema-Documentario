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
		    <input type="text" class="form-control" id="apellidos" name="apellidos" required="true" value='<?php echo $solicitante->getApellidos(); ?>' autocomplete="off">
		</div>

		<div class="form-group">
		    <label for="email">Email:</label>
		    <input type="email" class="form-control" id="email" name="email" required="true" value='<?php echo $solicitante->getEmail(); ?>'>
		</div>
		<div class="form-group">
      		<label class="control-label" for="programa">Programa:</label>
		      <select class="form-control" id="programa" name="programa">
		      	<option value="<?php echo $solicitante->getPrograma(); ?>">
		      	<?php //echo $solicitante->getPrograma();
							if ($solicitante->getPrograma()=='PR') {?>
								Programa Regular
							<?php } elseif ($solicitante->getPrograma()=='PD') {?>
								Profesionalización Docente
							<?php } else{?>
								Otros
							<?php } ?>
				</option>
		        <option value="PR">Programa Regular</option>
		        <option value="PD">Profesionalización Docente</option>
		        <option value="O">Otros</option>
		      </select> 
    	</div>

		<div class="form-group">
      		<label class="control-label" for="carrera">Carrera:</label>
		      <select class="form-control" id="carrera" name="carrera">
		      	<option value="<?php echo $solicitante->getCarrera(); ?>">
		      	<?php //echo $solicitante->getCarrera();
							if ($solicitante->getCarrera()=='EI') {?>	
								Educación Inicial
							<?php } elseif ($solicitante->getCarrera()=='EIB') {?>
								Educación Inicial EIB
							<?php } elseif ($solicitante->getCarrera()=='EP') {?>
								Educación Primaria
							<?php } elseif ($solicitante->getCarrera()=='EPEIB') {?>
								Educación Primaria EIB
							<?php } elseif ($solicitante->getCarrera()=='EF') {?>
								Educación Física
							<?php } elseif ($solicitante->getCarrera()=='M') {?>
								Matemática
							<?php } elseif ($solicitante->getCarrera()=='CI') {?>
								Computación e Informática 
							<?php } else{?>
								Otros
							<?php } ?>
				</option>
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
	     	<input type="number" class="form-control" id="curso" name="curso" required="true" value="<?php echo $solicitante->getCurso(); ?>" >
		</div>
		<div class="form-group">
			<label for="direccion">Dirección:</label>
		    <input type="text" class="form-control" id="direccion" name="direccion" required="true" value='<?php echo $solicitante->getDireccion(); ?>'autocomplete="off">
		</div>
		<div class="form-group">
			<label for="telefono">Teléfono:</label>
		    <input type="text" class="form-control" id="telefono" name="telefono" required="true" value='<?php echo $solicitante->getTelefono(); ?>'autocomplete="off">
		</div>
		<div class="checkbox">
		    <label><input type="checkbox" name="inactivo" <?php echo $solicitante->getInactivo(); ?> >Activo</label>
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
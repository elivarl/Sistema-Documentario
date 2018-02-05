<div class="container">
	<h2>Cambio de contraseña de Usuario</h2>
	  <form action='?controller=usuario&action=savePas' method='post'>
		<div class="form-group">
		    <label for="pwd">Contraseña</label>
		    <input type="hidden" class="form-control" id="id" name="id" required="true" value="<?php echo $usuario->getId();?>" autocomplete="off">
		    <input type="password" class="form-control" id="pwd" name="pwd" required="true" placeholder="Ingrese su nueva contraseña">
		    
		</div>

		<div class="col-sm-2">
		    <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar</button>
      </div>
      
	</form>
</div>
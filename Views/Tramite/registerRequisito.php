<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>

<div class="container">
	<h2>Registro de Requisitos</h2>
	<form class="form-horizontal" action='?controller=tramite&action=saveRequisito' method='post'>
    <div class="form-group">
      <label class="control-label col-sm-2" for="nombres">Nombre Requisito:</label>
      <div class="col-sm-10"> 
      <input type="hidden" name="idTramite" value="<?php echo $idTramite; ?>">         
        <input type="text" class="form-control" id="nombres" name="nombre" placeholder="Ingrese el nombre del Requisito" required="true" autocomplete="off">
      </div>
    </div>    

    <div class="row">
      <div class="col-sm-2">

      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar</button>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-danger" onclick="location.href='?controller=tramite&action=showRequisito'"><span class="glyphicon glyphicon-hand-left"></span> Cancelar</button>
      </div>      
    </div>

  </form>
</div>
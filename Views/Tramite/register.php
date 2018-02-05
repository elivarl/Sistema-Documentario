<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>

<div class="container">
	<h2>Registro de Trámites</h2>
	<form class="form-horizontal" action='?controller=tramite&action=save' method='post'>
    <div class="form-group">
      <label class="control-label" for="nombres">Nombre Trámite:</label>
        <input type="text" class="form-control" id="nombres" name="nombre" placeholder="Ingrese el nombre del trámite" required="true" autocomplete="off">
    </div>    
    <div class="form-group">
      <label class="control-label" for="nombres">Precio Trámite:</label>
        <input type="number" class="form-control" id="precio" step="0.1" name="precio" placeholder="Ingrese el precio del trámite" required="true" autocomplete="off">
    </div> 
    <div class="checkbox">
        <label><input type="checkbox" name="inactivo" >Activo</label>
    </div> 

    <div class="row">
      <div class="col-sm-2">

      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar</button>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-danger" onclick="location.href='?controller=tramite&action=show'"><span class="glyphicon glyphicon-hand-left"></span> Cancelar</button>
      </div>      
    </div>

  </form>
</div>
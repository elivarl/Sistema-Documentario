<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>

<div class="container">
  <h2>Actualizar de Áreas</h2>
  <form class="form-horizontal" action='?controller=area&action=update' method='post'>
      <div class="form-group">
          <label for="alias">Código:</label>        
          <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $area->getCodigo();?>" required="true" autocomplete="off">
      </div>
       <div class="form-group">
        <label for="alias">Nombre Área:</label> 
      <input type="hidden" name="id" value="<?php echo $area->getId(); ?>">          
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $area->getNombre();?>" required="true" autocomplete="off">
      </div>
    <div class="checkbox">
        <label><input type="checkbox" name="inactivo" <?php echo $area->getInactivo(); ?> >Activo</label>
     </div>    

    <div class="row">
      <div class="col-sm-2">

      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-save"></span> Guardar</button>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-danger" onclick="location.href='?controller=area&action=show'"><span class="glyphicon glyphicon-hand-left"></span> Cancelar</button>
      </div>      
    </div>

  </form>
</div>

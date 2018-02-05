<?php if(!isset($_SESSION)) 
    { 
        session_start();   

    } ?>
<h1>Lista de Requisitos</h1>
  <form class="form-inline" action="?controller=tramite&action=buscar" method="post">
  <div class="form-group row">
    <div class="col-xs-4">
      <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Por ej. Secretaria">
    </div>
  </div>
  <div class="form-group row">
   <div class="col-xs-4">
      <button type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search"> </span> Buscar</button>
    </div>
    </div>    
  </form>

    <?php if (isset($_SESSION['mensaje'])) { //mensaje, cuando realiza alguna acción crud ?>
      <div class="alert alert-success">
        <strong><?php echo $_SESSION['mensaje']; ?></strong>
      </div>
    <?php } 
      unset($_SESSION['mensaje']);
    ?>
<div class="container">
<button type="submit" class="btn btn-success" onclick="location.href='?controller=tramite&action=registerRequisito&idTramite=<?php echo $_SESSION['tramite']?>'" > </span> Nuevo</button>        
  <div class="table-responsive">
    <table class="table table-hover">    
      <thead>
        <tr>
          <th>Nombre del Requisito</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php
        foreach ($lista_requisitos as $requisito)  {?>
        <tr>
          <td><?php echo $requisito->getNombre(); ?></td>
          <td> <button type="button" class="btn btn-primary" onclick="location.href='?controller=tramite&action=showUpdateRequisito&id=<?php echo $requisito->getId()?>'"><span class="glyphicon glyphicon-edit"> </span> Actualizar</button></td>
          <td><button type="button" class="btn btn-danger" onclick="location.href='?controller=tramite&action=deleteRequisito&id=<?php echo $requisito->getId()?>'"><span class=" glyphicon glyphicon-trash"></span> Eliminar</button></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <ul class ="pagination">    
      <?php for ($i=1;$i<=$botones;$i++){ ?>
        <li><a href="?controller=tramite&action=showRequisitos&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
      <?php }?>     
    </ul>
  </div>
</div>
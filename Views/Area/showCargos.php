<?php if(!isset($_SESSION)) 
    { 
        session_start();   

    } ?>
<h1>Lista de Cargos</h1>
  <form class="form-inline" action="?controller=area&action=buscarCargo" method="post">
  <div class="form-group row">
    <div class="col-xs-4">
      <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Por ej. Secretaria">
      <input id="idArea" name="idArea" type="hidden" value="<?php echo $_SESSION['area']; ?>">
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
<button type="submit" class="btn btn-success" onclick="location.href='?controller=area&action=registerCargo&idArea=<?php echo $_SESSION['area']?>'" > </span> Nuevo</button>        
  <div class="table-responsive">
    <table class="table table-hover">    
      <thead>
        <tr>
          <th>Nombre del Cargo</th>
          <th>Estado</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php
        foreach ($lista_cargos as $cargo)  {?>
        <tr>
          <td><?php echo $cargo->getNombre(); ?></td>
          <td><?php if(strcmp($cargo->getInactivo(),"checked")==0):  echo "Activo"?>
            <?php else: 
            echo "Inactivo"?>
          <?php endif ?></td>
          <td> <button type="button" class="btn btn-primary" onclick="location.href='?controller=area&action=showUpdateCargo&id=<?php echo $cargo->getId()?>'"><span class="glyphicon glyphicon-edit"> </span> Actualizar</button></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <ul class ="pagination">    
      <?php for ($i=1;$i<=$botones;$i++){ ?>
        <li><a href="?controller=area&action=showCargos&boton=<?php echo $i ?>"><?php echo $i; ?></a></li>
      <?php }?>     
    </ul>
  </div>
</div>
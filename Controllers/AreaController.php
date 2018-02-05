<?php 
/**
* Controlador AreController, para administrar las areas
* Fecha: 30-10-2017
*/
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
class AreaController
{	
	public function __construct(){}

	public function show(){
		//echo 'index desde AreaController';

		if (!isset($_SESSION['area'])) {//mata la sesion (id del área)si está algun valor 
			unset($_SESSION['area']);
		}
		
			
		$areas=Area::all();
		$lista_areas=array();
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($areas)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($areas)%$registros)==0) {
				$botones=count($areas)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($areas)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_areas[]=$areas[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($areas)) {
						$lista_areas[]=$areas[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_areas=$areas;
		}
		require_once('Views/Area/show.php');
	}
	public function register(){
		//echo getcwd ();
		require_once('Views/Area/register.php');
	}

	//guardar
	public function save(){
		$areas=[];
		$areas=Area::all();
		$existe=False;
		//var_dump($existe);
		//	die();
		//recorre todos los nombres de areas
		foreach ($areas as $area) {
			//compara si el nombre de la caja de texto ya está guardado
			if (strcmp($area->getCodigo(),$_POST['codigo'])==0) {
				$existe=True;
			}
		}			

		if (!$existe) {
			if (!isset($_POST['inactivo'])) {
				$inactivo="of";
			}else{
				$inactivo="on";
			}
			$area= new Area(null,$_POST['nombre'],$_POST['codigo'],$inactivo);
			Area::save($area);
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			$this->show();
		}else{
			$_SESSION['mensaje']='El código de área ya existe ya existe';
			header('Location: index.php');
		}	
	}

	//muestra la página update.php para el área con su registro a modificar
	public function showupdate(){
		$id=$_GET['id'];
		$area=Area::getById($id);
		require_once('Views/Area/update.php');
	}
	//llama al modelo, al método update para actualizar
	public function update(){
		if (!isset($_POST['inactivo'])) {
			$inactivo="of";
		}else{
			$inactivo="on";
		}
		$area= new Area($_POST['id'],$_POST['nombre'],$_POST['codigo'],$inactivo);

		//var_dump($area);
		//die();
		Area::update($area);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		$this->show();
	}

	public function delete(){
		Area::delete($_GET['id']);
		$_SESSION['mensaje']='Registro eliminado satisfactoriamente';
		$this->show();
	}
	
	//operaciones CRUD para el cargo
	public function registerCargo(){
		//echo getcwd ();
		$idArea=$_GET['idArea'];
		require_once('Views/Area/registerCargo.php');
	}

	//guardar Cargo
	public function saveCargo(){
		$cargos=[];
		$cargos=Cargo::allByIdArea($_POST['idArea']);
		$existe=False;
		//var_dump($existe);
		//	die();
		//recorre todos los nombres de los cargos
		foreach ($cargos as $cargo) {
			//compara si el nombre de la caja de texto ya está guardado
			if (strcmp($cargo->getNombre(),$_POST['nombre'])==0) {
				$existe=True;
			}
		}			

		if (!$existe) {
			$cargo= new Cargo(null,$_POST['nombre'],$_POST['inactivo'],$_POST['idArea'] );
			Cargo::save($cargo);
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			
			$this->showCargos();
		}else{
			$_SESSION['mensaje']='El nombre ya existen';
			$this->showCargos();
		}	
	}

	//muestra la página updateCargo.php para el área con su registro a modificar (Cargo)
	public function showUpdateCargo(){
		$id=$_GET['id'];
		$cargo=Cargo::getById($id);
		require_once('Views/Area/updateCargo.php');
	}
	//llama al modelo, al método update para actualizar
	public function updateCargo(){
		if (!isset($_POST['inactivo'])) {
			$inactivo="of";
		}else{
			$inactivo="on";
		}
		$cargo= new Cargo($_POST['id'],$_POST['nombre'],$inactivo,$_POST['idArea']);

		//var_dump($area);
		//die();
		Cargo::update($cargo);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		$this->showCargos();
	}


	//mostrar Cargos
	public function showCargos(){
		$cargos=[];
		if (isset($_GET['idArea'])) {//ingresa si la variable de sessión  no está null
			$_SESSION['area']=$_GET['idArea'];
		} 		
		
		
		$cargos=Cargo::allByIdArea($_SESSION['area']);
		$lista_cargos="";
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($cargos)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($cargos)%$registros)==0) {
				$botones=count($cargos)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($cargos)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_cargos[]=$cargos[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($cargos)) {
						$lista_cargos[]=$cargos[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_cargos=$cargos;
		}
		require_once('Views/Area/showCargos.php');

	}

	//mostrar Cargo
	public function deleteCargo(){
		Cargo::delete($_GET['id']);
		require_once('Views/Area/showCargos.php');

	}

	//muestra una areas por codigo
	public function buscar(){
		// si el campo numero no es vació
		if (!empty($_POST['codigo'])) {
			$lista_areas[]=Area::getByCodigo($_POST['codigo']);
			$botones=0;			
			require_once('Views/Area/show.php');
		}else{//si está vacía trae todos los registros
			$this->show();
		}		
	}

	//muestra una cargos  por nombre
	public function buscarCargo(){
		// si el campo numero no es vació
		if (!empty($_POST['nombre'])) {
			$lista_cargos[]=Cargo::getByNombre($_POST['nombre'], $_POST['idArea']);
			$botones=0;			
			require_once('Views/Area/showCargos.php');
		}else{//si está vacía trae todos los registros
			$this->showCargos();
		}		
	}

}
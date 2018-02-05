<?php 
/**
* Controlador AreController, para administrar los usuarios
* Fecha: 30-10-2017
*/
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
class TramiteController
{	
	public function __construct(){}

	public function show(){
		//echo 'index desde AreaController';

		if (!isset($_SESSION['area'])) {//mata la sesion (id del área)si está algun valor 
			unset($_SESSION['area']);
		}
		
			
		$tramites=Tramite::all();
		$lista_tramites=array();
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($tramites)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($tramites)%$registros)==0) {
				$botones=count($tramites)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($tramites)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_tramites[]=$tramites[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($tramites)) {
						$lista_tramites[]=$tramites[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_tramites=$tramites;
		}
		require_once('Views/Tramite/show.php');
	}
	public function register(){
		//echo getcwd ();
		require_once('Views/Tramite/register.php');
	}

	//guardar
	public function save(){
		$tramites=[];
		$tramites=Tramite::all();
		$existe=False;
		//var_dump($existe);
		//	die();
		//recorre todos los nombres de areas
		foreach ($tramites as $tramite) {
			//compara si el nombre de la caja de texto ya está guardado
			if (strcmp($tramite->getNombre(),$_POST['nombre'])==0) {
				$existe=True;
			}
		}			

		if (!$existe) {
			if (!isset($_POST['inactivo'])) {
				$inactivo="of";
			}else{
				$inactivo="on";
			}
			$tramite= new Tramite(null,$_POST['nombre'],$_POST['precio'], $inactivo);
			Tramite::save($tramite);
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			$this->show();
		}else{
			$_SESSION['mensaje']='El nombre ya existen';
			header('Location: index.php');
		}	
	}

	//muestra la página update.php para el área con su registro a modificar
	public function showupdate(){
		$id=$_GET['id'];
		$tramite=Tramite::getById($id);
		require_once('Views/Tramite/update.php');
	}
	//llama al modelo, al método update para actualizar
	public function update(){
		if (!isset($_POST['inactivo'])) {
				$inactivo="of";
			}else{
				$inactivo="on";
			}
		$tramite= new Tramite($_POST['id'],$_POST['nombre'],$_POST['precio'],$inactivo);

		//var_dump($area);
		//die();
		Tramite::update($tramite);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		$this->show();
	}

	public function delete(){
		Tramite::delete($_GET['id']);
		$_SESSION['mensaje']='Registro eliminado satisfactoriamente';
		$this->show();
	}
	
	//operaciones CRUD para el requisito
	public function registerRequisito(){
		//echo getcwd ();
		$idTramite=$_GET['idTramite'];
		require_once('Views/Tramite/registerRequisito.php');
	}

	//guardar requisito
	public function saveRequisito(){
		$requisitos=[];
		$requisitos=Requisito::allByIdTramite($_POST['idTramite']);
		$existe=False;
		//var_dump($existe);
		//	die();
		//recorre todos los nombres de los requisito
		foreach ($requisitos as $requisito) {
			//compara si el nombre de la caja de texto ya está guardado
			if (strcmp($requisito->getNombre(),$_POST['nombre'])==0) {
				$existe=True;
			}
		}			

		if (!$existe) {
			$requisito= new Requisito(null,$_POST['nombre'],$_POST['idTramite'] );
			Requisito::save($requisito);
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			
			$this->showRequisito();
		}else{
			$_SESSION['mensaje']='El nombre ya existen';
			$this->showRequisito();
		}	
	}

	//muestra la página updateCargo.php para el área con su registro a modificar (Cargo)
	public function showUpdateRequisito(){
		$id=$_GET['id'];
		$requisito=Requisito::getById($id);
		require_once('Views/Tramite/updateRequisito.php');
	}
	//llama al modelo, al método update para actualizar
	public function updateRequisito(){
		$requisito= new Requisito($_POST['id'],$_POST['nombre'],$_POST['idTramite']);

		//var_dump($area);
		//die();
		Requisito::update($requisito);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		$this->showRequisito();
	}


	//mostrar Requistisitos
	public function showRequisito(){
		$requisitos=[];
		if (isset($_GET['idTramite'])) {//ingresa si la variable de sessión  no está null
			$_SESSION['tramite']=$_GET['idTramite'];
		} 		
		
		$requisitos=Requisito::allByIdTramite($_SESSION['tramite']);
		$lista_requisitos="";
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($requisitos)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($requisitos)%$registros)==0) {
				$botones=count($cargos)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($requisitos)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_requisitos[]=$requisitos[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($requisitos)) {
						$lista_requisitos[]=$requisitos[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_requisitos=$requisitos;
		}
		require_once('Views/Tramite/showRequisito.php');

	}

	//mostrar Cargo
	public function deleteRequisito(){
		Requisito::delete($_GET['id']);
		$this->showRequisito();

	}

	//muestra una cargos  por nombre
	public function buscar(){
		// si el campo numero no es vació
		if (!empty($_POST['nombre'])) {
			$lista_tramites[]=Tramite::getByNombre($_POST['nombre']);
			$botones=0;			
			require_once('Views/Tramite/show.php');
		}else{//si está vacía trae todos los registros
			$this->show();
		}		
	}


}
<?php 
/**
* Controlador SolicitanteController, para administrar los solicitantes
* Fecha: 30-10-2017
*/
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
class SolicitanteController
{	
	public function __construct(){}

	public function show(){			
		$solicitantes=Solicitante::all();
		$lista_solicitantes=array();
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($solicitantes)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($solicitantes)%$registros)==0) {
				$botones=count($solicitantes)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($solicitantes)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_solicitantes[]=$solicitantes[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($solicitantes)) {
						$lista_solicitantes[]=$solicitantes[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_solicitantes=$solicitantes;
		}
		require_once('Views/Solicitante/show.php');
	}
	public function register(){
		//echo getcwd ();
		require_once('Views/Solicitante/register.php');
	}

	//guardar
	public function save(){
		$solicitantes=[];
		$solicitantes=Solicitante::all();
		$existe=False;
		//var_dump($existe);
		//	die();
		//recorre todos los nombres de areas
		foreach ($solicitantes as $solicitante) {
			//compara si el nombre de la caja de texto ya está guardado
			if (strcmp($solicitante->getDni(),$_POST['dni'])==0) {
				$existe=True;
			}
		}			

		if (!$existe) {
			if (!isset($_POST['inactivo'])) {
				$inactivo="of";
			}else{
				$inactivo="on";
			}
			$solicitante= new Solicitante(null,$_POST['dni'], $_POST['nombres'],$_POST['apellidos'],$_POST['email'], $inactivo,$_POST['curso'],$_POST['programa'],$_POST['direccion'],$_POST['telefono'],$_POST['carrera']);
			Solicitante::save($solicitante);
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			$this->show();
		}else{
			$_SESSION['mensaje']='El registro ya existen';
			$this->show();
		}	
	}

	//muestra la página update.php para el área con su registro a modificar
	public function showupdate(){
		$id=$_GET['id'];
		$solicitante=Solicitante::getById($id);
		require_once('Views/Solicitante/update.php');
	}
	//llama al modelo, al método update para actualizar
	public function update(){
		if (!isset($_POST['inactivo'])) {
				$inactivo="of";
			}else{
				$inactivo="on";
			}
		$solicitante= new Solicitante($_POST['id'],$_POST['dni'], $_POST['nombres'],$_POST['apellidos'],$_POST['email'], $inactivo,$_POST['curso'],$_POST['programa'],$_POST['direccion'],$_POST['telefono'],$_POST['carrera']);

		//var_dump($area);
		//die();
		Solicitante::update($solicitante);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		$this->show();
	}

	public function delete(){
		Solicitante::delete($_GET['id']);
		$_SESSION['mensaje']='Registro eliminado satisfactoriamente';
		$this->show();
	}

	//muestra un usuario por dni
	public function buscar(){
		// si el campo numero no es vació
		if (!empty($_POST['dni'])) {
			$lista_solicitantes[]=Solicitante::getByDni($_POST['dni']);
			$botones=0;			
			require_once('Views/Solicitante/show.php');
		}else{//si está vacía trae todos los registros
			$this->show();
		}		
	}
}
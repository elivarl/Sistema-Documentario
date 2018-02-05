<?php 
/**
* Controlador SolicitanteController, para administrar los solicitantes
* Fecha: 30-10-2017
*/
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
class ExpedienteController
{	
	public function __construct(){}

	public function show(){			
		$expedientes=Expediente::all();
		$tramites=Tramite::all();
		$lista_expedientes=array();
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($expedientes)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($expedientes)%$registros)==0) {
				$botones=count($expedientes)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($expedientes)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_expedientes[]=$expedientes[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($expedientes)) {
						$lista_expedientes[]=$expedientes[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_expedientes=$expedientes;
		}
		require_once('Views/Expediente/show.php');
	}
	public function register(){
		//echo getcwd ();
		//solicitantes
		//$solicitantes=Solicitante::allActive();
		$lista_solicitantes=array();

		//genera numero expediente
		$numeroExpediente=$this->generarNumero();

		//trámites
		$tramites=Tramite::allActive();

		//áreas a asignar(menos mesa de partes)
		$areas=Area::allWhithout();


		require_once('Views/Expediente/register.php');
	}

	//guardar
	public function save(){
		$expedientes=[];
		$expedientes=Expediente::all();
		$existe=False;
		//var_dump($existe);
		//	die();
		//recorre todos los nombres de expediente
		foreach ($expedientes as $expediente) {
			//compara si el nombre de la caja de texto ya está guardado
			if (strcmp($expediente->getTramites_id(),$_POST['numero'])==0) {
				$existe=True;
			}
		}		
		if (!$existe) {
			$cargo=Cargo::getById($_SESSION['cargos_id']);
			$area=Area::getById($cargo->getAreas_id());
			$solicitante=Solicitante::getByDni($_POST['dni']);
			//var_dump($solicitante);
			//die();
			$expediente= new Expediente(null,$_POST['numero'], $_POST['fecha_registro'], NULL, "E", $_POST['tramites_id'], $area->getId(), $solicitante->getId(), $_SESSION['cargos_id']);
			Expediente::save($expediente);
			$id_expediente=Expediente::getMaxId();
			//inicia el seguimiento
			$seguimiento= new Seguimiento(NULL,$area->getId(),$_POST['area_recibe_id'],$_POST['fecha_registro'],"E",1,$id_expediente);
			Seguimiento::save($seguimiento);
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			$this->show();
		}else{
			$_SESSION['mensaje']='El registro ya existen';
			$this->show();
		}	
	}

	public function delete(){
		Expediente::delete($_GET['id']);
		$_SESSION['mensaje']='Registro eliminado satisfactoriamente';
		$this->show();
	}

	public function showSeguimiento(){
		$expediente=Expediente::getById($_GET['idSeguimiento']);
		$seguimientos=Seguimiento::allByIdExpediente($_GET['idSeguimiento']);
		$areas=Area::all();	
		require_once('Views/Expediente/showSeguimiento.php');
	}
	//muestra la pantalla para tramitar el expediente por parte de dirección academica
	public function tramitar(){
		
		$cargo=Cargo::getById($_SESSION['cargos_id']);
		$area=Area::getById($cargo->getAreas_id());

		//var_dump($area->getCodigo());
		//die();
		if ($area->getCodigo()=='DG01') {
			$expedientes=Expediente::allEnviado();
		} else {
			$expedientes=Expediente::allDerivado();
		}
		


		$tramites=Tramite::all();
		$lista_expedientes="";
		$registros=Paginacion::REGISTROS; // debe ser siempre par
		if (count($expedientes)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($expedientes)%$registros)==0) {
				$botones=count($expedientes)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($expedientes)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_expedientes[]=$expedientes[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($expedientes)) {
						$lista_expedientes[]=$expedientes[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_expedientes=$expedientes;
		}
		require_once('Views/Expediente/tramitar.php');
	}

	public function showDocumento(){
		header('Location: Controllers/ExpedientePdf.php?idSeguimiento='.$_GET['idSeguimiento']);	
	}

	//muestra la pantalla para derivar el expediente a otra área
	public function derivarShow(){
		$areas=Area::allDerivar();

		$expediente=Expediente::getById($_GET['idExpediente']);
		$tramite=Tramite::getById($expediente->getTramites_id());
		$solicitante=Solicitante::getById($expediente->getSolicitantes_id());
		require_once('Views/Expediente/derivar.php');
	}

	//registra cuando un expediente ha sido derivado
	public function derivar(){
		$cargo=Cargo::getById($_SESSION['cargos_id']);
		$area=Area::getById($cargo->getAreas_id());
		$estado="D";
		//inicia el seguimiento
		$seguimiento= new Seguimiento(NULL,$area->getId(),$_POST['area_recibe_id'],$_POST['fecha_envio'],$estado,1,$_POST['id']);
		$expediente=new Expediente($_POST['id'],NULL,NULL,$_POST['fecha_envio'],$estado,NULL,NULL,NULL,NULL);
		
		Seguimiento::save($seguimiento);
		Expediente::update($expediente);
		$_SESSION['mensaje']='Registro guardado satisfactoriamente';
		$this->tramitar();
	}
	//muestra la pantalla para atender el expediente
	public function atenderShow(){
		//$areas=Area::allDerivar();
		$expediente=Expediente::getById($_GET['idExpediente']);
		$tramite=Tramite::getById($expediente->getTramites_id());
		$solicitante=Solicitante::getById($expediente->getSolicitantes_id());
		require_once('Views/Expediente/atender.php');
	}
	//registra cuando un expediente ha sido atendido
	public function atender(){
		$cargo=Cargo::getById($_SESSION['cargos_id']);
		$area=Area::getById($cargo->getAreas_id());
		$estado="A";
		//inicia el seguimiento
		$seguimiento= new Seguimiento(NULL,$area->getId(),$area->getId(),$_POST['fecha_atencion'],$estado,1,$_POST['id']);
		$expediente=new Expediente($_POST['id'],NULL,NULL,$_POST['fecha_atencion'],$estado,NULL,NULL,NULL,NULL);
		Seguimiento::save($seguimiento);
		Expediente::update($expediente);
		$_SESSION['mensaje']='Registro guardado satisfactoriamente';
		$this->tramitar();
	}

	

	/**Utilidades**/
	public function generarNumero(){
		$numero=Expediente::getMaxId();
		$numero = (NULL) ? $numero : $numero+1 ;
		if ($numero<10) {
			$numero= "000".$numero;
		} elseif($numero>=10&&$numero<99) {
			$numero="00".$numero;
		}elseif ($numero>=100&&$numero<999) {
			$numero="0".$numero;
		}elseif ($numero>=1000&&$numero<9999) {
			$numero=$numero;
		}		
		return $numero;
	}

	//muestra un expediente por numero
	public function buscar(){
		// si el campo numero no es vació
		if (!empty($_POST['numero'])) {
			$tramites=Tramite::all();
			$lista_expedientes[]=Expediente::getByNumero($_POST['numero']);
			$botones=0;			
			require_once('Views/Expediente/show.php');
		}else{//si está vacía trae todos los registros
			$this->show();
		}		
	}
}
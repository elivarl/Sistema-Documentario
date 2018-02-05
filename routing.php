<?php

	require_once('Models/Area.php');
	require_once('Models/Cargo.php');
	require_once('Models/Paginacion.php');

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	//función que llama al controlador y su respectiva acción, que son pasados como parámetros
	function call($controller, $action){
		//importa el controlador desde la carpeta Controllers
		require_once('Controllers/' . $controller . 'Controller.php');
		//crea el controlador

		switch($controller){
			case 'usuario':
				require_once('Models/Area.php');
				require_once('Models/Cargo.php');
				require_once('Models/Usuario.php');
				require_once('Models/Expediente.php');
				require_once('Models/Tramite.php');
				$controller= new UsuarioController();
				break; 
			case 'area':
				require_once('Models/Area.php');
				require_once('Models/Cargo.php');
				$controller= new AreaController();
				break;
			case 'tramite':
				require_once('Models/Tramite.php');
				require_once('Models/Requisito.php');
				$controller= new TramiteController();
				break;
			case 'solicitante':
				require_once('Models/Solicitante.php');
				$controller= new SolicitanteController();
				break;
			case 'expediente':				
				require_once('Models/Cargo.php');
				require_once('Models/Area.php');
				require_once('Models/Tramite.php');
				require_once('Models/Solicitante.php');
				require_once('Models/Expediente.php');
				require_once('Models/Seguimiento.php');
				$controller= new ExpedienteController();
				break;
		}
		//llama a la acción del controlador
		$controller->{$action }();
	}


	//array con los controladores y sus respectivas acciones
	$controllers= array(
						'usuario'=>['show','register','save','showregister', 'updateAdmin', 'delete', 'showLogin','login','logout','error', 'welcome','registerUser','saveUser','showUser','showupdate','updateUser','registerFoto','updatePas', 'savePas','buscar','consulta','consultar_exp'],

						'area'=>['register','save', 'show', 'showupdate','update', 'delete','buscar','registerCargo','saveCargo','updateCargo', 'deleteCargo','showCargos','showUpdateCargo','deleteCargo','buscarCargo'],

						'tramite'=>['register','save', 'show', 'showupdate','update', 'delete','buscar', 'registerRequisito','saveRequisito','updateRequisito', 'deleteRequisito','showRequisito','showUpdateRequisito'],

						'solicitante'=>['show','register','save','showupdate', 'update','delete','error','validarDni','buscar'],

						'expediente'=>['show','register','save', 'update','delete','error','showSeguimiento','showDocumento','tramitar','derivarShow','derivar','atenderShow','atender','buscar'],

						'consulta'=>['register','save','show', 'showupdate','update','recetaPdf','buscar']
						);
	//verifica que el controlador enviado desde index.php esté dentro del arreglo controllers
	if (array_key_exists($controller, $controllers)) {

		//verifica que el arreglo controllers con la clave que es la variable controller del index exista la acción
		if (in_array($action, $controllers[$controller])) {
			//llama  la función call y le pasa el controlador a llamar y la acción (método) que está dentro del controlador
			if (isset($_SESSION['usuario'])){//ingresa sólo cuando el usuario tiene sesión abierta
				if (strcmp($_SESSION['usuario_tipo'],'A')==0) {
					call($controller, $action);
				} elseif(strcmp($_SESSION['usuario_tipo'],'U')==0) {
					//&&( $controller=='expediente'&&($action=='tramitar'||$action=='atender'&&$action=='buscar'))
					$cargo=Cargo::getById($_SESSION['cargos_id']);
					$area=Area::getById($cargo->getAreas_id());
					//var_dump($area->getCodigo());
					//die();
					// usuario mesa de partes
					if (($area->getCodigo()=='MP')&&( ($controller=='expediente'&&($action=='register'||$action=='show'|| $action=='save'|| $action=='delete'|| $action=='showSeguimiento' || $action=='showDocumento'|| $action=='buscar')) ||  ($controller=='usuario'&&($action=='logout' || $action=='welcome'|| $action=='registerFoto'|| $action=='showregister'|| $action=='updateUser'|| $action=='updatePas'|| $action=='savePas'))  

						||  ($controller=='tramite'&&($action=='register' || $action=='save'|| $action=='show'|| $action=='showupdate'|| $action=='update'|| $action=='delete'|| $action=='buscar'|| $action=='registerRequisito'|| $action=='saveRequisito'|| $action=='updateRequisito'|| $action=='deleteRequisito'|| $action=='showRequisito'|| $action=='showUpdateRequisito'))

						||  ($controller=='solicitante'&&($action=='register' || $action=='save'|| $action=='show'|| $action=='showupdate'|| $action=='update'|| $action=='delete'|| $action=='buscar'|| $action=='error'))
					   )) {
						call($controller, $action);
						// usuario  direccion general
					}elseif (($area->getCodigo()=='DG01')&&( $controller=='expediente'&&($action=='tramitar'||$action=='derivarShow'|| $action=='derivar'|| $action=='atenderShow'|| $action=='atender' || $action=='buscar')) ||  ($controller=='usuario'&&($action=='logout' || $action=='welcome'|| $action=='registerFoto'|| $action=='showregister'|| $action=='updateUser'|| $action=='updatePas'|| $action=='savePas'))) {
						call($controller, $action);
						// otro usuario  (área})
					} elseif ( (!($area->getCodigo()=='MP' )&& !($area->getCodigo()=='DG01')) &&( $controller=='expediente'&&($action=='tramitar'|| $action=='atenderShow'|| $action=='atender' || $action=='buscar') ||  ($controller=='usuario'&&($action=='logout' || $action=='welcome'|| $action=='registerFoto'|| $action=='showregister'|| $action=='updateUser'|| $action=='updatePas'|| $action=='savePas')))) {
						call($controller, $action);
					} 
					else {
						call('usuario', 'error');
					}
				}else{
					call('usuario', 'error');
				}
			}
			elseif($controller=='usuario'&&($action=='showLogin'||$action=='login'||$action=='register'||$action=='save'|| $action=='consulta'|| $action=='consultar_exp')){// ingresa a páginas que no necesitam sesión de usuario
				call($controller, $action);
			}else{//página que indica que no hay permisos
				call($controller, 'error');			
			}
		}else{
			call('usuario', 'error');
		}
	}else{// le pasa el nombre del controlador y la pagina de error
		call('usuario', 'error');
	}
?>
<?php 
/**
* Controlador UsuarioController, para administrar los usuarios
* Sitio Web: wwww.ecodeup.com
* Fecha: 20-03-2017
*/
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
class UsuarioController
{	
	public function __construct(){}

	public function show(){
		//echo 'index desde UsuarioController';
			
		$usuario=Usuario::getById($_GET['id']);
		require_once('Views/User/show.php');
	}

	public function showUser(){	
		//áreas
		$areas=Area::allActive();

		//cargos
		$cargos=Cargo::all();

		$usuarios=Usuario::all();
		$lista_usuarios=array();
		$registros=Paginacion::REGISTROS; 
		if (count($usuarios)>$registros) { // solo página si el número de registros mostrados es menor que los registros de la bd
			if ((count($usuarios)%$registros)==0) {
				$botones=count($usuarios)/$registros;
			}else{//si el total de registros de la bd es impar			
				$botones=(count($usuarios)/$registros+1);
			}
			
			if (!isset($_GET['boton'])) {//la primera vez carga los registros del botón 1
				$res=$registros*1;
				for ($i=0; $i < $res ; $i++) { 
					$lista_usuarios[]=$usuarios[$i];
				}
			}else{
				//multiplica el número de botón por el número de registros mostrados
				$res=$registros*$_GET['boton'];
				//resta el valor mayor de registros a mostrar menos el número de registros mostrados
				for ($i=$res-$registros; $i < $res; $i++) { 
					if ($i<count($usuarios)) {
						$lista_usuarios[]=$usuarios[$i];
					}				
				}
			}
		}else{// si no se presenta el paginador
			$botones=0;
			$lista_usuarios=$usuarios;
		}
		require_once('Views/User/showUser.php');
	}
	//registro admin
	public function register(){
		//echo getcwd ();
		require_once('Views/User/register.php');
	}

	//registro de usuarios
	public function registerUser(){
		//echo getcwd ();
		//áreas
		$areas=Area::allActive();

		//cargos
		$cargos=Cargo::all();
		require_once('Views/User/registerUser.php');
	}

	//guardar
	public function save(){
		//Usuario::save($usuario);
		$usuarios=[];
		$usuarios=Usuario::allAll();
		$existe=False;
		//var_dump($existe);
		//	die();
		foreach ($usuarios as $usuario) {
			//echo $usuario->alias."<br>".$_POST['alias']."<br>".$usuario->email;
			if (strcmp($usuario->getAlias(),$_POST['alias'])==0 or strcmp($usuario->getEmail(),$_POST['email'])==0 or strcmp($usuario->getDni(),$_POST['dni'])==0 ) {
				$existe=True;
			}
		}	
		if (!isset($_POST['inactivo'])) {
			$inactivo="of";
		}else{
			$inactivo="on";
		}		

		if (!$existe) {
			$usuario= new Usuario(null,$_POST['dni'],$_POST['alias'], $_POST['nombres'],$_POST['apellidos'],$_POST['email'], $_POST['pwd'], $_POST['tipo'],$inactivo,null, $_POST['cargo_id']);
			Usuario::save($usuario);
			if ($usuario->getTipo()=='U') {
				header('Location: index.php');
			} else {
				$this->showLogin();
			}
			
			$_SESSION['mensaje']='Registro guardado satisfactoriamente';
			//$this->showLogin();
			//header('Location: index.php');
			//require_once('Views/Layouts/layout.php');*/
		}else{
			$_SESSION['mensaje']='El alias o correo o DNI para tu usuario ya está registrado';
			header('Location: index.php');
		}	
	}

	public function showregister(){
		$id=$_GET['id'];
		$usuario=Usuario::getById($id);
		require_once('Views/User/update.php');
		//Usuario::update($usuario);
		//header('Location: ../index.php');
	}

	public function showupdate(){
		//áreas
		$areas=Area::all();

		//cargos
		$cargos=Cargo::all();


		$id=$_GET['id'];
		$usuario=Usuario::getById($id);

		$cargo=Cargo::getById($usuario->getCargos_id());
		
		require_once('Views/User/updateUser.php');
		//Usuario::update($usuario);
		//header('Location: ../index.php');
	}

	public function updateAdmin(){
		$usuario= new Usuario($_POST['id'],NULL,$_POST['alias'],$_POST['nombres'],$_POST['apellidos'],NULL,NULL,NULL, NULL, NULL,NULL);

		//var_dump($usuario);
		//die();
		Usuario::updateAdmin($usuario);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		header('Location: index.php');
	}

	public function updateUser(){
		if (!isset($_POST['inactivo'])) {
			$inactivo="of";
		}else{
			$inactivo="on";
		}	
		$usuario= new Usuario($_POST['id'],$_POST['dni'],$_POST['alias'],$_POST['nombres'],$_POST['apellidos'],$_POST['email'],$_POST['pwd'],$_POST['tipo'],$inactivo,NULL, $_POST['cargo_id']);

		//var_dump($usuario);
		//die();
		Usuario::updateUser($usuario);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		$this->showUser();
	}
	public function updatePas(){
		$usuario=Usuario::getById($_SESSION['usuario_id']);
		require_once('Views/User/updatepas.php');
	}
	public function savePas(){
		$usuario=new Usuario($_POST['id'],NULL,NULL,NULL,NULL,NULL,$_POST['pwd'],NULL,NULL,NULL,NULL);
		Usuario::updatePass($usuario);
		$_SESSION['mensaje']='Registro actualizado satisfactoriamente';
		header('Location: index.php');
	}


	public function delete(){
		Usuario::delete($_GET['id']);
		$_SESSION['mensaje']='Registro eliminado satisfactoriamente';
		header('Location: index.php');
	}
		
	public function error(){
		require_once('Views/User/error.php');
	} 
	public function welcome(){
		require_once('Views/bienvenido.php');
	} 

	public function showLogin(){
		require_once('Views/User/login.php');
	}

	//función que valida el usuario esté registrado
	public function login(){
		$usuarios=[];
		$usuarios=Usuario::allAll();
		$existe=False;
		//var_dump($existe);
		//	die();
		foreach ($usuarios as $usuario) {
			if (password_verify($_POST['pwd'],$usuario->getClave()) && strcmp($usuario->getEmail(),$_POST['email'])==0) {
				$existe=True;
				$_SESSION['usuario_id']=$usuario->getId();
				$_SESSION['usuario_alias']=$usuario->getAlias();
				$_SESSION['cargos_id']=$usuario->getCargos_id();
				$_SESSION['usuario_tipo']=$usuario->getTipo();
				$_SESSION['usuario_imagen']=$usuario->getImagen();
				//var_dump($_SESSION['usuario_imagen']);
				//die();
			}
		}
		if ($existe) {
			$_SESSION['usuario']=True;//inicio de sesion de usuario				
			//require_once('Views/Layouts/layout.php');
			header('Location: index.php');
		}else{
			$_SESSION['mensaje']='Email o contraseña invalidos';
			header('Location: index.php');
		}
	}
	public function registerFoto(){
		require_once('Views/User/registerFoto.php');
	}


	public function logout() {
		unset($_SESSION['usuario']);
		unset($_SESSION['usuario_id']);
		unset($_SESSION['usuario_name']);
		unset($_SESSION['cargos_id']);
		header('Location: index.php');
	}

	//muestra un usuario por dni
	public function buscar(){
		// si el campo numero no es vació
		if (!empty($_POST['dni'])) {
			$lista_usuarios[]=Usuario::getByDni($_POST['dni']);
			$botones=0;
				//áreas
				$areas=Area::all();
				//cargos
				$cargos=Cargo::all();
			
			require_once('Views/User/showUser.php');
		}else{//si está vacía trae todos los registros
			$this->showUser();
		}		
	}


	//muestra un usuario por dni
	public function consulta(){
		$tramites=array();
		$expediente = new Expediente(null,null,null,null,null,null,null,null,null);
		require_once('Views/Expediente/consulta.php');
	}
	//muestra un usuario por dni
	public function consultar_exp(){
		$expediente = Expediente::getByNumero($_POST['numero']);
		$tramites=Tramite::all();
		require_once('Views/Expediente/consulta.php');
	}

    public function setError($newError)
    {
        $this->error = $newError;
        return $this;
    }
}
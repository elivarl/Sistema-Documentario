<?php 
/**
* Modelo para el acceso a la base de datos y funciones CRUD
* Autor: Elivar Largo
* Sitio Web: wwww.ecodeup.com
*/
class Usuario
{
	private $id;
	private $alias;
	private $dni;
	private $nombres;
	private $apellidos;
	private $email;
	private $clave;
	private $tipo;	
	private $inactivo;
	private $imagen;
	private $cargos_id;
	
	function __construct($id,$dni ,$alias, $nombres, $apellidos, $email,$clave, $tipo,$inactivo,$imagen,$cargos_id)
	{
		$this->setId($id);
		$this->setAlias($alias);
		$this->setDni($dni);
		$this->setNombres($nombres);
		$this->setApellidos($apellidos);
		$this->setEmail($email);
		$this->setClave($clave);
		$this->setTipo($tipo);
		$this->setInactivo($inactivo);
		$this->setImagen($imagen);
		$this->setCargos_id($cargos_id);
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getAlias(){
		return $this->alias;
	}

	public function setAlias($alias){
		$this->alias = $alias;
	}

	public function getDni(){
		return $this->dni;
	}

	public function setDni($dni){
		$this->dni = $dni;
	}

	public function getNombres(){
		return $this->nombres;
	}

	public function setNombres($nombres){
		$this->nombres = $nombres;
	}

	public function getApellidos(){
		return $this->apellidos;
	}

	public function setApellidos($apellidos){
		$this->apellidos = $apellidos;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getClave(){
		return $this->clave;
	}

	public function setClave($clave){
		$this->clave = $clave;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getInactivo(){
		return $this->inactivo;
	}
	//1=ON, 2=OFF
	public function setInactivo($inactivo){
		if ($inactivo=='on') {
			$this->inactivo = 1;
		}elseif ($inactivo==1) {
			$this->inactivo= 'checked';
		}elseif ($inactivo==2) {
			$this->inactivo = 'of';
		}else{
			$this->inactivo = 2;
		}
	}

	public function getImagen(){
		return $this->imagen;
	}

	public function setImagen($imagen){
		$this->imagen = $imagen;
	}

	public function getCargos_id(){
		return $this->cargos_id;
	}

	public function setCargos_id($cargos_id){
		$this->cargos_id = $cargos_id;
	}



	//operaciones CRUD

	//función para obtener solo los usuarios
	public static function all(){
		$listaUsuarios =[];
		$db=Db::getConnect();
		$tipo='U';//solo usuarios
		$sql=$db->prepare('SELECT * FROM usuarios WHERE tipo=:tipo order by id');
		$sql->bindValue('tipo',$tipo);
		$sql->execute();

		// carga en la $listaUsuarios cada registro desde la base de datos
		foreach ($sql->fetchAll() as $usuario) {
			$listaUsuarios[]= new Usuario($usuario['id'],$usuario['dni'],$usuario['alias'], $usuario['nombres'],$usuario['apellidos'],$usuario['email'], $usuario['clave'], $usuario['tipo'],$usuario['inactivo'], $usuario['imagen'], $usuario['cargos_id']);
		}
		return $listaUsuarios;
	}
	//función para obtener solo los usuarios
	public static function allAll(){
		$listaUsuarios =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM usuarios order by id');

		// carga en la $listaUsuarios cada registro desde la base de datos
		foreach ($sql->fetchAll() as $usuario) {
			$listaUsuarios[]= new Usuario($usuario['id'],$usuario['dni'],$usuario['alias'], $usuario['nombres'],$usuario['apellidos'],$usuario['email'], $usuario['clave'], $usuario['tipo'],$usuario['inactivo'], $usuario['imagen'], $usuario['cargos_id']);
		}
		return $listaUsuarios;
	}


	//la función para registrar un usuario
	public static function save($usuario){
		$db=Db::getConnect();
			
		$insert=$db->prepare('INSERT INTO USUARIOS VALUES(NULL,:dni,:alias,:nombres,:apellidos,:email,:clave, :tipo,:inactivo,:imagen,:cargos_id)');
		$insert->bindValue('dni',$usuario->getDni());
		$insert->bindValue('alias',$usuario->getAlias());
		$insert->bindValue('nombres',$usuario->getNombres());
		$insert->bindValue('apellidos',$usuario->getApellidos());
		$insert->bindValue('email',$usuario->getEmail());
		//encripta la clave
		$pass=password_hash($usuario->getClave(),PASSWORD_DEFAULT);
		
		$insert->bindValue('clave',$pass);
		$insert->bindValue('tipo',$usuario->getTipo());
		$insert->bindValue('inactivo',$usuario->getInactivo());
		$insert->bindValue('imagen',NULL);
		$insert->bindValue('cargos_id',$usuario->getCargos_id());
		//var_dump($usuario);
		//die();
		$insert->execute();
	}

	//la función para actualizar 
	public static function updateUser($usuario){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE usuarios SET nombres=:nombres, dni=:dni, apellidos=:apellidos,email=:email, clave=:clave, tipo=:tipo,inactivo=:inactivo, cargos_id=:cargos_id WHERE id=:id');
		$update->bindValue('id',$usuario->getId());
		$update->bindValue('dni',$usuario->getDni());		
		$update->bindValue('nombres',$usuario->getNombres());
		$update->bindValue('apellidos',$usuario->getApellidos());
		$update->bindValue('email',$usuario->getEmail());//encripta la clave
		if ( strcmp($usuario->getClave(),"")!=0) {
			$pass=password_hash($usuario->getClave(),PASSWORD_DEFAULT);
			$update->bindValue('clave',$pass);
		}else{
			$usuario1=Usuario::getById($usuario->getId());
			$update->bindValue('clave',$usuario1->getClave());
		} 		
		$update->bindValue('tipo',$usuario->getTipo());
		$update->bindValue('inactivo',$usuario->getInactivo());
		$update->bindValue('cargos_id',$usuario->getCargos_id());
		$update->execute();
	}

	//la función para actualizar el administrador
	public static function updateAdmin($usuario){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE usuarios SET alias=:alias, nombres=:nombres, apellidos=:apellidos WHERE id=:id');
		$update->bindValue('id',$usuario->getId());
		$update->bindValue('alias',$usuario->getAlias());		
		$update->bindValue('nombres',$usuario->getNombres());
		$update->bindValue('apellidos',$usuario->getApellidos());
		$update->execute();
	}

	//la función para actualizar 
	public static function updatePass($usuario){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE usuarios SET clave=:clave WHERE id=:id');
		$update->bindValue('id',$usuario->getId());
		//encripta la clave
		$pass=password_hash($usuario->getClave(),PASSWORD_DEFAULT);
		//var_dump($pass);
		//die();
		$update->bindValue('clave',$pass);
		$update->execute();
	}


	// la función para eliminar por el id
	public static function delete($id){
		$db=Db::getConnect();
		$delete=$db->prepare('DELETE FROM usuarios WHERE ID=:id');
		$delete->bindValue('id',$id);
		$delete->execute();
	}

	//la función para obtener un usuario por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM usuarios WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto usuario
		$usuarioDb=$select->fetch();
		$usuario= new Usuario($usuarioDb['id'],$usuarioDb['dni'],$usuarioDb['alias'],$usuarioDb['nombres'],$usuarioDb['apellidos'],$usuarioDb['email'], $usuarioDb['clave'],$usuarioDb['tipo'],$usuarioDb['inactivo'],$usuarioDb['imagen'],$usuarioDb['cargos_id']);
		//var_dump($usuario);
		//die();
		return $usuario;
	}

	//la función para obtener un usuaio por el dni
	public static function getByDni($dni){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM usuarios WHERE dni=:dni');
		$select->bindParam('dni',$dni);
		$select->execute();

		$usuarioDb=$select->fetch();
		$usuario= new Usuario($usuarioDb['id'],$usuarioDb['dni'],$usuarioDb['alias'],$usuarioDb['nombres'],$usuarioDb['apellidos'],$usuarioDb['email'], $usuarioDb['clave'],$usuarioDb['tipo'],$usuarioDb['inactivo'],NULL,$usuarioDb['cargos_id']);
		//var_dump($usuario);
		//die();
		return $usuario;
	}

	//la función para obtener un usuario por el id
	public static function getByCargo($idCargo){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM usuarios WHERE cargos_id=:id');
		$select->bindValue('id',$idCargo);
		$select->execute();
		//asignarlo al objeto usuario
		$usuarioDb=$select->fetch();
		$usuario= new Usuario($usuarioDb['id'],$usuarioDb['dni'],$usuarioDb['alias'],$usuarioDb['nombres'],$usuarioDb['apellidos'],$usuarioDb['email'], $usuarioDb['clave'],$usuarioDb['tipo'],$usuarioDb['inactivo'],NULL,$usuarioDb['cargos_id']);
		//var_dump($usuario);
		//die();
		return $usuario;
	}

	//la función para actualizar la foto
	public static function updateFoto($usuario){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE usuarios SET imagen=:imagen WHERE id=:id');
		$update->bindValue('id',$usuario->getId());
		$update->bindValue('imagen',$usuario->getImagen());
		$update->execute();
	}
}
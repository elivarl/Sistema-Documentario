<?php 
/**
* Modelo para el acceso a la base de datos y funciones CRUD
* Sitio Web: wwww.ecodeup.com
*/
class Solicitante
{
	private $id;
	private $dni;
	private $nombres;
	private $apellidos;
	private $email;
	private $inactivo;
	private $curso;
	private $programa;
	private $direccion;
	private $telefono;
	private $carrera;
	
	function __construct($id,$dni , $nombres, $apellidos, $email,$inactivo, $curso,$programa,$direccion,$telefono,$carrera)
	{
		$this->setId($id);
		$this->setDni($dni);
		$this->setNombres($nombres);
		$this->setApellidos($apellidos);
		$this->setEmail($email);
		$this->setInactivo($inactivo);
		$this->setCurso($curso);
		$this->setPrograma($programa);
		$this->setDireccion($direccion);
		$this->setTelefono($telefono);
		$this->setCarrera($carrera);
	}

		public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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
	public function getInactivo(){
		return $this->inactivo;
	}
		public function getPrograma(){
		return $this->programa;
	}

	public function setPrograma($programa){
		$this->programa = $programa;
	}

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}

	public function getTelefono(){
		return $this->telefono;
	}

	public function setTelefono($telefono){
		$this->telefono = $telefono;
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

	public function getCurso(){
		return $this->curso;
	}

	public function setCurso($curso){
		$this->curso = $curso;
	}
	public function getCarrera(){
		return $this->carrera;
	}

	public function setCarrera($carrera){
		$this->carrera = $carrera;
	}



	//operaciones CRUD

	//función para obtener todos los solicitantes
	public static function all(){
		$listaSolicitantes =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM solicitantes');

		// carga en la $listaSolicitantes cada registro desde la base de datos
		foreach ($sql->fetchAll() as $solicitante) {
			$listaSolicitantes[]= new Solicitante($solicitante['id'],$solicitante['dni'], $solicitante['nombres'],$solicitante['apellidos'],$solicitante['email'], $solicitante['inactivo'],$solicitante['curso'],$solicitante['programa'],$solicitante['direccion'],$solicitante['telefono'],$solicitante['carrera']);
		}
		return $listaSolicitantes;
	}

	//función para obtener todos los solicitantes
	public static function allActive(){
		$listaSolicitantes =[];
		$db=Db::getConnect();
		$sql=$db->prepare('SELECT * FROM solicitantes WHERE inactivo=:inactivo order by id');
		$sql->bindValue('inactivo',"1");
		$sql->execute();
		// carga en la $listaSolicitantes cada registro desde la base de datos
		foreach ($sql->fetchAll() as $solicitante) {
			$listaSolicitantes[]= new Solicitante($solicitante['id'],$solicitante['dni'], $solicitante['nombres'],$solicitante['apellidos'],$solicitante['email'], $solicitante['inactivo'],$solicitante['curso'],$solicitante['programa'],$solicitante['direccion'],$solicitante['telefono'],$solicitante['carrera']);
		}
		return $listaSolicitantes;
	}

	//la función para registrar un solicitante
	public static function save($solicitante){
		$db=Db::getConnect();
			
		$insert=$db->prepare('INSERT INTO solicitantes VALUES(NULL,:dni,:nombres,:apellidos,:email,:inactivo,:curso,:programa,:direccion,:telefono,:carrera)');
		$insert->bindValue('dni',$solicitante->getDni());
		$insert->bindValue('nombres',$solicitante->getNombres());
		$insert->bindValue('apellidos',$solicitante->getApellidos());
		$insert->bindValue('email',$solicitante->getEmail());
		$insert->bindValue('inactivo',$solicitante->getInactivo());
		$insert->bindValue('curso',$solicitante->getCurso());
		$insert->bindValue('programa',$solicitante->getPrograma());
		$insert->bindValue('direccion',$solicitante->getDireccion());
		$insert->bindValue('telefono',$solicitante->getTelefono());
		$insert->bindValue('carrera',$solicitante->getCarrera());
		//var_dump($solicitante);
		//die();
		$insert->execute();
	}

	//la función para actualizar 
	public static function update($solicitante){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE solicitantes SET dni=:dni,nombres=:nombres,apellidos=:apellidos,email=:email,inactivo=:inactivo ,curso=:curso, programa=:programa,direccion=:direccion, telefono=:telefono,carrera=:carrera WHERE id=:id');
		$update->bindValue('id',$solicitante->getId());
		$update->bindValue('dni',$solicitante->getDni());		
		$update->bindValue('nombres',$solicitante->getNombres());
		$update->bindValue('apellidos',$solicitante->getApellidos());
		$update->bindValue('email',$solicitante->getEmail());
		$update->bindValue('inactivo',$solicitante->getInactivo());
		$update->bindValue('curso',$solicitante->getCurso());		
		$update->bindValue('programa',$solicitante->getPrograma());
		$update->bindValue('direccion',$solicitante->getDireccion());
		$update->bindValue('telefono',$solicitante->getTelefono());
		$update->bindValue('carrera',$solicitante->getCarrera());
		$update->execute();
	}

	// la función para eliminar por el id
	public static function delete($id){
		$db=Db::getConnect();
		$delete=$db->prepare('DELETE FROM solicitantes WHERE ID=:id');
		$delete->bindValue('id',$id);
		$delete->execute();
	}

	//la función para obtener un solicitante por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM solicitantes WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto solicitante
		$solicitanteDb=$select->fetch();
		$solicitante= new Solicitante($solicitanteDb['id'],$solicitanteDb['dni'],$solicitanteDb['nombres'],$solicitanteDb['apellidos'],$solicitanteDb['email'], $solicitanteDb['inactivo'],$solicitanteDb['curso'],$solicitanteDb['programa'],$solicitanteDb['direccion'],$solicitanteDb['telefono'],$solicitanteDb['carrera']);
		//var_dump($solicitante);
		//die();
		return $solicitante;
	}
	//la función para obtener un usuaio por el dni
	public static function getByDni($dni){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM solicitantes WHERE dni=:dni');
		$select->bindParam('dni',$dni);
		$select->execute();

		$solicitanteDb=$select->fetch();
		$solicitante= new Solicitante($solicitanteDb['id'],$solicitanteDb['dni'],$solicitanteDb['nombres'],$solicitanteDb['apellidos'],$solicitanteDb['email'], $solicitanteDb['inactivo'],$solicitanteDb['curso'],$solicitanteDb['programa'],$solicitanteDb['direccion'],$solicitanteDb['telefono'],$solicitanteDb['carrera']);
		//var_dump($solicitante);
		//die();
		return $solicitante;
	}
}
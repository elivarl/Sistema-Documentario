<?php 
/**
* 
*/
class Cargo{
	private $id;
	private $nombre;
	private $inactivo;
	private $areas_id;
	
	function __construct($id,$nombre,$inactivo,$areas_id)
	{
		$this->setId($id);
		$this->setNombre($nombre);
		$this->setInactivo($inactivo);
		$this->setAreas_id($areas_id);
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
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

	public function getAreas_id(){
		return $this->areas_id;
	}

	public function setAreas_id($areas_id){
		$this->areas_id = $areas_id;
	}

	//operaciones CRUD
	//la función para registrar un cargo
	public static function save($cargo){
		$db=Db::getConnect();
		//var_dump($cargo);
		//die();			
		$insert=$db->prepare('INSERT INTO cargos VALUES(NULL,:nombre,:inactivo,:areas_id)');
		$insert->bindValue('nombre',$cargo->getNombre());
		$insert->bindValue('inactivo',$cargo->getInactivo());
		$insert->bindValue('areas_id',$cargo->getAreas_id());
		$insert->execute();
	}

	//función para obtener todss las cargo por area
	public static function allByIdArea($idArea){
		$listaCargos =[];
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM cargos WHERE areas_id=:areas_id order by id');
		$select->bindValue('areas_id',$idArea);
		$select->execute();


		// carga en la $listaCargos cada registro desde la base de datos
		foreach ($select->fetchAll() as $cargo) {
			$listaCargos[]= new Cargo($cargo['id'],$cargo['nombre'],$cargo['inactivo'] ,$cargo['areas_id']);
		}
		return $listaCargos;
	}

	//la función para obtener una cargo por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM cargos WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto $area
		$cargoDb=$select->fetch();
		$cargo= new Cargo($cargoDb['id'],$cargoDb['nombre'], $cargoDb['inactivo'],$cargoDb['areas_id']);
		//var_dump($area);
		//die();
		return $cargo;
	}

	//actualiza los cargos
	public static function update($cargo){
		//var_dump();
		//die();
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE cargos SET nombre=:nombre, inactivo=:inactivo WHERE id=:id');
		$update->bindValue('id',$cargo->getId());
		$update->bindValue('nombre',$cargo->getNombre());
		$update->bindValue('inactivo',$cargo->getInactivo());
		$update->execute();
	}

	// la función para eliminar por el id
	public static function delete($id){
		//var_dump($id);
		//die();
		$db=Db::getConnect();

		// elimina en cascada

		//eliminar registros antfamiliares
		$delete=$db->prepare('DELETE FROM cargos WHERE id=:id ');
		$delete->bindValue('id',$id);		
		$delete->execute();
	}

	//función para obtener todss las cargo por area
	public static function all(){
		$listaCargos =[];
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM cargos order by id');
		$select->execute();


		// carga en la $listaCargos cada registro desde la base de datos
		foreach ($select->fetchAll() as $cargo) {
			$listaCargos[]= new Cargo($cargo['id'],$cargo['nombre'],$cargo['inactivo'] ,$cargo['areas_id']);
		}
		return $listaCargos;
	}
	//la función para obtener un cargo por el nombre
	public static function getByNombre($nombre, $areas_id){
		//buscar
		$db=Db::getConnect();
		$like='%'.$nombre.'%';
		$select=$db->prepare('SELECT * FROM cargos WHERE  nombre LIKE :buscar and areas_id=:areas_id');
		$select->bindParam('buscar',$like);
		$select->bindParam('areas_id',$areas_id);
		$select->execute();

		
		$cargoDb=$select->fetch();
		$cargo= new Cargo($cargoDb['id'],$cargoDb['nombre'], $cargoDb['inactivo'],$cargoDb['areas_id']);
		//var_dump($area);
		//die();
		return $cargo;
	}

}
?>
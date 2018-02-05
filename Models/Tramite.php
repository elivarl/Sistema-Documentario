<?php 
/**
* 
*/
class Tramite{
	private $id;
	private $nombre;
	private $costo;
	private $inactivo;

	
	function __construct($id,$nombre,$costo,$inactivo)
	{
		$this->setId($id);
		$this->setNombre($nombre);
		$this->setCosto($costo);
		$this->setInactivo($inactivo);
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

	public function getCosto(){
		return $this->costo;
	}

	public function setCosto($costo){
		$this->costo = $costo;
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

	//operaciones CRUD
	//la función para registrar un trámite
	public static function save($tramite){
		$db=Db::getConnect();
		//var_dump($tramite);
		//die();			
		$insert=$db->prepare('INSERT INTO tramites VALUES(NULL,:nombre,:precio,:inactivo)');
		$insert->bindValue('nombre',$tramite->getNombre());
		$insert->bindValue('precio',$tramite->getCosto());
		$insert->bindValue('inactivo',$tramite->getInactivo());
		$insert->execute();
	}

	//función para obtener todas las áreas
	public static function all(){
		$listaTramites =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM tramites order by id');


		// carga en la $listaTramites cada registro desde la base de datos
		foreach ($sql->fetchAll() as $tramite) {
			$listaTramites[]= new Tramite($tramite['id'],$tramite['nombre'],$tramite['precio'],$tramite['inactivo']);
		}
		return $listaTramites;
	}
	//función para obtener todas las áreas 
	public static function allActive(){
		$listaTramites =[];
		$db=Db::getConnect();
		$sql=$db->prepare('SELECT * FROM tramites WHERE inactivo=:inactivo order by id');
		$sql->bindValue('inactivo',"1");
		$sql->execute();

		// carga en la $listaTramites cada registro desde la base de datos
		foreach ($sql->fetchAll() as $tramite) {
			$listaTramites[]= new Tramite($tramite['id'],$tramite['nombre'],$tramite['precio'],$tramite['inactivo']);
		}
		return $listaTramites;
	}

	//la función para obtener una área por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM tramites WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto $area
		$tramiteDb=$select->fetch();
		$tramite= new Tramite($tramiteDb['id'],$tramiteDb['nombre'],$tramiteDb['precio'],$tramiteDb['inactivo']);
		//var_dump($tramite);
		//die();
		return $tramite;
	}

	public static function update($tramite){
		//var_dump();
		//die();
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE tramites SET nombre=:nombre, precio=:precio, inactivo=:inactivo WHERE id=:id');
		$update->bindValue('id',$tramite->getId());
		$update->bindValue('nombre',$tramite->getNombre());
		$update->bindValue('precio',$tramite->getCosto());
		$update->bindValue('inactivo',$tramite->getInactivo());
		$update->execute();
	}

	// la función para eliminar por el id
	public static function delete($id){
		//var_dump($id);
		//die();
		$db=Db::getConnect();

		// elimina en cascada

		//eliminar registros de la tabla requisitos
		$delete=$db->prepare('DELETE FROM requisitos WHERE tramites_id=:id ');
		$delete->bindValue('id',$id);		
		$delete->execute();

		//eliminar registros de la tabla tramites
		$delete=$db->prepare('DELETE FROM tramites WHERE id=:id ');
		$delete->bindValue('id',$id);		
		$delete->execute();
	}

	//la función para obtener un tramite por el nombre
	public static function getByNombre($nombre){
		//buscar
		$db=Db::getConnect();
		$like='%'.$nombre.'%';
		$select=$db->prepare('SELECT * FROM tramites WHERE  nombre LIKE :buscar');
		$select->bindParam('buscar',$like);
		$select->execute();

		
		$tramiteDb=$select->fetch();
		$tramite= new Tramite($tramiteDb['id'],$tramiteDb['nombre'],$tramiteDb['precio'],$tramiteDb['inactivo']);
		//var_dump($area);
		//die();
		return $tramite;
	}
}
?>
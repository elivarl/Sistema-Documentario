<?php 
/**
* 
*/
class Requisito{
	private $id;
	private $nombre;
	private $tramites_id;
	
	function __construct($id,$nombre,$tramites_id)
	{
		$this->setId($id);
		$this->setNombre($nombre);
		$this->setTramites_id($tramites_id);
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
	public function getTramites_id(){
		return $this->tramites_id;
	}

	public function setTramites_id($tramites_id){
		$this->tramites_id = $tramites_id;
	}

	//operaciones CRUD
	//la función para registrar un requisito
	public static function save($requisito){
		$db=Db::getConnect();
		//var_dump($area);
		//die();			
		$insert=$db->prepare('INSERT INTO requisitos VALUES(NULL,:nombre,:tramites_id)');
		$insert->bindValue('nombre',$requisito->getNombre());
		$insert->bindValue('tramites_id',$requisito->getTramites_id());
		$insert->execute();
	}

	//función para obtener todas las requisitos
	public static function all(){
		$listaRequisitos =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM requisitos order by id');


		// carga en la $requisitos cada registro desde la base de datos
		foreach ($sql->fetchAll() as $requisito) {
			$listaRequisitos[]= new Requisito($requisito['id'],$requisito['nombre'],$requisito['tramites_id']);
		}
		return $listaRequisitos;
	}

	//la función para obtener un requisito por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM requisitos WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto $requisito
		$requisitoDb=$select->fetch();
		$requisito= new Requisito($requisitoDb['id'],$requisitoDb['nombre'],$requisitoDb['tramites_id']);
		//var_dump($area);
		//die();
		return $requisito;
	}

	public static function update($requisito){
		//var_dump();
		//die();
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE requisitos SET nombre=:nombre WHERE id=:id');
		$update->bindValue('id',$requisito->getId());
		$update->bindValue('nombre',$requisito->getNombre());
		$update->execute();
	}
	//función para obtener todas las cargo
	public static function allByIdTramite($idTramite){
		$listaRequisitos =[];
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM requisitos WHERE tramites_id=:tramites_id order by id');
		$select->bindValue('tramites_id',$idTramite);
		$select->execute();


		// carga en la $listaCargos cada registro desde la base de datos
		foreach ($select->fetchAll() as $requisito) {
			$listaRequisitos[]= new Requisito($requisito['id'],$requisito['nombre'], $requisito['tramites_id']);
		}
		return $listaRequisitos;
	}
	// la función para eliminar por el id
	public static function delete($id){
		//var_dump($id);
		//die();
		$db=Db::getConnect();

		//eliminar registros 
		$delete=$db->prepare('DELETE FROM requisitos WHERE id=:id ');
		$delete->bindValue('id',$id);		
		$delete->execute();
	}

}
?>
<?php 
/**
* 
*/
class Area{
	private $id;
	private $codigo;
	private $nombre;
	private $inactivo;
	
	function __construct($id,$nombre,$codigo,$inactivo)
	{
		$this->setId($id);
		$this->setNombre($nombre);
		$this->setCodigo($codigo);
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
	public function getCodigo(){
		return $this->codigo;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

	//operaciones CRUD
	//la función para registrar un área
	public static function save($area){
		$db=Db::getConnect();
		//var_dump($area);
		//die();			
		$insert=$db->prepare('INSERT INTO areas VALUES(NULL,:codigo,:nombre,:inactivo)');
		$insert->bindValue('nombre',$area->getNombre());
		$insert->bindValue('codigo',$area->getCodigo());
		$insert->bindValue('inactivo',$area->getInactivo());
		$insert->execute();
	}

	//función para obtener todas las áreas
	public static function all(){
		$listaAreas =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM areas order by id');


		// carga en la $listaAreas cada registro desde la base de datos
		foreach ($sql->fetchAll() as $area) {
			$listaAreas[]= new Area($area['id'],$area['nombre'],$area['codigo'],$area['inactivo']);
		}
		return $listaAreas;
	}
	//función para obtener todas las áreas activas
	public static function allActive(){
		$listaAreas =[];
		$db=Db::getConnect();
		$sql=$db->prepare('SELECT * FROM areas WHERE inactivo=:inactivo order by id');
		$sql->bindValue('inactivo',"1");
		$sql->execute();

		// carga en la $listaAreas cada registro desde la base de datos
		foreach ($sql->fetchAll() as $area) {
			$listaAreas[]= new Area($area['id'],$area['nombre'],$area['codigo'],$area['inactivo']);
		}
		return $listaAreas;
	}

	//la función para obtener una área por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM areas WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto $area
		$areaDb=$select->fetch();
		$area= new Area($areaDb['id'],$areaDb['nombre'],$areaDb['codigo'],$areaDb['inactivo']);
		//var_dump($area);
		//die();
		return $area;
	}

	public static function update($area){
		//var_dump();
		//die();
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE areas SET nombre=:nombre, codigo=:codigo,inactivo=:inactivo WHERE id=:id');
		$update->bindValue('id',$area->getId());
		$update->bindValue('nombre',$area->getNombre());
		$update->bindValue('codigo',$area->getCodigo());
		$update->bindValue('inactivo',$area->getInactivo());
		$update->execute();
	}

	// la función para eliminar por el id
	public static function delete($id){
		//var_dump($id);
		//die();
		$db=Db::getConnect();

		// elimina en cascada

		//eliminar registros de la tabla cargos
		$delete=$db->prepare('DELETE FROM cargos WHERE areas_id=:id');
		$delete->bindValue('id',$id);		
		$delete->execute();

		//eliminar registros de la tabla areas
		$delete=$db->prepare('DELETE FROM areas WHERE id=:id ');
		$delete->bindValue('id',$id);		
		$delete->execute();
	}

	//la función para obtener un areas por el codigo
	public static function getByCodigo($codigo){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM areas WHERE  codigo=:codigo');
		$select->bindParam('codigo',$codigo);
		$select->execute();

		$areaDb=$select->fetch();
		$area= new Area($areaDb['id'],$areaDb['nombre'],$areaDb['codigo'],$areaDb['inactivo']);
		//var_dump($area);
		//die();
		return $area;
	}

	//función para obtener todas las áreas sin pesa de partes
	public static function allWhithout(){
		$listaAreas =[];
		$db=Db::getConnect();
		$areaNO='MP';
		$sql=$db->prepare('SELECT * FROM areas WHERE codigo NOT IN (:cod) and inactivo=:inactivo order by id');
		$sql->bindParam('cod',$areaNO);
		$sql->bindValue('inactivo',"1");
		$sql->execute();

		// carga en la $listaAreas cada registro desde la base de datos
		foreach ($sql->fetchAll() as $area) {
			$listaAreas[]= new Area($area['id'],$area['nombre'],$area['codigo'],$area['inactivo']);
		}
		return $listaAreas;
	}

	//función para obtener todas las áreas sin pesa de partes ni direcion general
	public static function allDerivar(){
		$listaAreas =[];
		$db=Db::getConnect();
		$areaNO1='MP';
		$areaNO2='DG01';
		$sql=$db->prepare('SELECT * FROM areas WHERE codigo NOT IN (:cod1,:cod2) order by id');
		$sql->bindParam('cod1',$areaNO1);
		$sql->bindParam('cod2',$areaNO2);
		$sql->execute();

		// carga en la $listaAreas cada registro desde la base de datos
		foreach ($sql->fetchAll() as $area) {
			$listaAreas[]= new Area($area['id'],$area['nombre'],$area['codigo'],$area['inactivo']);
		}
		return $listaAreas;
	}
}
?>
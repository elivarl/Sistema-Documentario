<?php 
/**
* 
*/
class Seguimiento{
	private $id;
	private $area_remitente_id;
	private $area_recibe_id;
	private $fecha_envio;
	private $accion;
	private $estado;
	private $expedientes_id;
	
	function __construct($id,$area_remitente_id,$area_recibe_id,$fecha_envio,$accion,$estado,$expedientes_id)
	{
		$this->setId($id);
		$this->setArea_remitente_id($area_remitente_id);
		$this->setArea_recibe_id($area_recibe_id);
		$this->setFecha_envio($fecha_envio);
		$this->setAccion($accion);
		$this->setEstado($estado);
		$this->setExpedientes_id($expedientes_id);
	}

		public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getArea_remitente_id(){
		return $this->area_remitente_id;
	}

	public function setArea_remitente_id($area_remitente_id){
		$this->area_remitente_id = $area_remitente_id;
	}

	public function getArea_recibe_id(){
		return $this->area_recibe_id;
	}

	public function setArea_recibe_id($area_recibe_id){
		$this->area_recibe_id = $area_recibe_id;
	}

	public function getFecha_envio(){
		return $this->fecha_envio;
	}

	public function setFecha_envio($fecha_envio){
		$this->fecha_envio = $fecha_envio;
	}

	public function getAccion(){
		return $this->accion;
	}

	public function setAccion($accion){
		$this->accion = $accion;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}

	public function getExpedientes_id(){
		return $this->expedientes_id;
	}

	public function setExpedientes_id($expedientes_id){
		$this->expedientes_id = $expedientes_id;
	}

	//operaciones CRUD
	//la función para registrar un área
	public static function save($seguimiento){
		$db=Db::getConnect();
		//var_dump($area);
		//die();			
		$insert=$db->prepare('INSERT INTO seguimientos VALUES(NULL,:area_remitente_id,:area_recibe_id,:fecha_envio,:accion,:estado,:expedientes_id)');
		$insert->bindValue('area_remitente_id',$seguimiento->getArea_remitente_id());
		$insert->bindValue('area_recibe_id',$seguimiento->getArea_recibe_id());
		$insert->bindValue('fecha_envio',$seguimiento->getFecha_envio());
		$insert->bindValue('accion',$seguimiento->getAccion());
		$insert->bindValue('estado',$seguimiento->getEstado());
		$insert->bindValue('expedientes_id',$seguimiento->getExpedientes_id());
		$insert->execute();
	}

	//función para obtener todas las áreas
	public static function all(){
		$listaSeguimientos =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM seguimientos order by id');


		// carga en la $listaAreas cada registro desde la base de datos
		foreach ($sql->fetchAll() as $seguimiento) {
			$listaSeguimientos[]= new Seguimiento($seguimiento['id'],$seguimiento['area_remitente_id'],$seguimiento['area_recibe_id'],$seguimiento['fecha_envio'],$seguimiento['accion'],$seguimiento['estado']);
		}
		return $listaSeguimientos;
	}
	//obtener por expediente
	public static function allByIdExpediente($idExpediente){
		$listaSeguimientos =[];
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM seguimientos WHERE expedientes_id=:expedientes_id order by id');
		$select->bindValue('expedientes_id',$idExpediente);
		$select->execute();


		// carga en la $listaCargos cada registro desde la base de datos
		foreach ($select->fetchAll() as $seguimiento) {
			$listaSeguimientos[]= new Seguimiento($seguimiento['id'],$seguimiento['area_remite_id'],$seguimiento['area_recibe_id'],$seguimiento['fecha_envio'],$seguimiento['accion'],$seguimiento['estado'],null);
		}
		return $listaSeguimientos;
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
		$sql=$db->prepare('SELECT * FROM areas WHERE codigo NOT IN (:cod) order by id');
		$sql->bindParam('cod',$areaNO);
		$sql->execute();

		// carga en la $listaAreas cada registro desde la base de datos
		foreach ($sql->fetchAll() as $area) {
			$listaAreas[]= new Area($area['id'],$area['nombre'],$area['codigo'],$area['inactivo']);
		}
		return $listaAreas;
	}
}
?>
<?php 
/**
* Modelo para el acceso a la base de datos y funciones CRUD
* Sitio Web: wwww.ecodeup.com
*/
class Expediente
{
	private $id;
	private $numero;
	private $fecha_registro;
	private $fecha_atendido;
	private $estado;
	private $tramites_id;
	private $areas_id;
	private $solicitantes_id;
	private $cargos_id;

	
	function __construct($id,$numero,$fecha_registro,$fecha_atendido,$estado,$tramites_id,$areas_id,$solicitantes_id,$cargos_id)
	{
		$this->setId($id);
		$this->setNumero($numero);
		$this->setFecha_registro($fecha_registro);
		$this->setFecha_atendido($fecha_atendido);
		$this->setEstado($estado);
		$this->setTramites_id($tramites_id);
		$this->setAreas_id($areas_id);
		$this->setSolicitantes_id($solicitantes_id);
		$this->setCargos_id($cargos_id);
		
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNumero(){
		return $this->numero;
	}

	public function setNumero($numero){
		$this->numero = $numero;
	}

	public function getFecha_registro(){
		return $this->fecha_registro;
	}

	public function setFecha_registro($fecha_registro){
		$this->fecha_registro = $fecha_registro;
	}

	public function getFecha_atendido(){
		return $this->fecha_atendido;
	}

	public function setFecha_atendido($fecha_atendido){
		$this->fecha_atendido = $fecha_atendido;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}

	public function getTramites_id(){
		return $this->tramites_id;
	}

	public function setTramites_id($tramites_id){
		$this->tramites_id = $tramites_id;
	}

	public function getAreas_id(){
		return $this->areas_id;
	}

	public function setAreas_id($areas_id){
		$this->areas_id = $areas_id;
	}

	public function getSolicitantes_id(){
		return $this->solicitantes_id;
	}

	public function setSolicitantes_id($solicitantes_id){
		$this->solicitantes_id = $solicitantes_id;
	}

	public function getCargos_id(){
		return $this->cargos_id;
	}

	public function setCargos_id($cargos_id){
		$this->cargos_id = $cargos_id;
	}


	//operaciones CRUD

	//función para obtener todos los expedientes
	public static function all(){
		$listaExpedientes =[];
		$db=Db::getConnect();
		$sql=$db->query('SELECT * FROM expedientes');

		// carga en la $listaExpedientes cada registro desde la base de datos
		foreach ($sql->fetchAll() as $expediente) {
			$listaExpedientes[]= new Expediente($expediente['id'],$expediente['numero'], $expediente['fecha_registro'],$expediente['fecha_atendido'],$expediente['estado'],$expediente['tramites_id'],$expediente['areas_id'],$expediente['solicitantes_id'],$expediente['cargos_id']);
		}
		return $listaExpedientes;
	}

	//la función para registrar un expedientes
	public static function save($expediente){
		$db=Db::getConnect();
			
		$insert=$db->prepare('INSERT INTO expedientes VALUES(NULL,:numero,:fecha_registro,:fecha_atendido,:estado,:tramites_id,:areas_id,:solicitantes_id,:cargos_id)');
		$insert->bindValue('numero',$expediente->getNumero());
		$insert->bindValue('fecha_registro',$expediente->getFecha_registro());
		$insert->bindValue('fecha_atendido',$expediente->getFecha_atendido());
		$insert->bindValue('estado',$expediente->getEstado());
		$insert->bindValue('tramites_id',$expediente->getTramites_id());
		$insert->bindValue('areas_id',$expediente->getAreas_id());
		$insert->bindValue('solicitantes_id',$expediente->getSolicitantes_id());
		$insert->bindValue('cargos_id',$expediente->getCargos_id());
		//var_dump($expediente);
		//die();
		$insert->execute();
	}

	//la función para actualizar 
	/*public static function update($expediente){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE expedientes SET numero=:numero,fecha_registro=:fecha_registro,fecha_atendido=:fecha_atendido,estado=:estado,tramites_id=:tramites_id,areas_id=:areas_id,solicitantes_id=:solicitantes_id,cargos_id=:cargos_id WHERE id=:id');
		$update->bindValue('id',$expediente->getId());
		$update->bindValue('numero',$expediente->getNumero());
		$update->bindValue('fecha_registro',$expediente->getFecha_registro());
		$update->bindValue('fecha_atendido',$expediente->getFecha_atendido());
		$update->bindValue('estado',$expediente->getEstado());
		$update->bindValue('tramites_id',$expediente->getTramites_id());
		$update->bindValue('areas_id',$expediente->getAreas_id());
		$update->bindValue('solicitantes_id',$expediente->getSolicitantes_id());
		$update->bindValue('cargos_id',$expediente->getCargos_id());
		$update->execute();
	}*/
	public static function update($expediente){
		$db=Db::getConnect();
		$update=$db->prepare('UPDATE expedientes SET fecha_atendido=:fecha_atendido,estado=:estado WHERE id=:id');
		$update->bindValue('id',$expediente->getId());
		$update->bindValue('fecha_atendido',$expediente->getFecha_atendido());
		$update->bindValue('estado',$expediente->getEstado());
		$update->execute();
	}

	// la función para eliminar por el id
	public static function delete($id){
		$db=Db::getConnect();
		

		//eliminar registros de la tabla seguimientos
		$delete=$db->prepare('DELETE FROM seguimientos WHERE expedientes_id=:id ');
		$delete->bindValue('id',$id);		
		$delete->execute();

		$delete=$db->prepare('DELETE FROM expedientes WHERE ID=:id');
		$delete->bindValue('id',$id);
		$delete->execute();
	}

	//la función para obtener un solicitante por el id
	public static function getById($id){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM expedientes WHERE ID=:id');
		$select->bindValue('id',$id);
		$select->execute();
		//asignarlo al objeto solicitante
		$expedienteDb=$select->fetch();
		$expediente= new Expediente($expedienteDb['id'],$expedienteDb['numero'],$expedienteDb['fecha_registro'], $expedienteDb['fecha_atendido'], $expedienteDb['estado'], $expedienteDb['tramites_id'], $expedienteDb['areas_id'], $expedienteDb['solicitantes_id'], $expedienteDb['cargos_id']);
		//var_dump($solicitante);
		//die();
		return $expediente;
	}

	/***FUNCIONES AUXILIARES***/
	//la función para obtener el valor max del id para el número de expediente
	public static function getMaxId(){
		//buscar el max id de la tabla expedientes
		$db=Db::getConnect();
		$select=$db->prepare('SELECT MAX(id) AS id FROM expedientes');
		$select->execute();
		//asignarlo al objeto que obtiene el registro
		$expedienteDb=$select->fetch();
		$idMax= $expedienteDb['id'];
		return $idMax;
	}

	//la función para obtener un expediente por el numero
	public static function getByNumero($numero){
		//buscar
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM expedientes WHERE numero=:numero');
		$select->bindParam('numero',$numero);
		$select->execute();

		$expedienteDb=$select->fetch();
		$expediente= new Expediente($expedienteDb['id'],$expedienteDb['numero'],$expedienteDb['fecha_registro'], $expedienteDb['fecha_atendido'], $expedienteDb['estado'], $expedienteDb['tramites_id'], $expedienteDb['areas_id'], $expedienteDb['solicitantes_id'], $expedienteDb['cargos_id']);
		//var_dump($solicitante);
		//die();
		return $expediente;
	}


	//función para obtener todos los expedientes
	public static function allDerivado(){
		$listaExpedientes =[];
		$db=Db::getConnect();
		$estado='D';
		$sql=$db->prepare('SELECT * FROM expedientes WHERE estado=:estado order by id');
		$sql->bindValue('estado',$estado);
		$sql->execute();

		// carga en la $listaExpedientes cada registro desde la base de datos
		foreach ($sql->fetchAll() as $expediente) {
			$listaExpedientes[]= new Expediente($expediente['id'],$expediente['numero'], $expediente['fecha_registro'],$expediente['fecha_atendido'],$expediente['estado'],$expediente['tramites_id'],$expediente['areas_id'],$expediente['solicitantes_id'],$expediente['cargos_id']);
		}
		return $listaExpedientes;
	}
	//función para obtener todos los expedientes
	public static function allEnviado(){
		$listaExpedientes =[];
		$db=Db::getConnect();
		$estado='E';
		$sql=$db->prepare('SELECT * FROM expedientes WHERE estado=:estado order by id');
		$sql->bindValue('estado',$estado);
		$sql->execute();

		// carga en la $listaExpedientes cada registro desde la base de datos
		foreach ($sql->fetchAll() as $expediente) {
			$listaExpedientes[]= new Expediente($expediente['id'],$expediente['numero'], $expediente['fecha_registro'],$expediente['fecha_atendido'],$expediente['estado'],$expediente['tramites_id'],$expediente['areas_id'],$expediente['solicitantes_id'],$expediente['cargos_id']);
		}
		return $listaExpedientes;
	}
}
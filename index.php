<?php 
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	 require_once('connection.php');
	// la variable controller guarda el nombre del controlador y action guarda la acción por ejemplo registrar 
	//si la variable controller y action son pasadas por la url desde layout.php entran en el if
	

	if (isset($_GET['controller'])&&isset($_GET['action'])) {
			$controller=$_GET['controller'];
			$action=$_GET['action'];		
	} else {
		$controller='usuario';
		if (isset($_SESSION['usuario'])) {
			$action='welcome';
		}else{
			if (isset($_GET['controller'])&&$_GET['controller']=='admin') {
				$controller='usuario';
				$action='register';
			}else {
				$action='showLogin';
			}
		}
		
	}	
	//carga la vista layout.php
	require_once('Views/Layouts/layout.php');
?>
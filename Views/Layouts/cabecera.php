<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }?>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">			
			<a class="navbar-brand" href="http://localhost/sdi/">
			<span class="glyphicon glyphicon-cloud" aria-hidden="true" ></span>
			Sistema Documentario
			</a>
		</div>
			<ul class="nav navbar-nav">
		<?php if (isset($_SESSION['usuario'])){ ?>	

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Usuarios <span class="caret"></span></a>
					<ul class="dropdown-menu">						
						<li><a href="?controller=usuario&action=registerUser">Registrar</a></li>
						<li><a href="?controller=usuario&action=showUser">Ver Usuarios</a></li>
					</ul>
				</li>

				
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Áreas <span class="caret"></span></a>
					<ul class="dropdown-menu">						
						<li><a href="?controller=area&action=register">Registrar</a></li>
						<li><a href="?controller=area&action=show">Ver Áreas</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-tooggle" data-toggle="dropdown" href="#">Trámites<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?controller=tramite&action=register">Registrar</a></li>
						<li><a href="?controller=tramite&action=show">Ver Trámites</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-tooggle" data-toggle="dropdown" href="#">Solicitantes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?controller=solicitante&action=register">Registrar</a></li>
						<li><a href="?controller=solicitante&action=show">Ver Solicitantes</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-tooggle" data-toggle="dropdown" href="#">Expedientes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?controller=expediente&action=register">Registrar</a></li>
						<li><a href="?controller=expediente&action=show">Ver Expedientes</a></li>
						<li><a href="?controller=expediente&action=tramitar">Tramitar</a></li>
					</ul>
				</li>
			
		<?php } ?>
			</ul>		
			<ul class="nav navbar-nav navbar-right">
			<?php if (isset($_SESSION['usuario'])){?>		
				<p class="navbar-text">
						<img src="<?php echo $_SESSION['usuario_imagen']?>" class="img-circle" alt="Anonimo">
				</p>
				<p class="navbar-text">Bienvenido: <?php echo $_SESSION['usuario_alias']; ?></p>
				<li class="dropdown">
					<a class="dropdown-tooggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-cog"></span> Ver cuenta</a>
					<ul class="dropdown-menu">
						<li>
							<a href="?controller=usuario&action=showregister&id=<?php echo $_SESSION['usuario_id'] ?>">							
								Mi cuenta
							</a>
						</li>
						<li><a href="?controller=usuario&action=registerFoto">Agregar Foto</a></li>
						<li><a href="?controller=usuario&action=updatePas">Cambiar Contraseña</a></li>
					</ul>
				</li>					
				<li>
					<a href="?controller=usuario&action=logout">
						<span class="glyphicon glyphicon-log-out"></span>
						Salir
					</a>
				</li>
			<?php } else{ ?>
					<li>
						<a href="?controller=usuario&action=consulta">
							<span class="glyphicon glyphicon-user"></span>
							Consulta Usuario
						</a>
					</li>					
					<li>
						<a href="?controller=usuario&action=showLogin">
							<span class="glyphicon glyphicon-log-in"></span>
							Entrar
						</a>
					</li>
			<?php } ?>
			</ul>
	</div>
</nav>
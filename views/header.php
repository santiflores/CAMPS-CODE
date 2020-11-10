<?php 
if (isset($_SESSION['admin'])) {
	$header = '
	<li class="header-item"><a href="'. RUTA .'/index.php">Inicio CAMPS</a></li>
	<li class="header-item"><a href="'. RUTA .'/admin/administracion.php">Panel de administracion</a></li>
	<li class="header-item">
		<div class="btn-group">
			<button type="button" class="btn dropdown-toggle header_icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img class="header_icon--btn" alt="CAMPS" src="'. RUTA .'/images/user_icon.png">
			 </button>
			  <div class="dropdown-menu dropdown-menu-right">
			  <a href="'. RUTA .'/admin_info.php" class="dropdown-item disabled">Configuracion del centro medico</a>
			  <a href="'. RUTA .'/cerrar_sesion.php" class="dropdown-item">Cerrar sesion</a>
			</div>
		</div>
	</li>
	';
}elseif (isset($_SESSION['medico'])) {
	$header = '
		<li class="header-item"><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li class="header-item">
			<div class="btn-group">
				<button type="button" class="btn dropdown-toggle header_icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img class="header_icon--btn" alt="CAMPS" src="'. RUTA .'/images/medic.png">
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="'. RUTA .'/medicos/turnos.php" class="dropdown-item">Proximos Turnos</a>
					<a href="'. RUTA .'/cerrar_sesion.php" class="dropdown-item">Cerrar sesion</a>
					<a href="" class="dropdown-item disabled">Mi cuenta</a>
				</div>
			</div>
		</li>		
	';
} elseif (isset($_SESSION['usuario'])) {
	$header = '
		<li class="header-item"><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li class="header-item"><a href="'. RUTA .'/sobre_nosotros.php">Quienes somos</a></li>
		<li class="header-item"><a href="'. RUTA .'/medicos.php">Profesionales</a></li>
		<li class="header-item">
			<div class="btn-group">
				<button type="button" class="btn dropdown-toggle header_icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<!--<img class="header_icon--btn" alt="CAMPS" src="'. RUTA .'/images/user_icon.png">-->
				<a href="'. RUTA .'/usuarios/mi_cuenta.php">Mi cuenta</a>
 				</button>
  				<div class="dropdown-menu dropdown-menu-right">
				  <a href="'. RUTA .'/usuarios/mis_turnos.php" class="dropdown-item">Mis Turnos</a>
				  <a href="'. RUTA .'/cerrar_sesion.php" class="dropdown-item">Cerrar sesion</a>
				  <a href="'. RUTA .'/usuarios/mi_cuenta.php" class="dropdown-item">Mi cuenta</a>
				</div>
			</div>
		</li>
	';
} else {
	$header = '
		<li class="header-item"><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li class="header-item"><a href="'. RUTA .'/sobre_nosotros.php">Quienes somos</a></li>
		<li class="header-item"><a href="'. RUTA .'/medicos.php">Profesionales</a></li>
		<li class="header-item"><a href="'. RUTA .'/login.php">Iniciar sesión</a></li>
		<li class="header-item"><a href="'. RUTA .'/registrarse.php">Registrarse</a></li>
		';
	}

?>
<header class="menu">
	<a href="<?php echo RUTA;?>/index.php" class="logoheader">
		<img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
	</a>
	<div class="nav_boton_dropdown">
		<svg width="60" height="70" viewBox="0 0 300 231" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect y="184" width="300" height="35" rx="15" fill="white"/>
			<rect y="92" width="300" height="35" rx="15" fill="white"/>
			<rect width="300" height="35" rx="15" fill="white"/>
		</svg>
	</div>
	
	<div id="navbar_dropdown">
		<div class="wrapper_drop_first">
			<a href="<?php echo RUTA;?>/index.php" class="logoheader">
				<img src="<?php echo RUTA?>/images/logo_camps.png" alt="">
			</a>
			<div class="nav_boton_dropdown drop_cerrar">
				<svg width="60" height="70" viewBox="0 0 300 231" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect x="24.7487" width="300" height="35" rx="15" transform="rotate(45 24.7487 0)" fill="white"/>
				<rect x="0.197735" y="212.132" width="300" height="35" rx="15" transform="rotate(-45 0.197735 212.132)" fill="white"/>
			</svg>
		</div>
		</div>
		<ul>
			<?php echo($header);?>
		</ul>
	</div>
	<nav>
		<ul>
			<?php echo($header);?>
		</ul>
	</nav>
</header>
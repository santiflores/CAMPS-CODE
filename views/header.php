<?php 
if (isset($_SESSION[$session_hash.'admin'])) {
	$header = '
	<li class="header-item"><a href="'. RUTA .'/index.php">Inicio</a></li>
	<li class="header-item"><a href="'. RUTA .'/admin/administracion.php">Administracion</a></li>
	<div class="btn-group mi-cuenta-group">
		<button type="button" class="btn dropdown-toggle header_icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<img class="header_icon--btn" alt="CAMPS" src="'. RUTA .'/images/user_icon.png">
			</button>
			<div class="dropdown-menu dropdown-menu-right">
			<a href="'. RUTA .'/admin_info.php" class="dropdown-item disabled">Configuracion del centro medico</a>
			<a href="'. RUTA .'/cerrar_sesion.php" class="dropdown-item">Cerrar sesion</a>
		</div>
	</div>
	';
}elseif (isset($_SESSION[$session_hash.'medico'])) {
	$header = '
		<li class="header-item"><a href="'. RUTA .'/medicos/prestador.php">Inicio</a></li>
		<li class="header-item"><a href="'. RUTA .'/medicos/turnos.php">Proximos turnos</a></li>

		<div class="btn-group mi-cuenta-group">
			<button type="button" class="btn dropdown-toggle header_icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img class="header_icon--btn" alt="CAMPS" src="'. RUTA .'/images/medic.png">
			</button>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="'. RUTA .'/medicos/turnos.php" class="dropdown-item">Proximos Turnos</a>
				<a href="" class="dropdown-item disabled">Mi cuenta</a>
				<a href="'. RUTA .'/cerrar_sesion.php" class="dropdown-item">Cerrar sesion</a>
				</div>
			</div>
	';
} elseif (isset($_SESSION[$session_hash.'usuario'])) {
	$header = '
		<li class="header-item"><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li class="header-item"><a href="'. RUTA .'/sobre_nosotros.php">Quienes somos</a></li>
		<li class="header-item"><a href="'. RUTA .'/medicos.php">Profesionales</a></li>
		<li class="header-item"><a href="'. RUTA .'/usuarios/mis_turnos.php">Mis turnos</a></li>
		<div class="btn-group mi-cuenta-group">
			<button type="button" class="btn dropdown-toggle header_icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img class="header_icon--btn" alt="CAMPS" src="'. RUTA .'/images/user_icon.png">
			<span href="'. RUTA .'/usuarios/mi_cuenta.php">Mi cuenta</span>
			</button>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="'. RUTA .'/usuarios/mis_turnos.php" class="dropdown-item">Mis Turnos</a>
				<a href="'. RUTA .'/usuarios/mi_cuenta.php" class="dropdown-item">Mi cuenta</a>
				<a href="'. RUTA .'/cerrar_sesion.php" class="dropdown-item">Cerrar sesion</a>
			</div>
		</div>
	';
} else {
	$header = '
		<li class="header-item"><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li class="header-item"><a href="'. RUTA .'/sobre_nosotros.php">Quienes somos</a></li>
		<li class="header-item"><a href="'. RUTA .'/medicos.php">Profesionales</a></li>
		<li class="header-item"><a href="'. RUTA .'/login.php">Ingresar</a></li>
		';
	}

?>
<header class="header ">
	<a href="<?php echo RUTA;?>/index.php" class="logoheader">
		<img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
	</a>
	<div class="nav_boton_dropdown">
		<img src="<?php echo RUTA;?>/images/hamb.png" alt="Menu">
	</div>
	
	<div id="navbar_dropdown">
		<div class="wrapper_drop_first">
			<div class="nav_boton_dropdown drop_cerrar">
				<img src="<?php echo RUTA?>/images/cerrar.png" alt="Cerrar">
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
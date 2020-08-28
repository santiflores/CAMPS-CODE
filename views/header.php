<?php 
if (isset($_SESSION['admin'])) {
	$header = '
	<li><a href="'. RUTA .'/index.php">Inicio CAMPS</a></li>
	<li><a href="../cerrar_sesion.php">Cerrar Sesion</a></li>
	<li><a href="administracion.php" class="botones">Panel de administracion</a></li>
	';
}elseif (isset($_SESSION['medico'])) {
	$header = '
		<li><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li><a href="'. RUTA .'/cerrar_sesion.php">Cerrar Sesion</a></li>
		<li><a href="turnos.php" class="botones">PROXIMOS TURNOS</a></li>
	';
} elseif (isset($_SESSION['usuario'])) {
	$header = '
		<li><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li><a href="'. RUTA .'/sobre_nosotros.php">Quienes somos</a></li>
		<li><a href="'. RUTA .'/cerrar_sesion.php">Cerrar Sesion</a></li>
		<li><a href="'. RUTA .'/usuarios/mis_turnos.php" class="botones">MIS TURNOS</a></li>
		<li><a href="'. RUTA .'/medicos.php" class="botones">PROFESIONALES</a></li>
	';
} else {
	$header = '
		<li><a href="'. RUTA .'/index.php">Inicio</a></li>
		<li><a href="'. RUTA .'/sobre_nosotros.php">Quienes somos</a></li>
		<li><a href="'. RUTA .'/medicos.php" class="botones">PROFESIONALES</a></li>
		<li><a href="'. RUTA .'/login.php" class="botones">INICIAR SESION</a></li>
		<li><a href="'. RUTA .'/registrarse.php" class="botones">REGISTRARSE</a></li>
	';
}

?>
<header class="menu">
	<a href="<?php echo RUTA;?>/index.php" class="logoheader">
		<img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
	</a>
	<button type="button" name="button" class="nav_boton_dropdown" onclick="navDropdown()">
		<img src="images/nav_icon.png" alt="Menu">
	</button>
	<div id="navbar_dropdown">
		<div class="wrapper_drop_first">
			<button type="button" name="button" class="nav_boton_dropdown" onclick="navDropdownCerrar()">
				<img src="images/nav_icon_cerrar.png" alt="Menu">
			</button>
			<a href="index.php" class="logoheader">
				<img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
			</a>
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
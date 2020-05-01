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
            <li><a href="<?php echo RUTA;?>/index.php">Inicio</a></li>
            <li><a href="<?php echo RUTA;?>/sobre_nosotros.php">Quienes somos</a></li>
            <li><a href="<?php echo RUTA;?>/medicos.php" class="botones">RESERVE SU TURNO</a></li>
            <li><a href="<?php echo RUTA;?>/index.php" class="botones">CONTACANOS</a></li>
        </ul>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="sobre_nosotros.php">Quienes somos</a></li>
            <li><a href="medicos.php" class="botones">RESERVE SU TURNO</a></li>
            <li><a href="#contacto" class="botones">CONTACANOS</a></li>
        </ul>
    </nav>
</header>
function displayTurnos() {
	document.getElementById('wrapper_turno_padre').style.display='grid';
}
function cerrar_turno(){
	document.getElementById('wrapper_turno_padre').style.display='none'
}
function navDropdown() {
	document.getElementById('navbar_dropdown').style.display='block'
}
function navDropdownCerrar() {
	document.getElementById('navbar_dropdown').style.display='none'
}
function agregarEspecialidad() {
	var estado = 'cerrado';
	var agregarEspecialidad = document.getElementById('agregar');
	if (agregarEspecialidad.style.display='none') {
		agregarEspecialidad.style.display ='block';
	} else {
		agregarEspecialidad.style.display='none';
	}
}
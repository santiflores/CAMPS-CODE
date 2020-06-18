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
	var agregarEspecialidad = document.getElementById('agregar');
	if (agregarEspecialidad.style.display='none') {
		agregarEspecialidad.style.display ='block';
	} else if (agregarEspecialidad.style.display='block'){
		agregarEspecialidad.style.display='none';
	}
	return agregarEspecialidad;
}
function nuevaFila() {
		var nueva_fila = document.getElementById('nueva_fila');
		document.getElementById('nueva_fila').insertAdjacentHTML('afterend', nueva_fila);
}

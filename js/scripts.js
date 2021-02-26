const DOMelements = {
	header: document.querySelector('.header'),
	headerItems: document.querySelectorAll('.header-item'),
	nuevoHorarioBtn: document.getElementById('nuevo-horario-btn'),
	nuevoHorarioWrap: document.getElementById('nuevo-horario-wrap'),
	filasExistentes: document.querySelectorAll('.nueva-fila'),
	borrarFila: document.querySelectorAll('.border-button'),

	nuevoPrecioBtn: document.getElementById('nuevo-precio-btn'),
	nuevoPrecioWrap: document.getElementById('nuevo-precio-wrap'),
	borrarprecioBtn: document.getElementById('borrar-precio'),

	navDropBtn: document.querySelectorAll('.nav_boton_dropdown'),
	navDropdown: document.querySelector('#navbar_dropdown'),
	dropdownBtn: document.getElementById('boton_dropdown'),
	dropdown: document.getElementById('agregar'),

	bookForm: document.getElementById('reservar_turno'),
	appointmentInfo: document.querySelectorAll('.reservar--card'),
	calendar: document.querySelector('.calen-grid'),
	patientInfo: {
		userId: document.querySelector('#id'),
		medicId: document.getElementById('medico_id'),
		dataInput: document.getElementById("selected-day"),
		dataInputTime: document.getElementById("selected-time"),
		pnr: document.getElementById('pnr'),
		name: document.getElementById('nombre'),
		lastName: document.getElementById('apellido'),
		dni: document.getElementById('dni'),
		birthDate: document.getElementById('fecha-nac')
	},
	calenDays: document.querySelectorAll(".calen-dia"),
	CalenHoras: document.querySelectorAll(".horarios"),
	fechaEnUI: document.getElementById("fecha-del-turno"),
	appointmentFormBtns: document.querySelectorAll('.turno-formulario-buttons'),
	btnForMe: document.querySelector('#btn-para-mi'),
	btnPnr: document.querySelector('#btn-pnr'),
	appointmentForm: document.querySelector('#turno-formulario'),
	
	borrarBtns: document.querySelectorAll(".borrar-btn"),
	changePassForm: document.getElementById('cambiar_contraseña_form'),
	changePassBtn: document.getElementById("cambiar_contraseña"),
	

}
let loader = document.createElement('div');
loader.classList.add('loader-active');
loader.innerHTML = '<img src="images/loader.png">'

window.addEventListener('scroll', ()=>{
	let scrollPosition = window.scrollY;
	if (scrollPosition >= 140) {
		DOMelements.header.classList.add('header-collapsed')
		document.body.style.padding = '140px 0 0 0';
	} else {
		DOMelements.header.classList.remove('header-collapsed')
		document.body.style.padding = '0 0 0 0';
	}
})
DOMelements.headerItems.forEach(item => {
	let link = item.childNodes[0].href;
	if (window.location.href == link) {
		item.classList.add('active')
	}
});

function displayDropdown(button, dropdown) {
	button.addEventListener('click', ()=>{
		if (dropdown.style.display == 'block') {
			dropdown.style.display='none';
		} else {
			dropdown.style.display='block';
		}
	});
}


if (DOMelements.dropdownBtn != null) {
	displayDropdown(DOMelements.dropdownBtn, DOMelements.dropdown);
}
// displayDropdown(DOMelements.navDropBtn, DOMelements.navDropdown);


if (DOMelements.nuevoHorarioBtn != null) {
	var filasExistentes = DOMelements.filasExistentes;
	if (filasExistentes.length == 0) {
		var fila = 0;	
	} else {
		var fila = DOMelements.filasExistentes[DOMelements.filasExistentes.length - 1];
		fila = fila.id.split('fila');
		fila = parseInt(fila[1]) + 1;
	}

	DOMelements.nuevoHorarioBtn.addEventListener('click', function() {
		var x = 30; //minutes interval
		var horarios = []; // time array
		var inicio = 7 * 60; // start time
		//loop to increment the time and push results in array
		for (var i = 0; inicio <= (20 * 60); i++) {
			var hh = Math.floor(inicio / 60); // getting hours of day in 0-24 format
			var mm = (inicio % 60); // getting minutes of the hour in 0-55 format
			horarios[i] = ("0" + hh).slice(-2) + ':' + ("0" + mm).slice(-2); // pushing data in array in [00:00 - 12:00 AM/PM format]
			inicio += x;
		}
		
		var nuevaFilaHTML = `
		<div id="nueva-fila${fila}" class="nueva-fila">
			<label>Dia:</label>
				<select class="input-select" name = "fila[${fila}][dia]">
				<option value="lunes">Lunes</option>
				<option value="martes">Martes</option>
				<option value="miercoles">Miercoles</option>
				<option value="jueves">Jueves</option>
				<option value="viernes">Viernes</option>
			</select>
			<br>		
			<label>Desde</label>
			<select class="input-select" name="fila[${fila}][desde]" id="desde${fila}"></select>
		
			<label>Hasta</label>
			<select class="input-select" name="fila[${fila}][hasta]" id="hasta${fila}"></select>
			<br>		
			<label>Duración del turno:</label>
			<select class="input-select" name="fila[${fila}][intervalo]">
				<option value="15">15 Minutos</option>
				<option value="30">30 minutos</option>
			</select>
		</div>`;
		
		DOMelements.nuevoHorarioWrap.insertAdjacentHTML('beforeend', nuevaFilaHTML);
		
		for (let i = 0; i < horarios.length; i++) {
			
			document.getElementById('desde' + fila).innerHTML += '<option value="' + horarios[i] + '">' + horarios[i] + '</option>';
			document.getElementById('hasta' + fila).innerHTML += '<option value="' + horarios[i] + '">' + horarios[i] + '</option>';
		}
		fila++;
		return fila;
	});
}


if (DOMelements.nuevoPrecioBtn != null) {
	var filasExistentes = DOMelements.filasExistentes;
	if (filasExistentes.length == 0) {
		var valor = 0;	
	} else {
		var valor = DOMelements.filasExistentes[DOMelements.filasExistentes.length - 1];
		valor = valor.id.split('fila');
		valor = parseInt(valor[1]) + 1;
	}
	DOMelements.nuevoPrecioBtn.addEventListener('click', function() {
		
		var nuevaFilaHTML = `
		<div id="nueva-fila${valor}" class="nueva-fila">
		
		<label><b>Tipo:</b></label>
		<select class="input-text" name="valor[${valor}][tipo]">
		<option value="Sin obra social">Sin obra social<option>
		<option value="OSDE">OSDE<option>
		<option value="ASUNT">ASUNT<option>
		<option value="GALENO">GALENO<option>
		<option value="SWISS MEDICAL">SWISS MEDICAL<option>
		</select>		
		<label><b>Valor:</b></label>
		<input type="number" class="input-text" name="valor[${valor}][valor]">
		</div>`;
		
		DOMelements.nuevoPrecioWrap.insertAdjacentHTML('beforeend', nuevaFilaHTML);
		
		valor ++;
		return valor;
	});
}

if (DOMelements.borrarFila != null) {
	let precioBorradoCount = 0;
	let horarioBorradoCount = 0;
	DOMelements.borrarFila.forEach(el => {
		el.addEventListener('click', ()=>{
			let id = el.id;
			let parentNode;
			switch (id) {
				case 'borrar-horario':
					parentNode = document.querySelector('#nuevo-horario-wrap');
					let horarioBorrado = parentNode.removeChild(parentNode.lastElementChild);
					horarioBorrado = horarioBorrado.firstElementChild.value;
					if (horarioBorrado != null) {
						DOMelements.nuevoHorarioWrap.insertAdjacentHTML('beforebegin', `
							<input type="hidden" name="horario_borrado_id[${horarioBorradoCount}]" value="${horarioBorrado}">
						`);
						horarioBorradoCount += 1;
					}
					fila -= 1;
					break;
				case 'borrar-precio':
					parentNode = document.querySelector('#nuevo-precio-wrap')
					let valorBorrado = parentNode.removeChild(parentNode.lastElementChild);
					valorBorrado = valorBorrado.firstElementChild.value;
					
					if (valorBorrado != null) {
						DOMelements.nuevoPrecioWrap.insertAdjacentHTML('beforebegin',`
							<input type="hidden" name="precio_borrado_id[${precioBorradoCount}]" value="${valorBorrado}">
						`);
						precioBorradoCount += 1;
					}
					valor -= 1;
					break;
				default:
					break;
				}
		})		
	});
}



if (DOMelements.calenDays != null) {
	DOMelements.calenDays.forEach(function(day) {
		if (day.className  != 'calen-dia dia-bloqueado') {
			day.addEventListener('click',function() {
				
				DOMelements.calenDays.forEach(function(day) {
					day.classList.remove('calen-dia--focus')
				})
				day.classList.add('calen-dia--focus');
				
				let curDataDate = day.dataset.selectedDate;
				DOMelements.patientInfo.dataInput.value = curDataDate;
				DOMelements.fechaEnUI.innerHTML = curDataDate;
				
				loadSchedule(curDataDate);
				
			});
		}
	})
}

function loadSchedule(date) {
	
	// Obtener horarios tomados por Ajax
	
	let ajaxPetition = new XMLHttpRequest();
	ajaxPetition.open('POST', 'traer_horarios.php');

	let medic_id = DOMelements.patientInfo.medic_id.value;
	if (date != '' & medic_id != '') {
		let parameters = 'medico_id=' + medic_id + '&fecha=' + date; 
		
		ajaxPetition.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajaxPetition.send(parameters)
	}
	loadScheduleUI(ajaxPetition, date)
	
}

function loadScheduleUI(petition, date){
	let oldAppointments = document.querySelector('.horarios-modal')
	if (oldAppointments !== null) {

		oldAppointments.parentNode.removeChild(oldAppointments);
	}
	let appointmentsModal = document.createElement('div');
	appointmentsModal.classList.add('horarios-modal');
	DOMelements.calendar.appendChild(appointmentsModal);

	appointmentsModal.appendChild(loader)
	
	petition.onload = ()=>{	
		let data = JSON.parse(petition.responseText);
		let appointmentsWrapper = document.createElement('div');
		appointmentsWrapper.classList.add('wrapper-horarios')
		appointmentsModal.removeChild(loader);
		appointmentsModal.innerHTML += `<b>Turnos disponibles el dia ${date}</b>`;
		appointmentsModal.appendChild(appointmentsWrapper);

		for (let i = 0; i < data.length; i++) {
			const appointment = data[i]['horario'];
			appointmentsWrapper.innerHTML += `
			<a class="calen-dia horarios" data-selected-time="${appointment}">${appointment}</a>
			
			`;
		}
		calenHorasEvents(date);
	} 

}

function calenHorasEvents(date){
	
	calenHoras = document.querySelectorAll(".horarios" );
		
	calenHoras.forEach( (time) => {

		time.addEventListener('click', () => {
			
			calenHoras.forEach(function name(time) {
				time.classList.remove('calen-dia--focus')
			})
			time.classList.add('calen-dia--focus');
			let curDataHora = time.dataset.selectedTime;
			DOMelements.patientInfo.dataInputTime.value = curDataHora;
			
			DOMelements.fechaEnUI.innerHTML = date + ' a las ' + curDataHora;

			let isFormIncomplete;
			if (DOMelements.patientInfo.pnr.value === 'true') {
				for (const input in DOMelements.patientInfo) {
					if (DOMelements.patientInfo[input].value != ''){
						isFormIncomplete = true;
						
					}
				}
			} else if (DOMelements.patientInfo.pnr.value === 'true') {
				
			}
		});
	})

}

function getOffset(el) {
	const rect = el.getBoundingClientRect();
	return {
		top: rect.top + window.scrollY,
		bottom: rect.bottom + window.scrollY
	};
}

if (DOMelements.appointmentFormBtns != null) {

		//parentDiv son los divs adentro del wrapperDiv
	let parentDiv = DOMelements.appointmentFormBtns[0].parentNode
	
	DOMelements.btnPnr.addEventListener('click', ()=>{
			
		wrapperDiv = parentDiv.parentNode,
		wrapperHeight = wrapperDiv.offsetHeight,
		wrapperWidth = wrapperDiv.offsetWidth,
		wrapperOffset = getOffset(wrapperDiv),
		patientForm = document.createElement('div');
		
		patientForm.classList.add('reservar--card');
		
		wrapperDiv.parentNode.style.height = wrapperDiv.parentNode.offsetHeight +'px';
		patientForm.style.bottom = wrapperOffset.bottom +'px';
		patientForm.style.height = wrapperHeight +'px';
		patientForm.style.maxWidth = wrapperWidth +'px';
		patientForm.innerHTML = `
		<b>¿Para quien es el turno?</b>
		<div class="form-paciente">
			<p>Introduzca los datos del paciente</p>
			<input type="text" class="input-text pnr-input" data-content="nombre" placeholder="Nombre" style="margin: 5px 20px;" value="">
			<input type="text" class="input-text pnr-input" data-content="apellido" placeholder="Apellido" style="margin: 5px 20px;" value="">
			<input type="number" class="input-text pnr-input" data-content="dni" placeholder="DNI" style="margin: 5px 20px;" value="">
			<input type="date" class="input-text pnr-input" data-content="fecha_nac" style="margin: 5px 20px;" value="">
			<span id="pnr-errores" class="alert"></span>
			<div class="form-paciente--buttons">
				<span id="pnr-cancelar" class="border-button form-paciente-btn"style="margin: 30px 5px;">Cancelar</span>
				<span id="pnr-guardar" class="border-button form-paciente-btn"style="margin: 30px 5px;">Guardar</span>
			</div>
		</div>
		`;
		patientForm.classList.add('turno-formulario');
		wrapperDiv.style.display = "none";
		wrapperDiv.parentNode.appendChild(patientForm);
		
		let formBtns = document.querySelectorAll('.form-paciente-btn'),
		pnrInput = document.querySelectorAll('.pnr-input');
		
		formBtns.forEach((btn)=>{
			btn.addEventListener('click',()=>{
				
				let pnrBtnId = btn.id;
				if (pnrBtnId == 'pnr-cancelar') {
					wrapperDiv.style.display = "block";
					patientForm.parentNode.removeChild(patientForm);
				} else if (pnrBtnId == 'pnr-guardar') {
					
					DOMelements.patientInfo.pnr.value = 'true';
					
					let pnrInfo = {
						name: '',
						lastName: '',
						dni: '',
						birthdate: ''
					};
					let error = false;

					pnrInput.forEach((input)=>{
						let contentType = input.dataset.content,
						value = input.value;
						
						if (value == ''){
							let errorBox = document.getElementById('pnr-errores');
							errorBox.style.display = 'block';
							errorBox.innerHTML = 'Por favor, rellene todos los campos';
							error = true;
						} else {

							switch (contentType) {
								case 'nombre':
									DOMelements.patientInfo.name.value = value
									pnrInfo.name = value;
									break;
								case 'apellido':
									DOMelements.patientInfo.lastName.value = value
									pnrInfo.lastName = value;
									break;
								case 'dni':
									DOMelements.patientInfo.dni.value = value
									pnrInfo.dni = value;
									break;
								case 'fecha_nac':
									DOMelements.patientInfo.birthDate.value = value
									pnrInfo.birthDate = value;
									break;
							}
											
							
						}
					});
					
					if (error == false) {
						
						pnrCardHtml = `
						<div>
							<b>Datos del paciente</b>
							<div class="pnr-card">
								<div class="flex-center pnr-card--info">
									${pnrInfo.name} ${pnrInfo.lastName}<br>
									<span><b>DNI</b> ${pnrInfo.dni}</span>
								</div>
							</div>
						</div>
					`;
					parentDiv.insertAdjacentHTML('afterBegin', pnrCardHtml)
					wrapperDiv.style.display = "block";
					
					}
				}
				
			});
		})
	})
		DOMelements.btnForMe.addEventListener('click', ()=>{
			
			DOMelements.patientInfo.pnr.value = 'false';

			let ajaxPetition = new XMLHttpRequest();
			ajaxPetition.open('POST', 'ajax_info_usuario.php');
		
			let id = DOMelements.patientInfo.id.value;
			if (id != '') {
				let parameters = 'id=' + user_id; 
				
				ajaxPetition.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
				ajaxPetition.send(parameters)
			}
			loadScheduleUI(ajaxPetition, date)

			console.log('para mi');
			cardHtml = `
			<div>
				<b>Para quien es el turno</b>
				<div class="pnr-card">
				parami
				</div>
			</div>
			`;
			parentDiv.insertAdjacentHTML('afterBegin', cardHtml)

		})

}
	
if (DOMelements.borrarBtns != null) {
	DOMelements.borrarBtns.forEach((btn) => {
		btn.addEventListener('click', () => {

			let btnId, title, text, link, options, HTMLverif;
			btnId = btn.id;
			link = btn.dataset.route;
			switch (btnId) {
				case 'turno':
					title = '¿Esta seguro/a que quiere cancelar su turno?';
					text = 'Si cancela su turno no podra recuperarlo y debera reprogramarlo.';
					options = ['No, conservar turno', 'Si, cancelar turno'];
				break;
				case 'medico':
					title = '¿Estas seguro/a que deseas dar de baja este medico?';
					text = 'Si das de baja a este medico se eliminará por completo y no podrás recuperar la información de este.';
					options = ['No, conservar medico', 'Si, eliminar medico'];
				break;
				case 'especialidad':
					title = '¿Esta seguro/a de que quiere eliminar esta especialidad?';
					text = 'Si la elimina, todos los medicos dentro de esta especialidad no estaran disponibles para el publico.';
					options = ['No, conservar especialidad', 'Si, eliminar especialidad'];				
				break;
			}
			HTMLverif = document.createElement("div");
			document.body.appendChild(HTMLverif);
			HTMLverif.className = ('overlay');
			HTMLverif.innerHTML = `
				<div class="verificacion">
					<div class="flex-center-start verificacion--title">
						${title}
					</div>
					<div class="verificacion--body">
						<p>${text}</p>
					</div>
					<div class="verificacion--buttons">
						<a href="" class="flex-center verificacion--button">${options[0]}</a>
						<a href="${link}" class="flex-center verificacion--danger">${options[1]}</a>
					</div>
				</div>`;
			
		})
	})
}


if (DOMelements.changePassBtn != null) {
	
		DOMelements.changePassBtn.addEventListener('click', ()=>{
			let HTMLverif = document.createElement("div");
			document.body.appendChild(HTMLverif);
		HTMLverif.className = ('overlay');
		HTMLverif.innerHTML = `
		<div class="verificacion">
		<div class="flex-center-start verificacion--title">
		¿Estas seguro que queres cambiar tu contraseña?
		</div>
		<div class="verificacion--body">
		<p>Esta accion no se puede deshacer.</p>
		</div>
		<div class="verificacion--buttons">
		<span class="flex-center verificacion--button">No</span>
		<span class="flex-center verificacion--danger">Si</span>
		</div>
		</div>
		
		`;
		
	});
}
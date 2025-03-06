document.getElementById("btn-logIn").addEventListener("click", iniciarSesion);
document.getElementById("btn-register").addEventListener("click", register);
window.addEventListener("resize", anchoPagina);

// Declaracion de variables
let logIn_Register_container = document.querySelector(".logIn-Register-container");
let logIn_form = document.querySelector(".logIn-form");
let register_form = document.querySelector(".register-form");
let logIn_back_div = document.querySelector(".logIn-back-div");
let register_back_div = document.querySelector(".register-back-div");


function anchoPagina() {

    if (window.innerWidth > 850) {
        logIn_back_div.style.display = "block";
        register_back_div.style.display = "block";
    } else {
        register_back_div.style.display = "block";
        register_back_div.style.opacity = "1";
        logIn_back_div.style.display = "none";
        logIn_form.style.display = "block";
        register_form.style.display = "none";
        logIn_Register_container.style.left = "0px";
    }
}

anchoPagina(); // al recargar la pagina se aplica la funcion tambien

// funcion que oculta el formulario de registro
function iniciarSesion() {

    if (window.innerWidth > 850) {
        register_form.style.display = "none";
        logIn_Register_container.style.left = "10px";
        logIn_form.style.display = "block";
        register_back_div.style.opacity = "1";
        logIn_back_div.style.opacity = "0";
    } else {
        register_form.style.display = "none";
        logIn_Register_container.style.left = "0px";
        logIn_form.style.display = "block";
        register_back_div.style.display = "block";
        logIn_back_div.style.display = "none";
    }
}

// funcion que oculta el formulario de iniciar sesion
function register() {

    if (window.innerWidth > 850) {
        register_form.style.display = "block";
        logIn_Register_container.style.left = "410px";
        logIn_form.style.display = "none";
        register_back_div.style.opacity = "0";
        logIn_back_div.style.opacity = "1";
    } else {
        register_form.style.display = "block";
        logIn_Register_container.style.left = "0px";
        logIn_form.style.display = "none";
        register_back_div.style.display = "none";
        logIn_back_div.style.display = "block";
        logIn_back_div.style.opacity = "1";
    }
}

/*-----------------------------------------------*/
/* Validacion de campos con expresiones regulares*/
/*-----------------------------------------------*/

const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');

const expresiones = {
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/ // 7 a 14 numeros.
}

const campos = {
	nombre: false,
	apellido: false,
	password: false,
	correo: false,
	telefono: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;

		case "apellido":
			validarCampo(expresiones.apellido, e.target, 'apellido');
		break;

		case "password":
			validarCampo(expresiones.password, e.target, 'password');
			validarPassword2();
		break;

		case "password2":
			validarPassword2();
		break;

		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
		break;

		case "telefono":
			validarCampo(expresiones.telefono, e.target, 'telefono');
		break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;
	}
}

const validarPassword2 = () => {
	const inputPassword1 = document.getElementById('password');
	const inputPassword2 = document.getElementById('password2');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`grupo__password2`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__password2 i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__password2 i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__password2 .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos['password'] = false;
	} else {
		document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__password2`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__password2 i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__password2 i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__password2 .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos['password'] = true;
	}
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});


/*
formulario.addEventListener('submit', (e) => {
	e.preventDefault();

	if(campos.nombre && campos.apellido && campos.password && campos.password && campos.correo){
		formulario.reset();

		document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo');
		setTimeout(() => {
			document.getElementById('formulario__mensaje-exito').classList.remove('formulario__mensaje-exito-activo');
		}, 5000);

		document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
	} else {
		document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
	}

});
*/

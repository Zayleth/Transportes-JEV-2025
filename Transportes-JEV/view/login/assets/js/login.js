const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});



/*-----------------------------------------------*/
/* Validacion de campos con expresiones regulares*/
/*-----------------------------------------------*/

const formulario = document.getElementById('formulario');
const entrada = document.querySelectorAll('#formulario input');

const expresiones = {
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	password: /^.{8,50}$/ // 8 a 50 digitos.
	//apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	//telefono: /^\d{7,14}$/ // 7 a 14 numeros.
}

const campos = {
	nombre: false,
	correo: false,
	password: false
	//apellido: false,
	//telefono: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;

		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
		break;

		case "password":
			validarCampo(expresiones.password, e.target, 'password');
			validarPassword2();
		break;

		/*
		case "apellido_usuario":
			validarCampo(expresiones.apellido, e.target, 'apellido');
		break;
		*/

		/*
		case "password2":
			validarPassword2();
		break;
		*/

		/*
		case "telefono":
			validarCampo(expresiones.telefono, e.target, 'telefono');
		break;
		*/

	}
}

/*
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

*/


const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} .formulario__validacion-estado`).classList.add('fa-check-circle');
        document.querySelector(`#grupo__${campo} .formulario__validacion-estado`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
        campos[campo] = true;
    } else {
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} .formulario__validacion-estado`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__validacion-estado`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
        campos[campo] = false;
    }
};


/*

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

*/

entrada.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});


/* Funcionalidad - ojo password */
const pass = document.getElementById("password");
const icono = document.getElementById("password-eye");

icono.addEventListener("click", () => {
    if (pass.type === "password") {
        pass.type = "text"; // Cambia el tipo a texto para mostrar la contraseña
        icono.classList.remove("fa-eye"); // Elimina la clase de ojo abierto
        icono.classList.add("fa-eye-slash"); // Agrega la clase de ojo cerrado
    } else {
        pass.type = "password"; // Cambia el tipo a contraseña para ocultarla
        icono.classList.remove("fa-eye-slash"); // Elimina la clase de ojo cerrado
        icono.classList.add("fa-eye"); // Agrega la clase de ojo abierto
    }
});



// Al redirigir al usuario nuevamente al index Log In. Cae directamente en el register form con el "mensaje de error"
// Al redirigir al usuario nuevamente al index Log In. Cae directamente en el register form con el "Registro Exitoso"
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);

    // Detecta si el parámetro "show=register" está en la URL
    if (params.get("show") === "register") {
        const main = document.querySelector("main"); // Selecciona el contenedor principal
        if (main) {
            main.classList.add("sign-up-mode"); // Muestra el formulario de registro

            // Mostrar el mensaje de error si "error" está presente
            const errorMessage = params.get("error");
            if (errorMessage === "correoExistente") {
                const errorDiv = document.querySelector(".error-message");
                if (errorDiv) {
                    errorDiv.textContent = "El correo ya está registrado. Por favor, utiliza otro.";
                    errorDiv.style.display = "block"; // Asegúrate de mostrar el mensaje de error
                
				} else {
					// Asegúrate de ocultar el mensaje si no hay error
					const errorDiv = document.querySelector(".error-message");
					if (errorDiv) {
						errorDiv.style.display = "none";
					}	
            	}

            // Mostrar el mensaje de éxito si "usuarioRegistrado" está presente
            const successMessage = params.get("usuarioRegistrado");
            if (successMessage === "1") {
				console.log("Registro Exitoso");
            }

			// Mostrar el mensaje de error si -> registroFallido
            const failMessage = params.get("errorRegistro");
            if (failMessage === "2") {
				console.log("¡Ups! Registro fallido. Intenta nuevamente.");
            }

        	}
    	}
	}
});


// Limpiar el "mensaje de error" cuando el usuario empiece a escribir en el input (correo)
document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.getElementById("correo"); // Selecciona el input de correo
    const errorDiv = document.querySelector(".error-message"); // Selecciona el contenedor del mensaje de error

    // Evento para ocultar el mensaje de error cuando el usuario escribe
    emailInput.addEventListener("input", () => {
        if (errorDiv) {
        	errorDiv.style.display = "none"; // Oculta el mensaje de error
            errorDiv.textContent = ""; // Limpia el contenido del mensaje
        }
    });
});

// Eliminación de "Usuario registrado correctamente" luego de 10s
document.addEventListener("DOMContentLoaded", () => {
	const successMessage = document.querySelector(".success-message");
	const failMessage = document.querySelector(".failed-registration-message");
  
	if (successMessage) {
	  setTimeout(() => {
		successMessage.style.display = "none"; // Oculta el mensaje después de 10 segundos
	  }, 10000); // 10000 ms = 10 segundos
	}

	if (failMessage) {
		setTimeout(() => {
		  failMessage.style.display = "none"; // Oculta el mensaje después de 10 segundos
		}, 10000); // 10000 ms = 10 segundos
	}

});
  
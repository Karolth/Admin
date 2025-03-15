// const usuarioValido ="admin";
// const passwordValida ="1234";
let intentosRestantes =3;

function iniciarSesion() {
    const action = "login";
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    let mensaje = document.getElementById("mensajeLogin");

    fetch("/AdminPanel/PHP/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action, username, password }) // Corregido: username -> documento
    })
    .then(response => response.json())
    .then(data => {
        const mensaje = document.getElementById("mensajeLogin");
        if (data.success) {
            mensaje.style.color = "green";
            mensaje.textContent = "¡Inicio de sesión exitoso!";
            setTimeout(() => {
                window.location.href = "../HTML/admin.php";
            }, 1000);
        } else {
            intentosRestantes--;
            mensaje.style.color = "red";
            mensaje.textContent = `Usuario o contraseña incorrectos. Intentos restantes: ${intentosRestantes}`;
           
            if (intentosRestantes === 0) {
                mensaje.textContent = "Cuenta bloqueada. Intenta más tarde.";
                document.getElementById("login").elements["username"].disabled = true;
                document.getElementById("login").elements["password"].disabled = true;
            }
            }
}) 
.catch(error => {
    console.error("Error:", error);
    mensaje.style.color = "red";
    document.getElementById("mensajeLogin").textContent = "Error al iniciar sesión";
});
}



function toggleForms() {
    const loginFormContainer = document.getElementById("container-form");
    const registerFormContainer = document.getElementById("container-registro");

    if (loginFormContainer.style.display === "none") {
        loginFormContainer.style.display = "block";
        registerFormContainer.style.display = "none";
    } else {
        loginFormContainer.style.display = "none";
        registerFormContainer.style.display = "block";
    }
}

// Función para enviar datos de registro
function registro() {
    const action = "register";
    const nombre = document.getElementById("nombre_usuario").value;
    const apellido = document.getElementById("apellido_usuario").value;
    const email = document.getElementById("email_usuario").value;
    const password = document.getElementById("password_usuario").value;
    const telefono = document.getElementById("telefono_usuario").value;
    const direccion = document.getElementById("direccion_usuario").value;
    const rol = document.getElementById("rol_usuario").value;

    fetch("/AdminPanel/PHP/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action, nombre, apellido, email, password, telefono, direccion, rol })
    })
    .then(response => response.json())
    .then(data => {
        const mensajeRegistro = document.getElementById("mensajeRegistro");
        if (data.success) {
            mensajeRegistro.style.color = "green";
            mensajeRegistro.textContent = "¡Registro exitoso! Ahora puedes iniciar sesión.";
        } else {
            mensajeRegistro.style.color = "red";
            mensajeRegistro.textContent = "Error: " + data.message;
        }
    })
    .catch(error => {
        mensajeRegistro.style.color = "red";
        mensajeRegistro.style.color = "red";
        document.getElementById("mensajeRegistro").textContent = "Error en el registro";
    });
}

function mostrarPerfil() {
    document.getElementById("overlay").style.display="block";
    document.getElementById("perfilModal").style.display="block";
    const action = "getPerfil";
    fetch("/AdminPanel/PHP/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            
            document.getElementById("nombre_usuario_perfil").value = data.nombre;
            document.getElementById("apellido_usuario_perfil").value = data.apellido;
            document.getElementById("email_usuario_perfil").value = data.email;
            document.getElementById("telefono_usuario_perfil").value = data.telefono;
            document.getElementById("direccion_usuario_perfil").value = data.direccion;
            document.getElementById("rol_usuario_perfil").value = data.rol;
            

        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Hubo un problema al obtener los datos del perfil.");
    });
    
}
function cerrarPerfil() {
    // Ocultar el overlay
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('perfilModal').style.display = 'none';
    
   
}
function habilitar() {
    document.getElementById("nombre_usuario_perfil").disabled = false;
    document.getElementById("apellido_usuario_perfil").disabled = false;
    document.getElementById("email_usuario_perfil").disabled = false;
    document.getElementById("telefono_usuario_perfil").disabled = false;
    document.getElementById("direccion_usuario_perfil").disabled = false;
    document.getElementById("rol_usuario_perfil").disabled = false;
}

function modificarPerfil() {
  const action = "modificar";
  const nombre = document.getElementById("nombre_usuario_perfil").value;
  const apellido = document.getElementById("apellido_usuario_perfil").value;
  const email = document.getElementById("email_usuario_perfil").value;
  const telefono = document.getElementById("telefono_usuario_perfil").value;
  const direccion = document.getElementById("direccion_usuario_perfil").value;
  const rol = document.getElementById("rol_usuario_perfil").value;

  fetch("/AdminPanel/PHP/login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ action, nombre, apellido, email, telefono, direccion , rol })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Se modificó datos del usuario con éxito");
        document.getElementById("nombre_usuario_perfil").disabled = true;
        document.getElementById("apellido_usuario_perfil").disabled = true;
        document.getElementById("email_usuario_perfil").disabled = true;
        document.getElementById("telefono_usuario_perfil").disabled = true;
        document.getElementById("direccion_usuario_perfil").disabled = true;
        document.getElementById("rol_usuario_perfil").disabled = true;
      } else {
        alert("Error en el registro");
    }
    })
    .catch(error => {
      console.error("Error al modificar el perfil:", error);
      alert("Error al modificar el perfil. Por favor, inténtalo de nuevo más tarde.");
    });
    
    
}

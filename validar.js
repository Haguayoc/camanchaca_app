function validarRut(rut) {
    // Expresión regular para validar RUT sin guión ni dígito verificador, de 1 a 8 dígitos
    const rutRegex = /^[0-9]{1,8}$/;
    return rutRegex.test(rut);
}

function validarContraseña(password) {
    // Expresión regular para validar contraseñas con 0 a 5 números y sin letras ni caracteres especiales
    const contraseñaRegex = /^[0-9]{1,5}$/;
    return contraseñaRegex.test(password);
}

const rutInput = document.getElementById("rut");
const contraseñaInput = document.getElementById("password");
const mensajeRut = document.getElementById("mensajeRut");
const mensajeContraseña = document.getElementById("mensajeContraseña");

rutInput.addEventListener("input", function() {
    const rut = rutInput.value;
    if (validarRut(rut)) {
        mensajeRut.innerHTML = "RUT válido";
        mensajeRut.classList.add("alert", "alert-success");
        mensajeRut.classList.remove("alert-danger");
    } else {
        mensajeRut.innerHTML = "RUT inválido. Debe escribir el RUT sin puntos (.) ni guion (-) ni dígito verificador (0-K)";
        mensajeRut.classList.add("alert", "alert-danger");
        mensajeRut.classList.remove("alert-success");
    }
});

contraseñaInput.addEventListener("input", function() {
    const contraseña = contraseñaInput.value;
    if (validarContraseña(contraseña)) {
        mensajeContraseña.innerHTML = "Contraseña válida";
        mensajeContraseña.classList.add("alert", "alert-success");
        mensajeContraseña.classList.remove("alert-danger");
    } else {
        mensajeContraseña.innerHTML = "Contraseña inválida.";
        mensajeContraseña.classList.add("alert", "alert-danger");
        mensajeContraseña.classList.remove("alert-success");
    }
});
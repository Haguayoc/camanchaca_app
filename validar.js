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
let aux = '';
rutInput.addEventListener("input", function(e) {
    console.log(e)
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
    if(e.inputType == 'deleteContentBackward') return;
    rutInput.value = rutInput.value.replace(/-/g, '');

    let rut_temp = rutInput.value.split('');
    rut_temp[rut_temp.length-2] = '';
    let dv = ingresarDV(rut_temp.join(''));
    console.log(rut_temp);
    rutInput.value =  rut_temp.join('') + '-' + dv;
});
rutInput.onkeydown = (e)=>{return (e.keyCode >= 48 && e.keyCode <=57 || e.key =='K' || e.key == 'k' || e.key == 'Backspace' || e.key == 'Enter' || e.key == 'Tab')};;
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


function ingresarDV(rut_validar) {
    let rut = rut_validar.split('-')[0];
    let rut_list = rut.split('').reverse();
    let x = 2;
    let aux = 0;
    for(let i = 0; i< rut_list.length; i++){
        if(x==8) x=2;
        aux += rut_list[i] * x;
        x++;
    }
    let total = aux;
    let dv_valido = 11 - (total - (Math.floor(aux/11) * 11)) ;
    if(dv_valido==11) dv_valido = 0;
    if(dv_valido==10) dv_valido = 'K';
    return dv_valido;
}
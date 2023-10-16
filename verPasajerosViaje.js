const btnAbrirPopup = document.getElementById('abrirPopup');
 const popup = document.getElementById('miPopup');
 const btnCerrarPopup = document.getElementById('cerrarPopup');

const buttons = document.querySelectorAll('#btnVerPasajerosViaje');
const dataTable = document.getElementById('data');
const fechaViaje = document.getElementById('fechaViaje');
const conductorViaje = document.getElementById('conductorViaje');
buttons.forEach(button => {
  button.addEventListener('click', ()=>{
    popup.style.display = 'block';
    let id_grupo = button.getAttribute("data-id-grupo")
    let fecha = button.parentElement.parentElement.children[0].innerText;
    let nombre = button.parentElement.parentElement.children[1].innerText.split(' ');
    let conductor = nombre[0] + ' ' + nombre[1];
    let htmlTable = '';
    fetch('/camanchaca_app/controlador/controlador_obtener_grupo.php?id_grupo='+id_grupo)
    .then(res => {
      res.json()
      .then(data => {
        data.forEach(x => {
          fechaViaje.innerText = 'Fecha: ' + fecha;
          conductorViaje.innerText = conductor;
          htmlTable+= `<tr>
            <td>${x[1]}</td>
            <td>${x[0]}</td>
            <td>${x[2]}</td>
            <td>${x[4]}</td>
            <td>${x[3]}</td>
          </tr>`
        })
        dataTable.innerHTML = htmlTable;
        document.querySelector('.modal-table').style.display = 'flex';
        
      })
    })

  })
})


 // Obtener elementos del DOM
 

 
 // Agregar evento al botón de cerrar para cerrar el popup
 btnCerrarPopup.addEventListener('click', () => {
   popup.style.display = 'none';
 });
 
 // Cerrar el popup si se hace clic fuera del contenido del popup
 window.addEventListener('click', (event) => {
   if (event.target === popup) {
     popup.style.display = 'none';
   }
 });

const btnIda = document.getElementById('ida');
const btnVuelta = document.getElementById('vuelta');
const btnAll = document.getElementById('todos');
const tables = document.querySelectorAll('.table-responsive');
btnIda.addEventListener('click', () => {
  tables[0].style.display = 'block';
  tables[1].style.display = 'none';
})
btnVuelta.addEventListener('click', () => {
  tables[1].style.display = 'block';
  tables[0].style.display = 'none';
})
btnAll.addEventListener('click', () => {
  tables[0].style.display = 'block';
  tables[1].style.display = 'block';
})
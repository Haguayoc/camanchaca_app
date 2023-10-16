const btnAbrirPopup = document.getElementById('abrirPopup');
 const popup = document.getElementById('miPopup');
 const btnCerrarPopup = document.getElementById('cerrarPopup');

const buttons = document.querySelectorAll('#btnVerPasajerosViaje');
const dataTable = document.getElementById('data');
buttons.forEach(button => {
  button.addEventListener('click', ()=>{
    popup.style.display = 'block';
    let id_grupo = button.getAttribute("data-id-grupo")
    let htmlTable = '';
    fetch('/camanchaca_app/controlador/controlador_obtener_grupo.php?id_grupo='+id_grupo)
    .then(res => {
      res.json()
      .then(data => {
        data.forEach(x => {
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
document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
})

function iniciarApp(){
    buscarPorFecha(); 
}

function buscarPorFecha(){
    const fecha = document.querySelector('#fecha'); 
    fecha.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;
        console.log(fechaSeleccionada);

        window.location =  `?fecha=${fechaSeleccionada}`;
    })
}
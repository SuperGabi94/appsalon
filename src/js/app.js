let paso = 1; 
const pasoInicial = 1; 
const pasoFinal = 3; 

const cita = {
    nombre: '', 
    fecha: '', 
    hora: '', 
    usuarioid:'',
    servicios: []

};

document.addEventListener('DOMContentLoaded', () => {
    iniciarApp(); 
})

function iniciarApp() {
    mostrarSeccion(paso);
    tabs();
    botonesPaginador();
    paginaSiguiente(); 
    paginaAnterior();
    consultarApi(); 
    nombreCliente(); 
    idCliente();
    asignarFecha();
    seleccionarHora(); 
    mostrarResumen(); 

}


function mostrarSeccion(paso) {
    //Ocultar la seccion que tenga la clase de mostra
    let seccionAnterior = document.querySelector('.mostrar'); 
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
   

    //Selecionar la seccion con el paso 
    let seccionActual = document.querySelector(`#paso-${paso}`); 
    seccionActual.classList.add('mostrar'); 

    //Resaltar el tab actual 
    const tab = document.querySelector(`[data-paso="${paso}"]`); 
    tab.classList.add('actual');

}

function tabs(){
    let botones = document.querySelectorAll('.tabs button'); 
   

    botones.forEach(boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso);
              mostrarSeccion(paso);
              botonesPaginador();
        })
    })
}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1 ) {
        paginaAnterior.classList.add('ocult');
        paginaSiguiente.classList.remove('ocult');
    } else if(paso === 3) {
        mostrarResumen(); 
        paginaAnterior.classList.remove('ocult');
        paginaSiguiente.classList.add('ocult');
    } else {
        paginaAnterior.classList.remove('ocult');
        paginaSiguiente.classList.remove('ocult');
    }
    mostrarSeccion(paso);
}


function paginaAnterior() {
    const botonAnterior = document.querySelector('#anterior'); 

    botonAnterior.addEventListener( 'click', function(){
        if(paso <= pasoInicial) {
            return; 
        }
        paso--;
        botonesPaginador(); 

     console.log(paso);
    }
    
    )
    
    
}

function paginaSiguiente(){
    const botonSiguiente = document.querySelector('#siguiente'); 

    botonSiguiente.addEventListener( 'click', function(){
        
        if(paso >= pasoFinal) {
            return; 
        }
        paso++;
        botonesPaginador(); 

     console.log(paso);
    }
    
    )
}


async function consultarApi() {

    try {
        const url = '/api/servicios'; 
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios); 
        

    } catch (error) {
        console.log(error); 
        
    }
    
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
       const {id, nombre, precio} = servicio; 

        //Nombre del servicio
       const nombreServicio = document.createElement('P');
       nombreServicio.classList.add('nombre-servicio'); 
       nombreServicio.textContent = nombre; 
     
       
       //Precio del servicio 
       const precioServicio = document.createElement('P');
       precioServicio.classList.add('precio-servicio'); 
       precioServicio.textContent = '$' + precio; 
      

       //Crear el div contenedor
       const servicioDiv = document.createElement('DIV'); 
       servicioDiv.classList.add('servicio'); 
       servicioDiv.appendChild(nombreServicio);
       servicioDiv.appendChild(precioServicio); 
       servicioDiv.dataset.idServicio = id; 
       servicioDiv.onclick = function(){
        selecionarServicio(servicio)
       }

       //Añadir  a la vista

       const contenedor = document.querySelector('#servicios'); 
       contenedor.appendChild(servicioDiv)

    } )

}


function selecionarServicio(servicio){

    const {id} = servicio;
    const {servicios} = cita; 
    const divServicio = document.querySelector(`[data-id-servicio = "${id}"]`);

    //Comprobar si un servicio ya esta agregado 
    if(servicios.some(agregado => agregado.id === id)) {
        cita.servicios = servicios.filter(agregado => agregado.id !== id ); 
        
        divServicio.classList.remove('seleccionado'); 
    } else {
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado'); 
    }

    
  
    console.log(cita);
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
    
}

function idCliente() {
    cita.usuarioid = document.querySelector('#id').value;
    
}

function asignarFecha() {
    const inputFecha = document.querySelector('#fecha'); 
    inputFecha.addEventListener('input', function(e) {
        const dia = new Date(e.target.value).getUTCDay(); 
        if([0, 6].includes(dia)){
            e.target.value = '';
            mostrarAlerta('No trabajamos Sábados y Domingos', 'error', '.formulario'); 
        } else {
            cita.fecha = e.target.value;
        }
    })
}


function seleccionarHora(){
    const input = document.querySelector('#hora'); 
    input.addEventListener('input', function(e){
        const horaForm = e.target.value; 
        const hora = horaForm.split(':')[0]; 
        if(hora < 9 || hora > 18  ){
            mostrarAlerta('Elige una hora entre las 9am y 6pm', 'error', '.formulario');
            e.target.value = '';
        } else {
            cita.hora = horaForm; 
            
        }
    })
}

 function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    const alertaPrevia = document.querySelector('.alerta'); 
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV'); 
    alerta.textContent = mensaje; 
    alerta.classList.add('alerta', tipo); 

    const formulario = document.querySelector(elemento); 
    formulario.appendChild(alerta);

    if(desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
   
}

function mostrarResumen(){
    const resumen = document.querySelector('#paso-3'); 
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild); 
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Hacen falta agregar datos o servicios', 'error', '.contenido-resumen', false); 
        return;
    } 
    const {nombre, fecha, hora, servicios} = cita; 
    
    const HeadingServicios = document.createElement('H3'); 
    HeadingServicios.textContent = 'Servicios agregados'; 
    resumen.appendChild(HeadingServicios);

    servicios.forEach(servicio => {
        
        const servicioDiv = document.createElement('DIV'); 
        servicioDiv.classList.add('contenedor-servicio')
        const nombreServicio = document.createElement('P'); 
        nombreServicio.textContent = servicio.nombre; 
        const precioServicio = document.createElement('P'); 
        precioServicio.innerHTML =  `<span>Precio:</span> $${servicio.precio}`; 
        
        servicioDiv.appendChild(nombreServicio); 
        servicioDiv.appendChild(precioServicio); 
        resumen.appendChild(servicioDiv); 

    });

    const HeadingDatos = document.createElement('H3'); 
    HeadingDatos.textContent = 'Información de la cita'; 
    resumen.appendChild(HeadingDatos);

   
    const nombreCita = document.createElement('P'); 
    nombreCita.innerHTML = `<span>Nombre:</span> ${nombre}`; 

    //Formatear la fecha en español
    const fechaObj = new Date(fecha); 
    const mes = fechaObj.getMonth();  
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear(); 
    const fechaUTC = new Date(Date.UTC(year, mes, dia)); 
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', {weekday: 'long', month:'long', day: 'numeric', year:'numeric'})


    const fechaCita = document.createElement('P'); 
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`; 

    const horaCita = document.createElement('P'); 
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`; 

    //Boton para reservar cits 
    const boton = document.createElement('BUTTON'); 
    boton.classList.add('boton'); 
    boton.textContent = 'RESERVAR CITA'; 
    boton.onclick = reservarCita;

    resumen.appendChild(nombreCita); 
    resumen.appendChild(fechaCita); 
    resumen.appendChild(horaCita); 
    resumen.appendChild(boton);

}

async function reservarCita(){

    const {nombre, fecha, hora, servicios, usuarioid} = cita; 
    const datos = new FormData();
    const idServicios = servicios.map(servicio => servicio.id)
    datos.append('nombre', nombre); 
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioid', usuarioid);
    datos.append('servicios', idServicios);


    const url = '/api/cita';  
    const respuesta = await fetch(url, {
        method: 'POST', 
        body: datos
    });
    const resultado = await respuesta.json(); 

    try {
        if(resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Has creado tu cita correctamente",
              }).then( () => {
                    setTimeout(() => {
                        window.location.reload(); 
                    }, 1000);
                    
              })
        }
      
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Cita no creada",
            text: "Ocurrio un error y no pudimos agregar tu cita",
          })
        
    }

    


    //Truco para ver lo que se esta enviados 
   // console.log([...datos]); 
}
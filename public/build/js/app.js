let paso=1;const pasoInicial=1,pasoFinal=3,cita={nombre:"",fecha:"",hora:"",usuarioid:"",servicios:[]};function iniciarApp(){mostrarSeccion(paso),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarApi(),nombreCliente(),idCliente(),asignarFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(e){let t=document.querySelector(".mostrar");t&&t.classList.remove("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual"),document.querySelector(`#paso-${e}`).classList.add("mostrar");document.querySelector(`[data-paso="${e}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach((e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(paso),botonesPaginador()}))}))}function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocult"),t.classList.remove("ocult")):3===paso?(mostrarResumen(),e.classList.remove("ocult"),t.classList.add("ocult")):(e.classList.remove("ocult"),t.classList.remove("ocult")),mostrarSeccion(paso)}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador(),console.log(paso))}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador(),console.log(paso))}))}async function consultarApi(){try{const e="/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach((e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$"+a;const r=document.createElement("DIV");r.classList.add("servicio"),r.appendChild(n),r.appendChild(c),r.dataset.idServicio=t,r.onclick=function(){selecionarServicio(e)};document.querySelector("#servicios").appendChild(r)}))}function selecionarServicio(e){const{id:t}=e,{servicios:o}=cita,a=document.querySelector(`[data-id-servicio = "${t}"]`);o.some((e=>e.id===t))?(cita.servicios=o.filter((e=>e.id!==t)),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado")),console.log(cita)}function nombreCliente(){cita.nombre=document.querySelector("#nombre").value}function idCliente(){cita.usuarioid=document.querySelector("#id").value}function asignarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[0,6].includes(t)?(e.target.value="",mostrarAlerta("No trabajamos Sábados y Domingos","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value,o=t.split(":")[0];o<9||o>18?(mostrarAlerta("Elige una hora entre las 9am y 6pm","error",".formulario"),e.target.value=""):cita.hora=t}))}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta",t);document.querySelector(o).appendChild(c),a&&setTimeout((()=>{c.remove()}),3e3)}function mostrarResumen(){const e=document.querySelector("#paso-3");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Hacen falta agregar datos o servicios","error",".contenido-resumen",!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("H3");c.textContent="Servicios agregados",e.appendChild(c),n.forEach((t=>{const o=document.createElement("DIV");o.classList.add("contenedor-servicio");const a=document.createElement("P");a.textContent=t.nombre;const n=document.createElement("P");n.innerHTML=`<span>Precio:</span> $${t.precio}`,o.appendChild(a),o.appendChild(n),e.appendChild(o)}));const r=document.createElement("H3");r.textContent="Información de la cita",e.appendChild(r);const i=document.createElement("P");i.innerHTML=`<span>Nombre:</span> ${t}`;const s=new Date(o),d=s.getMonth(),l=s.getDate()+2,u=s.getFullYear(),m=new Date(Date.UTC(u,d,l)).toLocaleDateString("es-MX",{weekday:"long",month:"long",day:"numeric",year:"numeric"}),p=document.createElement("P");p.innerHTML=`<span>Fecha:</span> ${m}`;const v=document.createElement("P");v.innerHTML=`<span>Hora:</span> ${a}`;const f=document.createElement("BUTTON");f.classList.add("boton"),f.textContent="RESERVAR CITA",f.onclick=reservarCita,e.appendChild(i),e.appendChild(p),e.appendChild(v),e.appendChild(f)}async function reservarCita(){const{nombre:e,fecha:t,hora:o,servicios:a,usuarioid:n}=cita,c=new FormData,r=a.map((e=>e.id));c.append("nombre",e),c.append("fecha",t),c.append("hora",o),c.append("usuarioid",n),c.append("servicios",r);const i=await fetch("/api/cita",{method:"POST",body:c}),s=await i.json();try{s.resultado&&Swal.fire({icon:"success",title:"Cita creada",text:"Has creado tu cita correctamente"}).then((()=>{setTimeout((()=>{window.location.reload()}),1e3)}))}catch(e){Swal.fire({icon:"error",title:"Cita no creada",text:"Ocurrio un error y no pudimos agregar tu cita"})}}document.addEventListener("DOMContentLoaded",(()=>{iniciarApp()}));
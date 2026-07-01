import clientController from "./controller.js";
import clientService from "./service.js";

document.addEventListener("DOMContentLoaded", function() {
    const formulario = document.getElementById("client-form");
    const inputTipo = document.getElementById("tipo");
    const idCliente = document.getElementById("client-id").value;
    const botonEditar = document.getElementById("btn-editar");
    const botonActualizar = document.getElementById("btn-actualizar");
    const botonCancelar = document.getElementById("btn-cancelar");
    const botonEliminar = document.getElementById("btn-eliminar"); 
    const campos = document.querySelectorAll(".form-control, .form-select");


    if (inputTipo) {
        clientController.toggleCamposTipo(inputTipo.value);
    }

    if (botonEditar && botonActualizar && botonCancelar) {

        botonEditar.addEventListener("click", function() {
            campos.forEach(campo => campo.disabled = false);
            
            botonEditar.classList.add("d-none");
            botonActualizar.classList.remove("d-none");
            botonCancelar.classList.remove("d-none");

            if (inputTipo.value === 'Particular') {
                document.getElementById("apellido").focus();
            } else {
                document.getElementById("razon_social").focus();
            }
        });
        
        botonCancelar.addEventListener("click", function() {
            if(formulario) {
                formulario.reset();
                clientController.toggleCamposTipo(inputTipo.value);
            }
            campos.forEach(campo => campo.disabled = true);
            botonActualizar.classList.add("d-none");
            botonCancelar.classList.add("d-none");
            botonEditar.classList.remove("d-none");
        });

        botonActualizar.addEventListener("click", async function(evento) {
            evento.preventDefault();
            
            if (!formulario.checkValidity()) {
                formulario.reportValidity();
                return;
            }

            const data = Object.fromEntries(new FormData(formulario));
            data.id = idCliente;

            data.tipo = inputTipo.value;

            const response = await clientService.update(data); 
            
            if (response.success) {
                alert("Cliente actualizado correctamente.");
                campos.forEach(campo => campo.disabled = true);
                botonActualizar.classList.add("d-none");
                botonCancelar.classList.add("d-none");
                botonEditar.classList.remove("d-none");
            } else {
                alert("Error: " + response.message);
            }
        });
    }

    if (botonEliminar) {
        botonEliminar.addEventListener("click", async function() {
            const verificado = confirm("¿Estás seguro de que deseas eliminar este cliente? (No se borrarán sus ventas históricas).");
            if (verificado) {
                const response = await clientService.delete(idCliente);
                if (response.success) {
                    window.location.href = window.APP_URL + 'client';
                } else {
                    alert("Error: " + response.message);
                }
            }
        });
    }
});
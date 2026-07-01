import itemController from "./controller.js";

document.addEventListener("DOMContentLoaded", async function() {
    await itemController.init();
    async function cargarItem() {
        const itemId = parseInt(document.getElementById('item-id').value);
        if (itemId > 0) {
            const response = await fetch(window.APP_URL + 'item/load', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: itemId })
            });
            const data = await response.json();
            if (data.success && data.data) {
                const item = data.data;
                document.getElementById('codigo').value = item.codigo || '';
                document.getElementById('nombre').value = item.nombre || '';
                document.getElementById('categoria').value = item.categoriaId || '';
                document.getElementById('precio').value = item.precio || '';
                document.getElementById('stock').value = item.stock || '';
                document.getElementById('descripcion').value = item.descripcion || '';
            }
        }
    }

    cargarItem();
    
    const botonEditar = document.getElementById("btn-editar");
    const botonActualizar = document.getElementById("btn-actualizar");
    const botonCancelar = document.getElementById("btn-cancelar");
    
    const botonEliminar = document.getElementById("btn-eliminar"); 
    
    const campos = document.querySelectorAll(".form-control, .form-select");
    const formulario = document.querySelector("form");

    if (botonActualizar && botonCancelar && botonEditar) {
        
        botonEditar.addEventListener("click", function() {
            campos.forEach(campo => campo.disabled = false);
            botonEditar.classList.add("d-none");
            botonActualizar.classList.remove("d-none");
            botonCancelar.classList.remove("d-none");
            document.getElementById("nombre").focus(); 
        });

        botonCancelar.addEventListener("click", async function() {
            if(formulario) formulario.reset();
            await cargarItem();
            campos.forEach(campo => campo.disabled = true);
            botonActualizar.classList.add("d-none");
            botonCancelar.classList.add("d-none");
            botonEditar.classList.remove("d-none");
        });

        botonActualizar.addEventListener("click", async function(evento) {
            evento.preventDefault();
            
            const exito = await itemController.update(); 
            
            if (exito) {
                campos.forEach(campo => campo.disabled = true);
                botonActualizar.classList.add("d-none");
                botonCancelar.classList.add("d-none");
                botonEditar.classList.remove("d-none");
            }
        });

        if (botonEliminar) {
            botonEliminar.addEventListener("click", function(evento) {
                evento.preventDefault();
                const idActual = parseInt(document.getElementById('item-id').value);
                itemController.delete(idActual);
            });
        }
    }
});
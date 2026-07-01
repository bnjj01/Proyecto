import categoryController from "./controller.js";

document.addEventListener("DOMContentLoaded", async function() {
    
  
    await categoryController.list();


    const formCategoria = document.getElementById("form-categoria");
    if (formCategoria) {
        formCategoria.addEventListener("submit", async function(e) {
            e.preventDefault(); // Evita que la página se recargue
            const formData = new FormData(formCategoria);
            await categoryController.save(formData);
        });
    }


    const formFiltros = document.getElementById("form-filtros");
    if (formFiltros) {
        formFiltros.addEventListener("input", async function(e) {
            const formData = new FormData(formFiltros);
            const filtros = {};
            
            formData.forEach((value, key) => {
                if (value.trim() !== "") {
                    filtros[key] = value;
                }
            });
            
            await categoryController.list(filtros);
        });
    }

    const tabla = document.getElementById("tabla-categorias");
    if (tabla) {
        tabla.addEventListener("click", async function(e) {
            
            // Si tocaste el botón ELIMINAR
            if (e.target.classList.contains("btn-eliminar")) {
                const id = e.target.getAttribute("data-id");
                await categoryController.delete(id);
            }
            
            // Si tocaste el botón EDITAR
            if (e.target.classList.contains("btn-editar")) {
                const id = e.target.getAttribute("data-id");
                const nombre = e.target.getAttribute("data-nombre");
                
                // Rellenamos el formulario
                document.getElementById("categoria-id").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("nombre").focus();
                
                // Cambiamos el modo de los botones
                document.getElementById("btn-guardar").textContent = "Actualizar";
                document.getElementById("btn-cancelar").classList.remove("d-none");
            }
        });
    }

    // 5. Escuchar el botón Cancelar Edición
    const btnCancelar = document.getElementById("btn-cancelar");
    if (btnCancelar) {
        btnCancelar.addEventListener("click", function() {
            categoryController.resetForm();
        });
    }
});
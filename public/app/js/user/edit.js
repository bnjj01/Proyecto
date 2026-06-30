import userController from "./controller.js";
import { view } from "./view.js";

document.addEventListener("DOMContentLoaded", async function(){

    const urlParts = window.location.pathname.split('/');
    const idUsuario = parseInt(urlParts[urlParts.length - 1]);

    if (isNaN(idUsuario)) {
        alert("Error: No se encontró un ID válido en la URL.");
        return;
    }

    const inputId = document.getElementById('user-id');
    if (inputId) {
        inputId.value = idUsuario;
    }

    await userController.load(idUsuario);

    const botonEditar = document.getElementById("btn-editar");
    const botonActualizar = document.getElementById("btn-actualizar");
    const botonCancelar = document.getElementById("btn-cancelar");
    const botonEliminar = document.getElementById("btn-eliminar");
    const campos = document.querySelectorAll(".form-control, .form-select");
    const formulario = document.getElementById("user-form");

    if(botonActualizar && botonCancelar && botonEditar){
        botonEditar.addEventListener("click", function(evento){
            campos.forEach(campo=>{
                campo.disabled = false;
            });
            
            botonEditar.classList.add("d-none");
            botonActualizar.classList.remove("d-none");
            botonCancelar.classList.remove("d-none");

            document.getElementById("apellido").focus();
        });

        botonCancelar.addEventListener("click", function(evento){
            if(formulario){
                formulario.reset();
            }
            campos.forEach(campo=>{
                campo.disabled = true;
            });
            botonActualizar.classList.add("d-none");
            botonCancelar.classList.add("d-none");
            botonEditar.classList.remove("d-none");
            
            userController.load(idUsuario); 
        });

        if(botonActualizar){
            botonActualizar.addEventListener("click", async function(evento){
                evento.preventDefault();
               
                const formData = new FormData(formulario);
                await userController.update(formData); 
            });
        }

        if(botonEliminar){
            botonEliminar.addEventListener("click", async function(evento){
                evento.preventDefault();
                await userController.delete(idUsuario);
            });
        }
    }
});
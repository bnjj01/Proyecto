import userController from "./controller.js";

document.addEventListener("DOMContentLoaded", function(){
    const formulario = document.getElementById("user-form");

    if (formulario) {
        formulario.addEventListener("submit", async function(evento){
            evento.preventDefault();
            
            // Empaquetamos el formulario y SE LO MANDAMOS al controlador
            const formData = new FormData(formulario);
            await userController.save(formData);
        });
    }
});
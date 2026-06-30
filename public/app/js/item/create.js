// 1. Corregimos el import (sin llaves)
import itemController from "./controller.js";

document.addEventListener("DOMContentLoaded", function(){
    
    itemController.init();
    
    const formulario = document.getElementById("item-form");
    const mensaje = document.getElementById("message");

    if(formulario) {
        formulario.addEventListener("submit", function(evento){
            evento.preventDefault();
            
            itemController.save();
            
            mensaje.classList.remove("d-none");
                    
            setTimeout(()=>{
                mensaje.classList.add("d-none");
            }, 3000);
        });
    }
});
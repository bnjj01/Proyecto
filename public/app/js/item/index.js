import itemController from "./controller.js";

document.addEventListener("DOMContentLoaded", async function() {
    
    itemController.init();
    const formFiltros = document.getElementById('item-form');
    formFiltros.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(formFiltros);
        const filtros = {};

        formData.forEach((value, key) => {
            if (value.trim() !== "") {
                filtros[key] = value;
            }
        });
        
        await itemController.list(filtros);
    });

    await itemController.list();
});
import userController from "./controller.js";

document.addEventListener("DOMContentLoaded", async function() {
    userController.init();
    
    const formFiltros = document.getElementById('form-filtros-usuario');
    
    if (formFiltros) {
        formFiltros.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(formFiltros);
            const filtros = {};
            
            formData.forEach((value, key) => {
                if (value.trim() !== "") {
                    filtros[key] = value;
                }
            });
            
            await userController.list(filtros);
        });
    }
    
    await userController.list();

    
});
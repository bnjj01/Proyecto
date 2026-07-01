import clientController from "./controller.js";
import clientService from "./service.js";

document.addEventListener("DOMContentLoaded", () => {
    const selectTipo = document.getElementById("tipo");
    const form = document.getElementById("client-form");

    // Escuchamos el cambio de Tipo en vivo
    if (selectTipo) {
        selectTipo.addEventListener("change", (e) => clientController.toggleCamposTipo(e.target.value));
    }

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(form));
            const res = await clientService.save(data);
            if (res.success) {
                alert("Cliente guardado.");
                window.location.href = window.APP_URL + 'client';
            } else {
                alert("Error: " + res.message);
            }
        });
    }
});
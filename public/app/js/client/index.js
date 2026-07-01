import clientController from "./controller.js";
document.addEventListener("DOMContentLoaded", async () => {
    await clientController.renderTable();
    const formFiltros = document.getElementById("form-filtros-cliente");
    if (formFiltros) {
        formFiltros.addEventListener("submit", async (e) => {
            e.preventDefault();
            await clientController.renderTable(Object.fromEntries(new FormData(formFiltros)));
        });
    }
});
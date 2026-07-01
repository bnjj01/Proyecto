import saleController from "./controller.js";

// Hacemos global la función para que el botón "Quitar" del HTML la pueda leer
window.quitarDetalle = (id) => saleController.quitarDelCarrito(id);

document.addEventListener("DOMContentLoaded", async () => {
    await saleController.initCreate();

    const btnAgregar = document.getElementById("btn-agregar-carrito");
    if (btnAgregar) {
        btnAgregar.addEventListener("click", () => saleController.agregarAlCarrito());
    }

    const formulario = document.getElementById("sale-form");
    if (formulario) {
        formulario.addEventListener("submit", (e) => {
            e.preventDefault();
            const formData = new FormData(formulario);
            saleController.saveSale(formData);
        });
    }
});
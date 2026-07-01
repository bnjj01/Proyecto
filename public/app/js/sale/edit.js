document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-editar-venta");
    const botonEliminar = document.getElementById("btn-eliminar-venta");
    const botonExportar = document.getElementById("btn-exportar-recibo");

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());

            const response = await fetch(`${window.APP_URL}sale/update`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            alert(result.message || "Venta actualizada");
            if (result.success) {
                location.reload();
            }
        });
    }

    if (botonExportar) {
        botonExportar.addEventListener("click", async () => {
            if (!form) return;

            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());

            try {
                const response = await fetch(`${window.APP_URL}sale/exportPdf`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload)
                });

                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                window.open(url, "_blank");
                setTimeout(() => window.URL.revokeObjectURL(url), 2000);
            } catch (e) {
                alert("No se pudo generar el PDF del recibo.");
            }
        });
    }

    if (botonEliminar) {
    botonEliminar.addEventListener("click", async () => {
        if (!confirm("¿Seguro que deseas eliminar esta venta?")) return;

        const ventaId = document.querySelector('input[name="id"]')?.value;
        if (!ventaId) {
            alert("No se encontró el id de la venta.");
            return;
        }

        try {
            const res = await fetch(`${window.APP_URL}sale/delete`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: ventaId })
            });

            const result = await res.json();
            alert(result.message || "Venta eliminada");
            if (result.success) {
                window.location.href = `${window.APP_URL}sale`;
            }
        } catch (e) {
            alert("No se pudo eliminar la venta.");
        }
    });
}
});
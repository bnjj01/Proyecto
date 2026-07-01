import saleService from "./service.js";

document.addEventListener("DOMContentLoaded", async () => {
    
    // Función para dibujar la tabla
    const renderTable = async (filters = {}) => {
        const ventas = await saleService.list(filters);
        const tbody = document.querySelector('#tabla-ventas tbody');
        if (!tbody) return;

        tbody.innerHTML = '';
        if (ventas.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center">No hay ventas registradas</td></tr>`;
            return;
        }

        ventas.forEach(v => {
            const estadoHtml = parseInt(v.estado) === 1 
                ? '<span class="badge bg-success">Válida</span>' 
                : '<span class="badge bg-danger">Anulada</span>';
                
            tbody.innerHTML += `
                <tr>
                    <td class="fw-bold">#${v.numero_venta.toString().padStart(6, '0')}</td>
                    <td>${v.fecha}</td>
                    <td>${v.cliente}</td>
                    <td>${v.forma_pago}</td>
                    <td class="fw-bold">$ ${parseFloat(v.total).toFixed(2)}</td>
                    <td>${estadoHtml}</td>
                    <td class="text-center">
                        <a href="${window.APP_URL}sale/edit/${v.id}" class="btn btn-sm btn-outline-primary">Editar</a>
                    </td>
                </tr>
            `;
        });
    };

    await renderTable();

    const formFiltros = document.getElementById("form-filtros-ventas");
    if (formFiltros) {
        formFiltros.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(formFiltros);
            await renderTable(Object.fromEntries(formData));
        });
    }
});
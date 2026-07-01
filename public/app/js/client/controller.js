import clientService from "./service.js";

const clientController = {
    // Esta es la función inteligente que alterna los campos
    toggleCamposTipo(tipoSeleccionado) {
        const divParticular = document.getElementById('seccion-particular');
        const divEmpresa = document.getElementById('seccion-empresa');
        const inputsParticular = document.querySelectorAll('.input-particular');
        const inputsEmpresa = document.querySelectorAll('.input-empresa');

        if (tipoSeleccionado === 'Particular') {
            divParticular.classList.remove('d-none');
            divEmpresa.classList.add('d-none');
            // Obligamos a llenar datos de persona, limpiamos los de empresa
            inputsParticular.forEach(i => i.required = true);
            inputsEmpresa.forEach(i => { i.required = false; i.value = ''; });
        } else {
            divEmpresa.classList.remove('d-none');
            divParticular.classList.add('d-none');
            // Obligamos a llenar datos de empresa, limpiamos los de persona
            inputsEmpresa.forEach(i => i.required = true);
            inputsParticular.forEach(i => { i.required = false; i.value = ''; });
        }
    },

    async renderTable(filters = {}) {
        const clientes = await clientService.list(filters);
        const tbody = document.querySelector('#tabla-clientes tbody');
        if (!tbody) return;

        tbody.innerHTML = '';
        if (clientes.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">No hay clientes registrados</td></tr>`;
            return;
        }

        clientes.forEach(c => {
            // Formateamos inteligentemente lo que mostramos en la tabla
            const nombreMostrar = c.tipo === 'Particular' ? `${c.apellido}, ${c.nombres}` : c.razon_social;
            const docMostrar = c.tipo === 'Particular' ? `DNI: ${c.dni}` : `CUIT: ${c.cuit}`;
            const badgeTipo = c.tipo === 'Particular' ? 'bg-info text-dark' : 'bg-secondary';

            tbody.innerHTML += `
                <tr>
                    <td><span class="badge ${badgeTipo}">${c.tipo}</span></td>
                    <td class="fw-bold">${nombreMostrar}</td>
                    <td>${docMostrar}</td>
                    <td>${c.telefono || '-'}</td>
                    <td>${c.correo || '-'}</td>
                    <td class="text-center">
                        <a href="${window.APP_URL}client/edit/${c.id}" class="btn btn-sm btn-outline-primary">Editar</a>
                    </td>
                </tr>
            `;
        });
    }
};
export default clientController;
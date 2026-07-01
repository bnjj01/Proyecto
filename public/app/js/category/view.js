export const view = {
    listCategories: (categories) => {
        const tbody = document.querySelector('#tabla-categorias tbody');
        if (!tbody) return;

        tbody.innerHTML = ''; 

        if (categories.length === 0) {
            tbody.innerHTML = `<tr><td colspan="2" class="text-center">No hay categorías registradas</td></tr>`;
            return;
        }

        categories.forEach(cat => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${cat.nombre || ''}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary btn-editar" data-id="${cat.id}" data-nombre="${cat.nombre}">Editar</button>
                    <button class="btn btn-danger btn-sm btn-eliminar" data-id="${cat.id}">Eliminar</button>
                    </td>
            `;
            tbody.appendChild(fila);
        });
    },

    resetForm: () => {
    const form = document.getElementById('form-categoria');
    if (form) {
        form.reset();
        document.getElementById('categoria-id').value = '';
        document.getElementById('btn-guardar').textContent = 'Guardar';
        document.getElementById('btn-cancelar').classList.add('d-none');
    }
}
};
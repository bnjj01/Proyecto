export const view = {
    forms: {},
    
    init: () => {

        view.forms.item = document.getElementById('item-form');
    },
    
    resetForm: () => {
        if(view.forms.item) {
            view.forms.item.reset();
        }
    },
    
    listItems: items => {
        const tbody = document.querySelector('#tabla-items tbody');
        if (!tbody) return;

        tbody.innerHTML = ''; 

        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">No hay productos en el inventario</td></tr>`;
            return;
        }

        items.forEach(item => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${item.codigo || ''}</td>
                <td>${item.nombre || ''}</td>
                <td>${item.categoria || ''}</td>
                <td>$ ${item.precio || 0}</td>
                <td>${item.stock || 0}</td>
                <td class="text-center">
                    <a href="${window.APP_URL}item/edit/${item.id}" class="btn btn-sm btn-outline-primary">Editar / Ver</a>
                </td>
            `;
            tbody.appendChild(fila);
        });
    }
};
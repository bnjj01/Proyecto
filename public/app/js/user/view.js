export const view = {
    forms: {},
    
    init: () => {
        view.forms.user = document.getElementById('user-form');
    },
    
    resetForm: () => {
        if(view.forms.user) {
            view.forms.user.reset();
        }
    },
    
    listUsers: (users) => {
        const tbody = document.querySelector('#table-user tbody');
        if (!tbody) return;

        tbody.innerHTML = ''; 

        if (users.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">No hay registros disponibles</td></tr>`;
            return;
        }

        users.forEach(user => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${user.cuenta || ''}</td>
                <td>${user.nombres || ''} ${user.apellido || ''}</td>
                <td>${user.perfil || ''}</td>
                <td>${user.correo || ''}</td>
                <td class="text-center">
                    <a href="${window.APP_URL}user/edit/${user.id}" class="btn btn-sm btn-outline-primary">Editar / Ver</a>
                </td>
            `;
            tbody.appendChild(fila);
        });
    },

    fillForm: (user) => {
        if(!user) return;
        
        const campos = ['apellido', 'nombres', 'cuenta', 'perfil', 'correo'];
        campos.forEach(campo => {
            const input = document.getElementById(campo);
            if (input) input.value = user[campo] || '';
        });
    },

    toggleForm: (estado) => {
        const controles = document.querySelectorAll('#user-form input, #user-form select');
        controles.forEach(control => {
            if(control.id !== 'user-id' && control.name !== 'id') {
                control.disabled = !estado;
            }
        });
    }
};
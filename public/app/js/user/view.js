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
            let btnEstado = '';
            let badgeEstado = '';
            
            if (parseInt(user.estado) === 1) {
                badgeEstado = '<span class="badge bg-success">Activo</span>';
                btnEstado = `<button class="btn btn-sm btn-danger me-1" onclick="window.userController.toggleStatus(${user.id}, 'disable')">Suspender</button>`;
            } else {
                badgeEstado = '<span class="badge bg-secondary">Suspendido</span>';
                btnEstado = `<button class="btn btn-sm btn-success me-1" onclick="window.userController.toggleStatus(${user.id}, 'enable')">Habilitar</button>`;
            }

            const btnReset = `<button class="btn btn-sm btn-warning me-1" onclick="window.userController.resetPass(${user.id})">Resetear Clave</button>`;
            
            const fila = document.createElement('tr');
            
            fila.innerHTML = `
                <td>${user.apellido || ''}, ${user.nombres || ''} <br> ${badgeEstado}</td>
                <td class="fw-bold">${user.cuenta || ''}</td>
                <td>${user.perfil || ''}</td>
                <td>${user.correo || ''}</td>
                <td class="text-center">
                    ${btnEstado}
                    ${btnReset}
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
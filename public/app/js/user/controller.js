import userService from "./service.js";
import { view } from "./view.js";

const userController = {
    init: () => {
        view.init();
    },

    async list(filters = {}) {
        const usuarios = await userService.list(filters);
        view.listUsers(usuarios);
    },

    async load(id) {
        const user = await userService.load(id);
        if (user) {
            view.fillForm(user);
            view.toggleForm(false);
        } else {
            alert("No se pudo cargar la información del usuario.");
        }
    },

    async save(formData) {
        const data = Object.fromEntries(formData);

        if (data.clave !== data.confirmarClave) {
            alert('Las contraseñas no coinciden. Por favor, intentalo de nuevo.');
            return false;
        }

        try {
            const result = await userService.save(data);
            if (result.success) {
                alert("Usuario registrado con éxito.");
                view.resetForm();
                window.location.href = window.APP_URL + 'user';
            } else {
                alert("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error fatal:", error);
            alert("Ocurrió un error inesperado de conexión.");
        }
    },

    async update(formData) {
        const data = Object.fromEntries(formData);
        
        const inputId = document.getElementById('user-id');
        if (inputId) {
            data.id = parseInt(inputId.value);
        }

        if (data.clave && data.clave !== data.confirmarClave) {
            alert('Las contraseñas no coinciden. Por favor verifíquelas.');
            return false;
        }

        try {
            const result = await userService.update(data);
            if (result.success) {
                alert("Registro actualizado.");
                window.location.href = window.APP_URL + 'user';
            } else {
                alert("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error fatal:", error);
        }
    },

    async delete(id) {
        const verificado = confirm("¿Estás seguro de que deseas eliminar este usuario?");
        if (verificado) {
            try {
                const result = await userService.delete(id);
                if (result.success) {
                    alert("Usuario eliminado correctamente.");
                    window.location.href = window.APP_URL + 'user';
                } else {
                    alert("Error: " + result.message);
                }
            } catch (error) {
                console.error("Error al eliminar:", error);
            }
        }
    }
};

export default userController;
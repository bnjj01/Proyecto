const userService = {
    async list(filters = {}) {
        try {
            const response = await fetch(window.APP_URL + 'user/list', {
                method: 'POST',
                body: JSON.stringify(filters),
                headers: { 'Content-Type': 'application/json' }
            });
            const result = await response.json();
            return result.data || [];
        } catch (error) {
            console.error("Error al listar usuarios:", error);
            return [];
        }
    },

    async load(id) {
        try {
            const response = await fetch(window.APP_URL + 'user/load', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: parseInt(id) })
            });
            const result = await response.json();
            
            return result.success ? result.data : null;
        } catch (error) {
            console.error("Error de conexión al cargar el usuario:", error);
            return null;
        }
    },

    async save(data) {
        const response = await fetch(window.APP_URL + 'user/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return await response.json();
    },

    async update(data) {
        const response = await fetch(window.APP_URL + 'user/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return await response.json();
    },

    async delete(id) {
        const response = await fetch(window.APP_URL + 'user/delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: parseInt(id) })
        });
        return await response.json();
    },

    enable: async (id) => {
        const res = await fetch(window.APP_URL + 'user/enable', { 
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        });
        return await res.json();
    },
    disable: async (id) => {
        const res = await fetch(window.APP_URL + 'user/disable', { 
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        });
        return await res.json();
    },
    reset: async (id) => {
        const res = await fetch(window.APP_URL + 'user/reset', { 
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        });
        return await res.json();
    }
};

export default userService;
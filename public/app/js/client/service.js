const clientService = {
    list: async (filters = {}) => {
        try {
            const res = await fetch(window.APP_URL + 'client/list', { method: 'POST', body: JSON.stringify(filters) });
            const data = await res.json();
            return data.success ? data.data : [];
        } catch (e) { return []; }
    },
    load: async (id) => {
        try {
            const res = await fetch(window.APP_URL + 'client/load', { method: 'POST', body: JSON.stringify({id}) });
            const data = await res.json();
            return data.success ? data.data : null;
        } catch (e) { return null; }
    },
    save: async (client) => {
        const res = await fetch(window.APP_URL + 'client/save', { method: "POST", body: JSON.stringify(client) });
        return await res.json();
    },
    update: async (client) => {
        const res = await fetch(window.APP_URL + 'client/update', { method: "POST", body: JSON.stringify(client) });
        return await res.json();
    },
    delete: async (id) => {
        const res = await fetch(window.APP_URL + 'client/delete', { method: "POST", body: JSON.stringify({id}) });
        return await res.json();
    }
};
export default clientService;
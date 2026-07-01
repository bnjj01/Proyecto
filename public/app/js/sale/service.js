const saleService = {
    // Busca los productos para llenar el Select del punto de venta
    getProducts: async () => {
        try {
            const res = await fetch(window.APP_URL + 'item/list', { method: "POST", body: JSON.stringify({}) });
            const data = await res.json();
            return data.success ? data.data : [];
        } catch (e) { return []; }
    },
    getClients: async () => {
        try {
            const res = await fetch(window.APP_URL + 'client/list', { 
                method: "POST", 
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({}) 
            });
            const data = await res.json();
            return data.success ? data.data : [];
        } catch (e) { 
            return []; 
        }
    },
    
    // Lista las ventas concretadas
    list: async (filters = {}) => {
        try {
            const res = await fetch(window.APP_URL + 'sale/list', { method: 'POST', body: JSON.stringify(filters) });
            const data = await res.json();
            return data.success ? data.data : [];
        } catch (e) { return []; }
    },

    // Guarda la venta completa (Cabecera + Detalles)
    save: async (venta) => {
        try {
            const res = await fetch(window.APP_URL + 'sale/save', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(venta)
            });
            return await res.json();
        } catch (e) { return { success: false, message: "Error de red" }; }
    }
};
export default saleService;
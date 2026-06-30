const itemService = {
    
    save: async (item) => {
        try {
            const response = await fetch(window.APP_URL + 'item/save', {
                method: "POST",
                headers: { "Content-Type": "application/json", "Accept": "application/json" },
                body: JSON.stringify(item)
            });
            if (!response.ok) throw new Error(response.statusText);
            
            const data = await response.json();
            alert(data.message);
            return data.success;
        } catch (error) {
            console.error("Error en save:", error);
            return false;
        }
    },
    update: async (updatedItem) => {
        try {
            const response = await fetch(window.APP_URL + 'item/update', {
                method: "POST",
                headers: { "Content-Type": "application/json", "Accept": "application/json" },
                body: JSON.stringify(updatedItem)
            });
            if (!response.ok) throw new Error(response.statusText);
            
            const data = await response.json();
            alert(data.message);
            return data.success;
        } catch (error) {
            console.error("Error en update:", error);
            return false;
        }
    },
    delete: async (id) => {
        try {
            const response = await fetch(window.APP_URL + 'item/delete', {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ id: id }) 
            });
            if (!response.ok) throw new Error(response.statusText);
            
            const data = await response.json();
            alert(data.message);
            return data.success;
        } catch (error) {
            console.error("Error en delete:", error);
            return false;
        }
    },
    list: async (filters = {}) => {
        try {
            const response = await fetch(window.APP_URL + 'item/list', {
                method: "POST",
                headers: { "Content-Type": "application/json", "Accept": "application/json" },
                body: JSON.stringify(filters)
            });
            if (!response.ok) throw new Error(response.statusText);
            
            const data = await response.json();
            return data.success ? data.data : [];
        } catch (error) {
            console.error("Error en list:", error);
            return [];
        }
    }
};
export default itemService;
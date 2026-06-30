const categoryService = {
    async list(filters = {}) {
        try {
            const response = await fetch(window.APP_URL + 'category/list', {
                method: 'POST',
                body: JSON.stringify(filters),
                headers: { 'Content-Type': 'application/json' }
            });
            const result = await response.json();
            return result.data || [];
        } catch (error) {
            console.error("Error al listar categorías:", error);
            return [];
        }
    },

    async save(data) {
        const response = await fetch(window.APP_URL + 'category/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return await response.json();
    }
};

export default categoryService;
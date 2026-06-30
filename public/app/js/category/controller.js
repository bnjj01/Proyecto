import categoryService from "./service.js";
import { view } from "./view.js";

const categoryController = {
    async list(filters = {}) {
        const categorias = await categoryService.list(filters);
        view.listCategories(categorias);
    },

    async save(formData) {
        const data = Object.fromEntries(formData);

        try {
            const result = await categoryService.save(data);
            if (result.success) {
                alert("Categoría registrada con éxito.");
                view.resetForm();
                await this.list(); // Magia: Recargamos la tabla automáticamente sin refrescar la página
            } else {
                alert("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error fatal:", error);
        }
    }
};

export default categoryController;
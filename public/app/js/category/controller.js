import categoryService from "./service.js";
import { view } from "./view.js";

const categoryController = {
    async list(filters = {}) {
        const categorias = await categoryService.list(filters);
        view.listCategories(categorias);
    },

    async save(formData) {
        const data = Object.fromEntries(formData);
        // Si el formulario tiene un ID, significa que estamos actualizando
        const esActualizacion = data.id && data.id !== "";

        try {
            const result = esActualizacion ? await categoryService.update(data) : await categoryService.save(data);
            if (result.success) {
                alert(result.message || "Operación exitosa.");
                view.resetForm();
                await this.list(); 
            } else {
                alert("Error: " + result.message);
            }
        } catch (error) {
            console.error("Error fatal:", error);
        }
    },
    async delete(id) {
        const confirmado = confirm("¿Estás seguro de que deseas eliminar esta categoría?");
        if (confirmado) {
            try {
                const result = await categoryService.delete(id);
                if (result.success) {
                    await this.list(); // Recarga la tabla
                } else {
                    // Nota: Si una categoría está siendo usada por un producto, MySQL bloqueará el borrado y caerá aquí.
                    alert("No se puede eliminar: " + result.message);
                }
            } catch (error) {
                console.error("Error al eliminar:", error);
            }
        }
    },
    resetForm() {
        view.resetForm();
    }
};

export default categoryController;
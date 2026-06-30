import { view } from './view.js';
import itemService from "./service.js";

const itemController = {

    init() {
        view.init();
    },

    async save() {
  
        let data = Object.fromEntries(new FormData(view.forms.item));
        
        data.categoriaId = parseInt(data.categoria);
        delete data.categoria;
        data.precio = parseFloat(data.precio);
        data.stock = parseInt(data.stock);

        const exito = await itemService.save(data);
        
        if (exito) {
            view.resetForm();
            window.location.href = window.APP_URL + 'item';
        }
    },

    async update() {
        let data = Object.fromEntries(new FormData(view.forms.item));
        
        data.id = parseInt(document.getElementById('item-id').value);
        data.categoriaId = parseInt(data.categoria);
        delete data.categoria;
        data.precio = parseFloat(data.precio);
        data.stock = parseInt(data.stock);

        const exito = await itemService.update(data);
        return exito; 
    },

    async delete(id) {
        const verificado = confirm("¿Estás seguro de que deseas eliminar este producto?");
        if (verificado) {
            const exito = await itemService.delete(id);
            if (exito) {
                window.location.href = window.APP_URL + 'item';
            }
        }
    },

    async list(filters = {}) {
        let items = await itemService.list(filters);
        view.listItems(items);
    }
};

export default itemController;
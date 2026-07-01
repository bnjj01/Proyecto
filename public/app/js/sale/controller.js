import saleService from "./service.js";

const saleController = {
    productosDisponibles: [],
    detallesVenta: [], // Acá guardamos el carrito en memoria

    // Inicializa la pantalla de Nueva Venta
    async initCreate() {
        // 1. Cargamos los productos (ya lo tenías)
        this.productosDisponibles = await saleService.getProducts();
        const selectProd = document.getElementById('select-producto');
        
        selectProd.innerHTML = '<option value="" selected disabled>Seleccione un producto...</option>';
        this.productosDisponibles.forEach(p => {
            if(p.stock > 0) { 
                selectProd.innerHTML += `<option value="${p.id}" data-precio="${p.precio}" data-nombre="${p.nombre}" data-codigo="${p.codigo}">[${p.codigo}] ${p.nombre} - $${p.precio} (Stock: ${p.stock})</option>`;
            }
        });

        // 2. NUEVO: Cargamos los clientes y los dibujamos en el formulario
        const clientesDisponibles = await saleService.getClients();
        const selectCliente = document.getElementById('cliente');
        
        if(selectCliente) {
            clientesDisponibles.forEach(c => {
                // Evaluamos de forma inteligente qué nombre mostrar
                const nombreCliente = c.tipo === 'Particular' ? `${c.apellido} ${c.nombres}` : c.razon_social;
                const documento = c.tipo === 'Particular' ? `DNI: ${c.dni}` : `CUIT: ${c.cuit}`;
                
                // Agregamos la opción al desplegable (Enviamos el nombre como valor para guardarlo en la factura)
                selectCliente.innerHTML += `<option value="${nombreCliente}">${nombreCliente} (${documento})</option>`;
            });
        }
    },

    agregarAlCarrito() {
        const select = document.getElementById('select-producto');
        const cantidadInput = document.getElementById('input-cantidad');
        const cantidad = parseInt(cantidadInput.value);

        if (!select.value || cantidad <= 0) {
            alert("Seleccione un producto y una cantidad válida.");
            return;
        }

        const opcion = select.options[select.selectedIndex];
        const producto = {
            id: parseInt(select.value),
            codigo: opcion.getAttribute("data-codigo"),
            nombre: opcion.getAttribute("data-nombre"),
            precio: parseFloat(opcion.getAttribute("data-precio")),
            cantidad: cantidad
        };
        
        producto.subtotal = producto.precio * producto.cantidad;

        // Verificar si ya está en el carrito para sumar cantidad
        const existe = this.detallesVenta.find(p => p.id === producto.id);
        if (existe) {
            existe.cantidad += producto.cantidad;
            existe.subtotal = existe.precio * existe.cantidad;
        } else {
            this.detallesVenta.push(producto);
        }

        this.renderCarrito();
    },

    quitarDelCarrito(idProducto) {
        this.detallesVenta = this.detallesVenta.filter(p => p.id !== idProducto);
        this.renderCarrito();
    },

    renderCarrito() {
        const tbody = document.querySelector('#tabla-carrito tbody');
        const totalHtml = document.getElementById('total-venta');
        tbody.innerHTML = '';

        if (this.detallesVenta.length === 0) {
            tbody.innerHTML = `<tr id="fila-vacia"><td colspan="6" class="text-muted">El carrito está vacío</td></tr>`;
            totalHtml.innerText = "$ 0.00";
            return;
        }

        let total = 0;
        this.detallesVenta.forEach(p => {
            total += p.subtotal;
            tbody.innerHTML += `
                <tr>
                    <td>${p.codigo}</td>
                    <td>${p.nombre}</td>
                    <td>$ ${p.precio.toFixed(2)}</td>
                    <td>${p.cantidad}</td>
                    <td>$ ${p.subtotal.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="quitarDetalle(${p.id})">Quitar</button></td>
                </tr>
            `;
        });
        totalHtml.innerText = `$ ${total.toFixed(2)}`;
    },

    async saveSale(formData) {
        if (this.detallesVenta.length === 0) {
            alert("No puedes finalizar una venta sin productos en el carrito.");
            return;
        }

        const data = Object.fromEntries(formData);
        // Armamos el JSON Perfecto con la cabecera y la lista de productos
        const venta = {
            cliente: data.cliente || "Consumidor Final",
            forma_pago: data.forma_pago,
            detalles: this.detallesVenta
        };

        const result = await saleService.save(venta);
        if (result.success) {
            alert("Venta procesada con éxito.");
            window.location.href = window.APP_URL + 'sale';
        } else {
            alert("Error al procesar: " + result.message);
        }
    }
};

export default saleController;
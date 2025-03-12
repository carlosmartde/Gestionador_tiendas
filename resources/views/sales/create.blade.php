@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Registrar Nueva Venta</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="product_code" class="form-label">Código de Producto</label>
            <input type="text" class="form-control" id="product_code" autofocus>
        </div>
        
        <div class="table-responsive mb-4">
            <table class="table table-striped" id="sales-table">
                <thead>
                    <tr>
                        <th width="15%">Código</th>
                        <th width="25%">Producto</th>
                        <th width="15%">Precio</th>
                        <th width="15%">Cantidad</th>
                        <th width="15%">Subtotal</th>
                        <th width="15%">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los productos se agregarán aquí dinámicamente -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold" id="total">Q0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <button type="button" class="btn btn-primary" id="complete-sale">Finalizar Venta</button>
    </div>
</div>

<template id="product-row-template">
    <tr>
        <td class="product-code"></td>
        <td class="product-name"></td>
        <td class="product-price"></td>
        <td>
            <input type="number" class="form-control quantity" min="1" value="1">
        </td>
        <td class="subtotal"></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-product">Eliminar</button>
        </td>
    </tr>
</template>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productCodeInput = document.getElementById('product_code');
        const salesTable = document.getElementById('sales-table').getElementsByTagName('tbody')[0];
        const completeSaleBtn = document.getElementById('complete-sale');
        const totalElement = document.getElementById('total');
        let products = [];

        // Escanear código de producto
        productCodeInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const code = this.value.trim();
        console.log("Código ingresado:", code); // <-- Verifica si el código se captura bien
        if (code) {
            fetchProductDetails(code);
            this.value = ''; // Limpia el input
        }
    }
});

        // Obtener detalles del producto
function fetchProductDetails(code) {
    fetch(`/product/code/${code}`)
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del backend:", data);
            if (data.error) {
                Swal.fire({
                    title: 'Error',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (data) {
                addProductToTable(data);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Producto no encontrado',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al buscar el producto. Intente nuevamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}

        // Agregar producto a la tabla
        function addProductToTable(product) {
    // Convertir sale_price a número
    const salePrice = Number(product.sale_price);

    if (isNaN(salePrice)) {
        console.error("Error: El precio del producto no es un número válido", product.sale_price);
        alert("Error: El precio del producto no es válido.");
        return;
    }

    // Verificar si el producto ya está en la tabla
    const existingProduct = products.find(p => p.id === product.id);
    if (existingProduct) {
        // Incrementar cantidad
        const row = document.querySelector(`tr[data-product-id="${product.id}"]`);
        const quantityInput = row.querySelector('.quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateSubtotal(row);
    } else {
        // Agregar nuevo producto
        const template = document.getElementById('product-row-template');
        const clone = document.importNode(template.content, true);
        const row = clone.querySelector('tr');

        row.setAttribute('data-product-id', product.id);
        row.querySelector('.product-code').textContent = product.code;
        row.querySelector('.product-name').textContent = product.name;
        row.querySelector('.product-price').textContent = `Q${salePrice.toFixed(2)}`;

        const quantityInput = row.querySelector('.quantity');
        quantityInput.addEventListener('change', function() {
            updateSubtotal(row);
        });

        row.querySelector('.subtotal').textContent = `Q${salePrice.toFixed(2)}`;

        const removeButton = row.querySelector('.remove-product');
        removeButton.addEventListener('click', function() {
            row.remove();
            products = products.filter(p => p.id !== product.id);
            updateTotal();
        });

        salesTable.appendChild(row);

        // Agregar a la lista de productos
        products.push({
            id: product.id,
            code: product.code,
            name: product.name,
            price: salePrice, // Asegurar que es un número
            quantity: 1
        });
    }

    updateTotal();
}

        // Actualizar subtotal de un producto
        function updateSubtotal(row) {
            const productId = parseInt(row.getAttribute('data-product-id'));
            const product = products.find(p => p.id === productId);
            const quantityInput = row.querySelector('.quantity');
            const quantity = parseInt(quantityInput.value);
            
            if (quantity < 1) {
                quantityInput.value = 1;
                return updateSubtotal(row);
            }
            
            const subtotal = product.price * quantity;
            row.querySelector('.subtotal').textContent = `Q${subtotal.toFixed(2)}`;
            
            // Actualizar cantidad en el array de productos
            product.quantity = quantity;
            
            updateTotal();
        }

        // Actualizar total
        function updateTotal() {
            const total = products.reduce((sum, product) => {
                return sum + (product.price * product.quantity);
            }, 0);
            
            totalElement.textContent = `Q${total.toFixed(2)}`;
        }

        // Finalizar venta
        // Modifica la parte del evento click del botón completeSaleBtn
completeSaleBtn.addEventListener('click', function() {
    if (products.length === 0) {
        Swal.fire({
            title: 'Error',
            text: 'Debe agregar al menos un producto a la venta',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    Swal.fire({
        title: '¿Está seguro?',
        text: 'Esta acción finalizará la venta actual',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, finalizar venta',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const total = products.reduce((sum, product) => {
                return sum + (product.price * product.quantity);
            }, 0);
            
            const saleData = {
                products: products.map(product => ({
                    id: product.id,
                    quantity: product.quantity,
                    price: product.price,
                    subtotal: product.price * product.quantity
                })),
                total: total
            };
            
            fetch('/sales', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(saleData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Venta registrada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Limpiar tabla
                        salesTable.innerHTML = '';
                        products = [];
                        updateTotal();
                        productCodeInput.focus();
                        
                        // Recargar la página después de finalizar la venta
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al registrar la venta: ' + data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar la venta. Intente nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
});
    });
</script>
@endsection
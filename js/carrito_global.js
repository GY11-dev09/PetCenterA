document.addEventListener('DOMContentLoaded', () => {
    
    // Función para calcular dinámicamente la ruta correcta hacia php/clases/carrito.php
    function obtenerUrlCarritoApi() {
        const pathname = window.location.pathname;
        const enCarpetaPhp = pathname.includes('/php/');
        
        if (!enCarpetaPhp) {
            // Estamos en la raíz del proyecto (Lay-Proy.php)
            return 'php/clases/carrito.php';
        }
        
        const partes = pathname.split('/php/');
        const subcarpetas = (partes[1].match(/\//g) || []).length;
        
        if (subcarpetas === 0) {
            // Primer nivel dentro de /php/ (ej. php/gatos.php, php/perros.php)
            return 'clases/carrito.php';
        } else {
            // Subcarpetas dentro de /php/ (ej. php/PerrosCategorias/PerroCategoriaPaseo.php)
            return '../'.repeat(subcarpetas) + 'clases/carrito.php';
        }
    }

    const urlApi = obtenerUrlCarritoApi();

    // Actualizar el número del badge en los encabezados
    function actualizarBadge(numero) {
        const badges = document.querySelectorAll('.cart-badge, #num_cart');
        badges.forEach(b => b.textContent = numero);
    }

    // 1. Escuchar todos los botones de "Añadir al carrito" en cualquier página
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-add-cart')) {
            e.preventDefault();
            const btn = e.target;
            const idProducto = btn.getAttribute('data-id') || btn.closest('.product-card')?.dataset?.id;

            if (!idProducto) {
                console.warn("No se encontró el atributo data-id en el botón o tarjeta.");
                return;
            }

            const formData = new FormData();
            formData.append('action', 'agregar');
            formData.append('id', idProducto);
            formData.append('cantidad', 1);

            fetch(urlApi, { method: 'POST', body: formData })
                .then(r => {
                    if (!r.ok) throw new Error(`HTTP Error Status: ${r.status}`);
                    return r.json();
                })
                .then(data => {
                    if (data.ok) {
                        actualizarBadge(data.numero);
                        btn.textContent = '¡Añadido! ✓';
                        btn.style.backgroundColor = '#00a896';
                        setTimeout(() => {
                            btn.textContent = 'Añadir al carrito';
                            btn.style.backgroundColor = '';
                        }, 1800);
                    } else if (data.msg) {
                        alert(data.msg);
                    }
                })
                .catch(err => console.error("Error al añadir producto:", err));
        }
    });

    // 2. Controladores de cambio de cantidad dentro de ver_carrito.php
    const cartTable = document.getElementById('cart-table-body');
    if (cartTable) {

        function enviarCambioCantidad(id, nuevaCant) {
            const formData = new FormData();
            formData.append('action', 'actualizar');
            formData.append('id', id);
            formData.append('cantidad', nuevaCant);

            fetch(urlApi, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        actualizarBadge(data.numero);
                        const row = document.getElementById(`cart-row-${id}`);
                        if (nuevaCant <= 0) {
                            if (row) row.remove();
                            if (data.numero === 0) location.reload();
                        } else {
                            const inputElem = row.querySelector('.input-qty');
                            if (inputElem) inputElem.value = nuevaCant;
                            const subtotalElem = row.querySelector('.cart-subtotal-col');
                            if (subtotalElem) subtotalElem.textContent = `$${data.subtotal}`;
                        }
                        const totalElem = document.getElementById('cart-total-amount');
                        if (totalElem) totalElem.textContent = `$${data.total}`;
                    } else if (data.msg) {
                        alert(data.msg);
                    }
                });
        }

        cartTable.addEventListener('click', (e) => {
            const target = e.target;
            const row = target.closest('.cart-item-row');
            if (!row) return;

            const id = row.dataset.id;
            const input = row.querySelector('.input-qty');
            let cant = parseInt(input.value) || 1;

            if (target.classList.contains('btn-qty-plus')) {
                enviarCambioCantidad(id, cant + 1);
            } else if (target.classList.contains('btn-qty-minus')) {
                enviarCambioCantidad(id, cant - 1);
            } else if (target.classList.contains('btn-remove-item')) {
                const formDel = new FormData();
                formDel.append('action', 'eliminar');
                formDel.append('id', id);

                fetch(urlApi, { method: 'POST', body: formDel })
                    .then(r => r.json())
                    .then(data => {
                        if (data.ok) {
                            actualizarBadge(data.numero);
                            row.remove();
                            const totalElem = document.getElementById('cart-total-amount');
                            if (totalElem) totalElem.textContent = `$${data.total}`;
                            if (data.numero === 0) location.reload();
                        }
                    });
            }
        });

        cartTable.addEventListener('change', (e) => {
            if (e.target.classList.contains('input-qty')) {
                const row = e.target.closest('.cart-item-row');
                const id = row.dataset.id;
                let val = parseInt(e.target.value) || 1;
                if (val < 1) val = 1;
                enviarCambioCantidad(id, val);
            }
        });
    }
});
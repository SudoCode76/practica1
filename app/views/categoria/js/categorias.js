let categoriaIdEliminar = null;

// Abrir modal para nueva categoría
document.getElementById('btnNuevaCategoria').addEventListener('click', () => {
    document.getElementById('modalTitle').textContent = 'Nueva Categoría';
    document.getElementById('formCategoria').reset();
    document.getElementById('categoriaId').value = '';
    document.getElementById('modalCategoria').classList.remove('hidden');
});

// Cerrar modales
function cerrarModal() {
    document.getElementById('modalCategoria').classList.add('hidden');
}

function cerrarModalEliminar() {
    document.getElementById('modalEliminar').classList.add('hidden');
}

// Manejar el formulario
document.getElementById('formCategoria').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const id = document.getElementById('categoriaId').value;
    const data = {
        nombre: document.getElementById('nombre').value,
        descripcion: document.getElementById('descripcion').value
    };
    
    const url = id ? '../controllers/categoria/update.php' : '../controllers/categoria/create.php';
    if (id) data.id = id;
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            window.location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

// Editar categoría
function editarCategoria(categoria) {
    document.getElementById('modalTitle').textContent = 'Editar Categoría';
    document.getElementById('categoriaId').value = categoria.id;
    document.getElementById('nombre').value = categoria.nombre;
    document.getElementById('descripcion').value = categoria.descripcion;
    document.getElementById('modalCategoria').classList.remove('hidden');
}

// Eliminar categoría
function eliminarCategoria(id) {
    categoriaIdEliminar = id;
    document.getElementById('modalEliminar').classList.remove('hidden');
}

async function confirmarEliminar() {
    try {
        const response = await fetch('../controllers/categoria/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: categoriaIdEliminar })
        });
        
        if (response.ok) {
            window.location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
} 
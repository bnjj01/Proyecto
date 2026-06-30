<div class="row mb-4">
    <div class="col">
        <h1 class="h2 border-bottom pb-2 title-custom">Gestión de Categorías</h1>
    </div>
</div>

<div class="card shadow-sm border-0" style="background-color: #ffffff;">
    <div class="card-body p-4">
        <h5 class="card-title h6 mb-3" >Agregar Categoría</h5>
        <form id="form-categoria" autocomplete="off">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre de la Categoría</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre descriptivo de la categoría" minlength="5" maxlength="100" required>
                </div>
            </div>

            <div class="d-flex gap-2  pt-3">
                <button type="submit" class="btn btn-custom-primary px-4" id="btn-guardar">Validar y guardar</button>
            </div>
        </form>
        <div id="message" class="alert alert-success d-none mt-4" >
            ¡Formulario enviado correctamente!
        </div>
    </div>
</div>


<div class="card mb-4 mt-5 bg-light">
    <div class="card-body">
        <h5 class="card-title h6 mb-3">Buscar Categorías</h5>
        <form class="row g-3 align-items-end" id="form-filtros">
            <div class="col-md-4">
                <label for="filtroNombre" class="form-label">Buscar por Nombre</label>
                <input type="text" class="form-control" name="filtroNombre" id="filtroNombre" placeholder="Ej: Pinturería">
            </div>
        </form>
    </div>
</div>

<div id="tabla-categorias" class="table-responsive">
    <table class="table table-striped table-hover align-middle border" id="tabla-items">
        <thead class="user-table">
            <tr>
                <th>Nombre</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
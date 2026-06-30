<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferreteria C.O</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <?php require_once APP_DIR_TEMPLATE . 'includes/head.php'; ?>
    <?php
        if(isset($this->styles) && is_array($this->styles)){
            foreach($this->styles as $style){
                echo '<link rel="stylesheet" href="' . APP_URL . $style . '">';
            }
        }
    ?>
</head>

<body class="d-flex flex-column min-vh-100">
    
    <header>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= APP_URL ?>home">Ferretería</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: var(--color-4);">
                    <span class="navbar-toggler-icon" style="filter: invert(72%) sepia(21%) saturate(836%) hue-rotate(342deg) brightness(91%) contrast(93%);"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="<?= APP_URL?>home">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= APP_URL?>item">Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= APP_URL?>sale">Ventas</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= APP_URL?>user">Usuarios</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                Mi cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0)">Mis datos</a></li>
                                <li><hr class="dropdown-divider" style="border-color: var(--color-3);"></li>
                                <li><a class="dropdown-item" href="<?= APP_URL ?>authentication/logout">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="container mt-4 mb-4">
        <?php
            require_once APP_DIR_VIEWS . $this->view;
        ?>
    </main>
    
    <footer class="footer-custom text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-1 text-white"><strong>Ferretería C.O. v1.0</strong></p>
            <p class="mb-1 small">Alumno: Benjamín Pozzo | Materia: Laboratorio de Programación</p>
            <p class="mb-0 small">Ingeniería en Sistemas | Universidad Nacional de la Patagonia Austral - Unidad Académica Caleta Olivia</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script>
        // Inyectamos APP_URL para que JS la pueda usar
        window.APP_URL = "<?= APP_URL ?>";
    </script>
    <?php
        if(isset($this->modules) && is_array($this->modules)){
            foreach($this->modules as $module){
                echo '<script type="module" src="' . APP_URL . $module . '"></script>';
            }
        }
    ?>
</body>
</html>
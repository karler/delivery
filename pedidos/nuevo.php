<?php
    require_once '../Config/database.php';
    require_once 'funciones.php';
    require_once '../productos/funciones.php';
    require_once '../clientes/funciones.php';

    // Obtener listas necesarias
    $productos = $productoController->listarProductos();
    $clientes = $clienteCOntroller->listarClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="index.php">Pedidos</a></li>
                <li class="breadcrumb-item active">Nuevo Pedido</li>
            </ol>
        </nav>

        <h1>Nuevo Pedido</h1>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Agregar Producto</h4>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
</body>
</html>

<?php
    require_once '../Config/database.php';
    require_once 'funciones.php';
    require_once '../productos/funciones.php';
    require_once '../clientes/funciones.php';

    session_start();
    // Inicializar los productos del pedido si no existen
    if (!isset($_SESSION['productos_pedido'])){
        $_SESSION['productos_pedido']=array();
    }

    // Inicializar los Controladores
    $pedidosController = new PedidoController();
    $productoController = new ProductoController();
    $clienteController =new ClienteController();

    // Procesar el formulario de agregar producto al pedido
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Agregar el producto al pedido
        if (isset($_POST['agregar_producto'])){
            if (!empty($_POST['id_producto']) && !empty($_POST['cantidad'])){
                $producto = $productoController->obtenerProducto($_POST['id_producto']);
                if ($producto){
                    $_SESSION['productos_pedido'][] = [
                        'id_producto' => $_POST['id_producto'],
                        //'id_producto' => $producto->_id,
                        'nombre_producto' => $producto->nombre,
                        'cantidad' => (int)$_POST['cantidad'],
                        'precio' => $producto->precio,
                        'notas' => $_POST['notas']
                    ];
                }

            }
        }
    }

    // Obtener listas necesarias
    $productos = $productoController->listarProductos();
    $clientes = $clienteController->listarClientes();
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
                <h4 class="card-title">Agregar Producto</h4>
            </div>
            <div class="card-body">
                <form method="POST" class="row">
                    <div class="col-4">
                        <!-- Selecciona el producto -->
                        <select name="id_producto" class="form-select" required>
                            <option value="">Seleccione un producto</option>
                            <?php foreach ($productos as $producto): ?>
                                <?php if($producto->disponible): ?>
                                    <option value="<?= $producto->_id ?>">
                                        <?= $producto->nombre ?> (S/ <?= number_format($producto->precio, 2) ?>)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Cantidad -->
                    <div class="col-2">
                        <input type="number" name="cantidad" value="1" min="1" class="form-control" required>
                    </div>
                    <!-- Notas adicionales -->
                    <div class="col-4">
                            <input type="text" name="notas" class="form-control" placeholder="Notas adicionales">
                    </div>
                    <!-- Boton agregar producto -->
                    <div class="col-2">
                        <button type="submit" name="agregar_producto" class="btn btn-primary">
                            Agregar
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Lista de productos agregados -->

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Productos del pedido</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unit.</th>
                            <th>Subtotal</th>
                            <th>Notas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($_SESSION['productos_pedido'] as $index => $item): ?>
                            <tr>
                                <td><?= $item['nombre_producto'] ?></td>
                                <td><?= $item['cantidad'] ?></td>
                                <td><?= number_format($item['precio'],2) ?></td>
                                <!-- Sub Total -->
                                <td><?= number_format($item['precio'],2)*$item['cantidad'] ?></td>
                                <td><?= $item['notas'] ?></td>
                                <td>
                                    <form>
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" name="eliminar_producto" class="btn btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

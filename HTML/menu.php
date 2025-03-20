<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$rol =  $_SESSION['rol_usuario'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPERMARKET</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- bloquea el div de atras -->
    <div id="overlay" class="overlay"></div>
    <div class="container ">
        <!-- inicio del nav -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="admin.php" role="button" data-bs-toggle="dropdown">
                            <h3>🛒</h3>
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <h6>Provedor</h6>
                            </a>
                            <ul class="dropdown-menu">
                            <?php if ($rol === 'Administrador' || $rol === 'Vendedor') : ?>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#proveedorModal">Registra Provedor</a></li>
                            <?php endif;  ?>
                                <li><a href="vistaProveedores.php" class="btn">Ver Proveedores</a></li>
                            </ul>
                        </li>

                        <div class="modal" id="proveedorModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1
                                            style="color: #3f51b5; margin-top: 0; text-align: center; font-size: 24px; margin-bottom: 25px;">
                                            Registro de Proveedores</h1>
                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <section id="formularioProveedor"
                                            class="contenedor bg-light text-center text-dark">
                                            <form id="proveedorForm">
                                                <div style="margin-bottom: 20px;">
                                                    <label for="nombre_proveedor"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;">Nombre
                                                        del Proveedor</label>
                                                    <input type="text" id="nombre_proveedor" name="nombre_proveedor"
                                                        placeholder="Ingrese el nombre del proveedor" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s;">
                                                </div>
                                                <div style="margin-bottom: 20px;">
                                                    <label for="direccion_proveedor"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;">Dirección
                                                        del Proveedor</label>
                                                    <input type="text" id="direccion_proveedor"
                                                        name="direccion_proveedor"
                                                        placeholder="Ingrese la dirección completa" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s;">
                                                </div>
                                                <div style="margin-bottom: 20px;">
                                                    <label for="telefono_proveedor"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;">Teléfono
                                                        del Proveedor</label>
                                                    <input type="tel" id="telefono_proveedor" name="telefono_proveedor"
                                                        placeholder="Ingrese el número de teléfono" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s;">
                                                </div>
                                                <button onclick="registroProveedor()" type="submit"
                                                    style="background-color: #3f51b5; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; width: 100%; transition: background-color 0.3s;">Registrar
                                                    Proveedor</button>
                                                <div id="mensajeProveedor" class="mensajeProveedor"></div>
                                            </form>
                                            <p id="mensajeProveedor"></p>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--categoria  -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <h6>Categoria</h6>
                            </a>
                            <ul class="dropdown-menu">
                            <?php if ($rol === 'Administrador' || $rol === 'Vendedor') : ?>
                                <li><a class="dropdown-item" href="" data-bs-toggle="modal"
                                        data-bs-target="#categoriaModal">Crea una categoría</a>
                                </li>
                                <?php endif;  ?>
                                <li><a href="vistaCategoria.php" data-bs-target="#categoriaModal" class="btn">Ver Categorías</a></li>
                            </ul>
                        </li>

                        <div class="modal" id="categoriaModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 style="color: #3f51b5; margin-top: 0; text-align: center; font-size: 24px; margin-bottom: 25px;">
                                            Registro de Categoría</h1>
                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="formularioCategoria" class="contenedor bg-light text-center text-dark">
                                            <form id="categoriaForm">
                                                <div style="margin-bottom: 20px;">
                                                    <label for="nombre_categoria">Nombre de la Categoría</label>
                                                    <input type="text" id="nombre_categoria" name="nombre_categoria"
                                                        placeholder="Ingrese el nombre de la categoría" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s;">
                                                </div>
                                                <button onclick="agregarCategoria()"
                                                    style="background-color: #3f51b5; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; width: 100%; transition: background-color 0.3s;">Registrar
                                                    Categoría</button>
                                            </form>
                                            <div id="mensajeCategoria" class="mensajeCategoria"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    <!-- producto -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <h6>Producto</h6>
                            </a>
                            <ul class="dropdown-menu">
                            <?php if ($rol === 'Administrador' || $rol === 'Vendedor') : ?>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#productoModal">Crear Producto</a></li>
                                <?php endif;  ?>

                                <li><a href="vistaProductos.php" class="btn">Ver Productos</a></li>                               
                            </ul>
                        </li>

                        <div class="modal" id="productoModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1
                                            style="color: #3f51b5; margin-top: 0; text-align: center; font-size: 24px; margin-bottom: 25px;">
                                            Registro de Producto</h1>
                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <section id="formularioProducto"
                                            class="contenedor bg-light text-center text-dark">
                                            <form id="productoForm">
                                                <div style="margin-bottom: 20px;">
                                                    <label for="nombre_producto"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;">
                                                        Nombre del Producto</label>
                                                    <input type="text" id="nombre_producto" name="nombre_producto"
                                                        placeholder="Ingrese el nombre del producto" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s;">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Imagen del Producto</label>
                                                    <input type="file" class="form-control" id="imagenProducto">
                                                </div>
                                                <div style="margin-bottom: 20px;">
                                                    <label for="descripcion_producto"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;" required>
                                                        Descripción del Producto</label>
                                                    <textarea id="descripcion_producto" name="descripcion_producto"
                                                        placeholder="Ingrese la descripción del producto" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s; min-height: 100px; resize: vertical;"></textarea>
                                                </div>
                                                <div style="margin-bottom: 20px;">
                                                    <label for="proveedor_producto"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;">Proveedor</label>
                                                    <select id="proveedor_producto" name="proveedor_producto" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px;">
                                                        <option value="">Seleccione un proveedor</option>
                                                        <!-- Aquí se llenarán los proveedores -->
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 20px;">
                                                    <label for="categoria_producto"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;">Categoría</label>
                                                    <select id="categoria_producto" name="categoria_producto" required
                                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px;">
                                                        <option value="">Seleccione una categoría</option>
                                                        <!-- Aquí se llenarán las categorías -->
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 20px;">
                                                    <label for="precio_producto"
                                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: #555; text-align: left;" required>
                                                        Precio del Producto</label>
                                                    <div style="position: relative;">
                                                        <span
                                                            style="position: absolute; left: 12px; top: 12px; font-size: 16px; color: #555;">$</span>
                                                        <input type="number" id="precio_producto" name="precio_producto"
                                                            placeholder="0.00" step="0.01" min="0" required
                                                            style="width: 100%; padding: 12px; padding-left: 30px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 16px; transition: border-color 0.3s;">
                                                    </div>
                                                </div>
                                                <button id="btnRegistrar" type="submit" onclick="registroProducto()"
                                                    style="background-color: #3f51b5; color: white; border: none; padding: 12px 20px;
                                                     border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; width: 100%; 
                                                     transition: background-color 0.3s;">Registrar
                                                    Producto</button>
                                                <div id="mensajeProducto" class="mensajeProducto"></div>
                                            </form>
                                            <p id="mensajeProducto"></p>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>

                    <!-- Modal de Perfil -->
                    
                        <label class="me-3 p-2">
                            <?php echo  $_SESSION['rol_usuario']; ?>

                        </label>

                        <p id="rol_seleccionado"></p>


                    

                    <li class="nav-item">
                        <a class="nav-link" href="#" id="navbarDropdown" data-bs-toggle="modal"
                            data-bs-target="#perfilModal" style="font-size: 16px;" onclick="mostrarPerfil()">Perfil</a>
                    </li>
                    <div class="modal fade perfilModal" id="perfilModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="perfilModalLabel">Mi Perfil</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        onclick="cerrarPerfil()"></button>
                                </div>
                                <div id="ModalPerfil" class="modal-body">
                                    <p><strong>Nombre:</strong> <input id="nombre_usuario_perfil" disabled></input></p>
                                    <p><strong>Apellido:</strong> <input id="apellido_usuario_perfil" disabled></input>
                                    </p>
                                    <p><strong>Correo:</strong> <input id="email_usuario_perfil" disabled></input></p>
                                    <p><strong>Teléfono:</strong> <input id="telefono_usuario_perfil" disabled></input>
                                    </p>
                                    <p><strong>Dirección:</strong> <input id="direccion_usuario_perfil"
                                            disabled></input></p>
                                 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="habilitar()">editar</button>
                                    <button id="guaradar" type="button" class="btn btn-primary"
                                        onclick="modificarPerfil() ">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- fin del nav -->
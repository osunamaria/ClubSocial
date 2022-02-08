<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>

    <!-- linkear con fuente belleza -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Belleza&display=swap" rel="stylesheet">

    <!-- links css -->
    <link rel="stylesheet" href="../css/headers.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/gestion_cuentas.css">

    <!-- link para iconos -->
    <link rel="stylesheet" href="../fontawesome-free-5.15.4-web/css/all.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

</head>

<body>

    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="../index.php" class="me-md-auto">
            <span class="fs-4"><img src="../img/logoOriginal.png" class="img-fluid"></span>
        </a>

        <ul class="nav nav-pills mt-4">
            <li class="nav-item"><a href="../index.php" class="nav-link text-secondary">Inicio</a></li>
            <li class="nav-item"><a href="../publicaciones/index.html" class="nav-link text-secondary">Publicaciones</a></li>
            <li class="nav-item"><a href="../reservas/index.php" class="nav-link text-secondary">Reservas</a></li>
            <?php
                // Continuar la sesión
                session_start();

                if(isset($_SESSION['sesion_iniciada']) == true ){
                    $tipo = session_id();
                    if($tipo=="presidente" || $tipo=="administrador"){
                        echo "<li class='nav-item dropdown'>";
                            echo "<a class='nav-link dropdown-toggle text-secondary' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                                echo "Gestiones";
                            echo "</a>";
                            echo "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                                echo "<li><a class='dropdown-item' href='#'>Usuarios</a></li>";
                                echo "<li><a class='dropdown-item' href='../gestion_publicaciones/index.php'>Publicaciones</a></li>";
                                echo "<li><a class='dropdown-item' href='../instalaciones/index.php'>Instalaciones</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Contabilidad</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Estadisticas</a></li>";
                            echo "</ul>";
                        echo "</li>";
                    }
                    echo "<li class='nav-item me-md-auto'><a href='../cerrarSesion.php' class='nav-link active bg-secondary rounded-pill' aria-current='page'>Cerrar sesión</a></li>";
                }else{
                    echo "<li class='nav-item me-md-auto'><a href='../registro/index.php' class='nav-link active bg-secondary rounded-pill' aria-current='page'>Entrar</a></li>";
                }//Fin si
            ?>
        </ul>
    </header>

    <?php include "operacionesGeneralesUsuarios.php";

    if (count($_GET) > 0) {
        $id = $_GET["varId"];
        $publicacion = obtenerUsuario($id);
    } else {
        $id = $_POST["id"];
        $publicacion = obtenerUsuario($id);
    }
    $error = '';
    if (count($_POST) > 0) {
        function seguro($valor)
        {
            $valor = strip_tags($valor);
            $valor = stripslashes($valor);
            $valor = htmlspecialchars($valor);
            return $valor;
        }
    
        $cumplido = editarUsuario($id, $_POST["nombre"], $_POST["apellidos"], $_POST["dni"], $_POST["tipo"], $_POST["correo"], $_POST["telefono"], $_POST["num_miembros"], $_POST["cuota"]);
        if ($cumplido == true) {
            header("Location: index.php?varId=" . $id);
            exit();
        } else {
            $error = "Datos incorrectos o no se ha actualizado nada";
        }
    }
    ?>
<article>
<div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Información</h4>
        <form class="needs-validation form-register" novalidate action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <!--aquí va el id, es hidden por lo tanto no es visible en la web, pero si accesible desde PHP -->
        <input type="hidden" name="id" value="<?php echo $publicacion["id"]; ?>">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" placeholder="NOMBRE" class="input-100" value='<?php echo $publicacion["nombre"]; ?>' required><br><br>
              <div class="invalid-feedback">
                Nombre incorrecto
              </div>
            </div>

            <div class="col-sm-6">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" name="apellidos" placeholder="APELLIDOS" class="input-100" value='<?php echo $publicacion["apellidos"]; ?>' required><br><br>
              <div class="invalid-feedback">
                Apellidos incorrecto
              </div>
            </div>

            <div class="col-12">
                <label for="dni" class="form-label">Dni</label>
                <input type="text" class="form-control" name="dni" placeholder="DNI" class="input-100" value='<?php echo $publicacion["dni"]; ?>' required><br><br>
                <div class="invalid-feedback">
                  Dni incorrecto
                </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="correo" placeholder="CORREO" class="input-100" value='<?php echo $publicacion["correo"]; ?>' required><br><br>
              <div class="invalid-feedback">
                 Email incorrecto
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Tipo</label>
              Socio <input name="publicacion" id="publicacion" type="checkbox" value='<?php echo $publicacion["tipo"]; ?>' checked>
              Presidente <input name="publicacion" id="publicacion" type="checkbox" value='<?php echo $publicacion["tipo"]; ?>'>
              Administrador <input name="publicacion" id="publicacion" type="checkbox" value='<?php echo $publicacion["tipo"]; ?>'><br><br>
              <div class="invalid-feedback">
                Tipo incorrecto
              </div>
            </div>

            <div class="col-sm-6">
              <label for="telefono" class="form-label">Telefono</label>
              <input type="text" class="form-control" name="telefono" placeholder="TELEFONO" class="input-100" value='<?php echo $publicacion["telefono"]; ?>' required><br><br>
              <div class="invalid-feedback">
                Telefono incorrecto
              </div>
            </div>

            <div class="col-sm-6">
              <label for="num_miembros" class="form-label">Número de miembros</label>
              <input type="number" class="form-control" name="num_miembros" placeholder="NUMERO DE MIEMBROS" class="input-100" value='<?php echo $publicacion["num_miembros"]; ?>' required><br><br>
              <div class="invalid-feedback">
                Número de miembros incorrecto
              </div>
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="number" class="form-control" name="cuota" placeholder="CUOTA" class="input-100" value='<?php echo $publicacion["cuota"]; ?>' required min="0"><br><br>
              <div class="invalid-feedback">
                 Cuota incorrecta
              </div>
            </div>
            
          <div id="errores"><?php echo $error; ?></div>
          <hr class="my-4">

          <input class="w-100 btn btn-primary btn-lg" type="submit" value="Guardar Cambios" class="btn-enviar">
        </form>
      </div>
    </div>
    </article>
    <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 mt-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="../index.php" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <img src="../img/logoNaranja.png" alt="logo">
            </a>
            <span class="text-muted">&copy; 2021 Company, Inc</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex fs-1">
            <li class="m-5"><i class="fab fa-instagram"></i></li>
            <li class="m-5"><i class="fab fa-twitter"></i></li>
            <li class="m-5"><i class="fab fa-facebook-square"></i></li>
        </ul>
    </footer>
    <script src="../js/bootstrap.bundle.min"></script>
</body>

</html>
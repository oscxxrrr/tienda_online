<?php
    require_once 'repositories/ProductRepository.php';
    require_once 'repositories/CarritoRepository.php';
    require_once 'repositories/UserRepository.php';

    $userRepo    = new UserRepository($conexion);
    $productRepo = new ProductRepository($conexion);
    $accion      = $_GET['accion'] ?? '';

    // --- LOGOUT ---
    if ($accion === 'logout') {
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // --- LOGIN ---
    if (isset($_POST['username'], $_POST['password']) && !isset($_POST['register'])) {
        $user = $userRepo->login($_POST['username'], $_POST['password']);
        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        }
        $info = "Usuario o contraseña incorrectos.";
    }

    // --- REGISTRO ---
    if (isset($_POST['register'], $_POST['username'], $_POST['email'], $_POST['password'])) {
        $info = $userRepo->create($_POST['username'], $_POST['email'], $_POST['password'])
            ? "¡Registro exitoso! Ya puedes iniciar sesión."
            : "Error: el usuario o email ya existe.";
    }

    // --- PRODUCTOS ---
    $productArray = $productRepo->getAll();

    // --- CARRITO (solo si hay sesión) ---
    $carritoItems = [];
    $carritoTotal = 0.0;

    if (isset($_SESSION['user'])) {
        $carritoRepo = new CarritoRepository($conexion, $_SESSION['user']->getId());

        if ($accion === 'addCarrito' && isset($_GET['id'])) {
            $carritoRepo->addProducto((int)$_GET['id']);
            header("Location: index.php");
            exit();
        }

        if ($accion === 'removeCarrito' && isset($_GET['item'])) {
            $carritoRepo->removeItem((int)$_GET['item']);
            header("Location: index.php");
            exit();
        }

        if ($accion === 'carrito') {
            $carritoItems = $carritoRepo->getItems();
            $carritoTotal = $carritoRepo->getTotal();
        }
    }
?>
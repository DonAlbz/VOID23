<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOID23</title>

    <!-- Bootstrap: libreria grafica -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS: libreria animazioni -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- CSS personale -->
    <link rel="stylesheet" href="/void23/css/style.css?v=2">
</head>
<body>

<header class="site-header">
    <div class="logo">
        <a href="/void23/index.php">VOID23</a>
    </div>

    <nav class="main-nav">
    <a href="/void23/index.php">Home</a>
    <a href="/void23/pages/shop.php">Shop</a>
    <a href="/void23/pages/cart.php">Carrello</a>

    <?php if (isset($_SESSION['utente_id'])) { ?>
        <a href="/void23/pages/profile.php">Profilo</a>
    <?php } else { ?>
        <a href="/void23/pages/login.php">Login</a>
    <?php } ?>
</nav>
</header>
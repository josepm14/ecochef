<?php
// =======================================
// EcoChef - Header Layout
// Ruta: app/views/layouts/header.php
// =======================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoChef - Plataforma</title>
    <!-- Fuente Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Estilos principales -->
    <link rel="stylesheet" href="/public/css/estilos.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="/public/img/logo.png" alt="EcoChef Logo">
            <span><strong>EcoChef</strong></span>
        </div>
        <nav>
            <a href="/index.php">Inicio</a>
            <a href="/app/views/auth/login.php">Ingresar</a>
            <a href="/contacto.php">Contacto</a>
        </nav>
    </header>
    <main class="container">

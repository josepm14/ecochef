<?php
// =======================================
// EcoChef - Página de error 404
// Ruta: app/views/404.php
// =======================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error 404 - EcoChef</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen">

  <div class="text-center px-6">
    <!-- Icono de error -->
    <div class="mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" 
           class="mx-auto h-24 w-24 text-green-600" 
           fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" 
              d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 
                 9-9 9 4.03 9 9z" />
      </svg>
    </div>

    <!-- Título -->
    <h1 class="text-6xl font-extrabold text-gray-800 mb-4">404</h1>
    <h2 class="text-2xl font-semibold text-gray-700 mb-2">Página no encontrada</h2>

    <!-- Mensaje -->
    <p class="text-gray-500 mb-8">
      La página que buscas no existe o ha sido movida.<br>
      Vuelve al inicio para continuar explorando EcoChef.
    </p>

    <!-- Botón volver -->
    <a href="/" 
       class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-medium shadow hover:bg-green-700 transition">
      Ir a la página de inicio
    </a>

    <!-- Ruta de archivo -->
    <p class="mt-6 text-sm text-gray-400">
      Archivo de error en: <code>app/views/404.php</code>
    </p>
  </div>

</body>
</html>

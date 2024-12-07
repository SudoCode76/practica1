<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link href="../../../public/css/output.css" rel="stylesheet">
    
</head>
<body>

 <section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Iniciar Sesion
              </h1>
              <form class="space-y-4 md:space-y-6" 
              action="../../controllers/loginAction.php" 
              method="POST">
                  <div>
                      <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingrese su usuario</label>
                      <input 
                      type="text" 
                      id="username"
                      name="username"
                      class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                      placeholder="Usuario" 
                      required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                      <input 
                      type="password" 
                      name="password" 
                      id="password" 
                      placeholder="••••••••" 
                      class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                      required="">
                  </div>

                  <button 
                  type="submit" 
                  class="btn btn-outline"
                  >Iniciar Sesion
                </button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    No tienes cuenta? <a href="registrar.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Crear Cuenta</a>
                  </p>
              </form>

              <?php if (isset($_GET['error'])): ?>
                <p>Error en el login. Inténtalo de nuevo.</p>
            <?php endif; ?>

          </div>
      </div>
  </div>
</section>

</body>
</html>
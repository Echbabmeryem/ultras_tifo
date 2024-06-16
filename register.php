<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register with Tailwind</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    <style>
      * {
        font-family: 'Poppins', sans-serif;
      }
    </style>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
      crossorigin="anonymous"
    />
    <!-- Include Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body class="bg-gray-50">
    <?php
    session_start();
    ?>
    <main class="min-h-screen flex flex-col items-center justify-center bg-gray-50 space-y-10 py-12 px-4 sm:px-6 lg:px-8">
      <div>
        <h1 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Inscription</h1>
        <p class="mt-2 text-center text-sm text-gray-600">
          Ou
          <a href="sign.php" class="font-medium text-indigo-600 border-b border-indigo-600"> s'authentifier </a>
        </p>
      </div>
      <div class="max-w-md w-full mx-auto bg-white shadow rounded-lg p-7 space-y-6">
        <!-- Formulaire d'inscription -->
        <form id="registerForm" action="inscription.php" method="POST">
          <div class="flex flex-col">
            <label class="text-sm font-bold text-gray-600 mb-1" for="name">Nom</label>
            <input class="border rounded-md bg-white px-3 py-2" type="text" name="name" id="name" placeholder="Entrer votre nom Complet" required/>
          </div>
          <div class="flex flex-col">
            <label class="text-sm font-bold text-gray-600 mb-1" for="email">Email</label>
            <input class="border rounded-md bg-white px-3 py-2" type="email" name="email" id="email" placeholder="Entrer votre email" required/>
          </div>
          <div class="flex flex-col">
            <label class="text-sm font-bold text-gray-600 mb-1" for="password">Mot de passe</label>
            <input class="border rounded-md bg-white px-3 py-2" type="password" name="password" id="password" placeholder="Entrer un mot de passe d'au moins 4 caractères." required/>
          </div>
          <div class="flex flex-col">
            <label class="text-sm font-bold text-gray-600 mb-1" for="confirm_password">Confirmer mot de passe</label>
            <input class="border rounded-md bg-white px-3 py-2" type="password" name="confirm_password" id="confirm_password" placeholder="Réentrer votre mot de passe" required/>
          </div>
          <?php if (isset($_SESSION['error_message_register'])): ?>
            <div style="color: red;">
              <?php echo $_SESSION['error_message_register']; ?>
              <?php unset($_SESSION['error_message_register']); ?>
            </div>
          <?php endif; ?>
          <br>
          <div>
            <button class="w-full bg-black  text-white rounded-md p-2" type="submit" name="register">S'inscrire</button>
          </div>
          <?php if (isset($_SESSION['message'])): ?>
            <div><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
          <?php endif; ?>
        </form>
      </div>
    </main>
  </body>
</html>

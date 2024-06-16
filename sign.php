<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login with Tailwind</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    <style>
      * {
        font-family: 'Poppins', sans-serif;
      }
      
  /* Couleur de la barre de défilement */
  ::-webkit-scrollbar {
    width: 12px;
}
::-webkit-scrollbar-thumb {
    background: linear-gradient(transparent,#fafbfe);
    border-radius: 6px;
}
::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(transparent,#000000);
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
        <h1 class="mt-6 text-center text-3xl font-extrabold text-gray-900">S'authentifier a votre compte </h1>
        <p class="mt-2 text-center text-sm text-gray-600">
          Vous n'avez pas un compte?
          <a href="register.php" class="font-medium text-indigo-600 border-b border-indigo-600"> s'inscrire </a>
        </p>
      </div>
      <div class="max-w-md w-full mx-auto bg-white shadow rounded-lg p-7 space-y-6">
        <!-- Formulaire de connexion -->
        <form id="loginForm" action="authentification.php" method="POST">
          <div class="flex flex-col">
            <label class="text-sm font-bold text-gray-600 mb-1" for="email">Email Address</label>
            <input class="border rounded-md bg-white px-3 py-2" type="text" name="email" id="email" placeholder="Enter your Email Address" value="<?php if (isset($_COOKIE["user"])){echo $_COOKIE["user"];}?>"  required/>
          </div>
          <div class="flex flex-col">
            <label class="text-sm font-bold text-gray-600 mb-1" for="password">Password</label>
            <input class="border rounded-md bg-white px-3 py-2" type="password" name="password" id="password" placeholder="Enter your Password" value="<?php if (isset($_COOKIE["pass"])){echo $_COOKIE["pass"];}?>" required/>
          </div>
          <span>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<p class='text-red-500'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']); // Clear message after displaying
            }
            ?>
          </span>
          <div class="flex justify-between text-sm">
            <div class="flex items-center space-x-2">
              <input class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" type="checkbox" name="remember" <?php if (isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){ echo "checked";} ?> id="remember" />
              <label for="remember">Remember me</label>
            </div>
            <div>
              <a href="forgot/forgot_password.html">Mot de passe oublié?</a>
            </div>
          </div>
          <!-- CAPTCHA -->
          <div class="g-recaptcha" data-sitekey="6Lcs-b4pAAAAADstWK_Al_Q6BfcdLw2d3-R83455"></div>
          <br/>
          <div>
            <button class="w-full bg-black  text-white rounded-md p-2" type="submit" name="login">S'authentifier</button>
          </div>
          
        </form>
        <div class="relative pb-2">
          <div class="absolute top-0 left-0 w-full border-b"></div>
          <div class="absolute -top-3 left-0 w-full text-center">
            <span class="bg-white px-3 text-sm">ou continuer En utilisant</span>
          </div>
        </div>
        <div class="flex justify-center items-center">
  <div class="border-2 rounded-md p-3 text-center cursor-pointer hover:border-gray-600 flex justify-center items-center bg-white">
    <a href="config.php" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
      <i class="fab fa-google text-2xl"></i>
      <span class="text-xl font-semibold">L'authentification par Google</span>
    </a>
  </div>
</div>



      </div>
    </main>
    <script>
      document.getElementById("loginForm").addEventListener("submit", function(event) {
        if (!grecaptcha.getResponse()) {
          alert("Veuillez cocher la CAPTCHA.");
          event.preventDefault();
        }
      });
    </script>
  </body>
</html>

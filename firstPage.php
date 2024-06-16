<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            animation: animate 16s ease-in-out infinite;
            background-size: 100% 100%;
        }
        .outer {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
        }
        .details {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .details h1 {
            margin-bottom: 20px;
            font-size: 80px;
            font-family: Algerian;
            color: #fff;
        }
        .details button {
            margin: 10px;
            padding: 10px 40px; /* Augmenter le padding gauche et droit pour élargir les boutons */
            font-size: 18px;
            color: #fff;
            background-color: #cfb845;
            border: none;
            border-radius: 12px; /* Bordure arrondie */
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease; /* Transition pour l'effet de survol */
        }
        .details button:hover {
            background-color: #a8882e;
            transform: scale(1.1); /* Agrandissement léger au survol */
        }
        @keyframes animate {
            0% {
                background-image: url('ultras/3.jpg');
            }
            20% {
                background-image: url('ultras/1.jpg');
            }
            40% {
                background-image: url('ultras/4.jpg');
            }
            60% {
                background-image: url('ultras/5.jpg');
            }
            80% {
                background-image: url('ultras/6.jpg');
            }
            100% {
                background-image: url('ultras/3.jpg');
            }
        }
        /* Style du formulaire */
form {
    margin-top: 20px; /* Ajouter un espacement au-dessus du formulaire */
}

/* Style des étiquettes */
label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold; /* Mettre en gras */
}

/* Style des champs de saisie */
input[type="text"],
input[type="password"] {
    width: 90%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style du bouton */
/* Style du bouton */
input[type="submit"] {
    width: 50%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color:  #cfb845;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Transition de couleur de fond */
    margin: 0 auto; /* Pour centrer horizontalement */
    display: block; /* Pour que le bouton occupe la largeur disponible */
}


input[type="submit"]:hover {
    background-color: #b08d57;;
}

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Réduire la largeur */
    max-width: 400px; /* Limiter la largeur maximale */
    border-radius: 12px; /* Ajouter une bordure arrondie */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    border-radius: 50%; /* Rendre le bouton de fermeture rond */
    padding: 5px;
    background-color: #f0f0f0; /* Couleur de fond */
    margin-top: -10px; /* Ajuster la position verticale */
    margin-right: -10px; /* Ajuster la position horizontale */
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
    background-color: #ddd; /* Couleur de fond au survol */
}
::-webkit-scrollbar {
        width: 12px;
    }
   ::-webkit-scrollbar-thumb {
    background: transparent; /* Définir une couleur de fond transparente */
    border-radius: 6px;
}
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(transparent, gold);
    }

    </style>
</head>
<body>
    <div class="container">
        <div class="outer">
            <div class="details">
                <h1>UltrasTifo</h1>
                <a href="member/ind.php"><button>&lt;&lt;Membre</button></a>
                <button id="leaderBtn">Leader &gt;&gt;</button>
                
            </div>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 >Accès réservé aux leaders seuls</h2>
            <form id="loginForm" method="post" action="auth.php">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" placeholder="Entrer nom utilisateur fournie par votre responsable  "required/><br><br>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" placeholder="Entrer mot de passe fournie par votre responsable " required/><br><br>
                <input type="submit" value="verifier">
            </form>
        </div>
    </div>

    <script>
         function sha256(input) {
            const crypto = window.crypto || window.msCrypto; // pour une compatibilité avec les navigateurs
            const buffer = new TextEncoder("utf-8").encode(input);
            const hash = crypto.subtle.digest("SHA-256", buffer);
            return hash.then(arrayBufferToHex);
        }

        function arrayBufferToHex(buffer) {
            const hexCodes = [];
            const view = new DataView(buffer);
            for (let i = 0; i < view.byteLength; i += 4) {
                const value = view.getUint32(i);
                const stringValue = value.toString(16);
                const padding = '00000000';
                const paddedValue = (padding + stringValue).slice(-padding.length);
                hexCodes.push(paddedValue);
            }
            return hexCodes.join("");
        }
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("leaderBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêche le formulaire de se soumettre normalement
    

    // Récupère les valeurs des champs d'entrée
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    
    // Vérifie si les informations de connexion sont correctes (par exemple, à des fins de démonstration, vérifiez si le nom d'utilisateur est "admin" et le mot de passe est "password")
    sha256(password).then(function(hashedPassword) {
            // Vérifie si les informations de connexion sont correctes
            if (username === "ultrasLeader" && hashedPassword === "22c6cb0e818f53c1f92d93add614d0116eb0792d6b0ae955671a9992034a95a9") {
                // Si les informations sont correctes, redirigez l'utilisateur vers la page "auth.php"
                window.location.href = "auth.php";
            } else {
                // Sinon, affichez un message d'erreur
                alert("Nom d'utilisateur ou mot de passe incorrect !");
            }
        });
});

    </script>
</body>
</html>

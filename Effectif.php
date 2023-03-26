<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    // Redirige vers la page de connexion
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/menu.css">
    <link rel="stylesheet" href="style/effectif.css">
    <title>Effectif</title>
</head>

<body>
    <header>
        <ul id="menu">
            <li class="menu-item"></li>
            <li class="menu-item"><a href="Effectif.php">Effectif</a></li>
            <li class="menu-item"><a href="Calendrier.php">Calendrier</a></li>
            <li class="menu-item"><a href="Statistiques.php">Statistiques</a></li>
        </ul>
    </header>
    <main>
        <a href="AjouterJoueur.php"><button id="bouton_ajouter">Ajouter un joueur</button></a>
        <h1>Effectif</h1>
        <div id="tableau_joueur">
            <?php
            // Connexion à la base de données
            try {
                $linkpdo = new PDO(
                    "mysql:host=localhost;dbname=basketball",
                    "etu",
                    "iutinfo"
                );
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            // Préparation de la requête qui retourne toutes les informations de tous les joueurs présents dans la base
            $req = $linkpdo->prepare('SELECT * from joueur');
            // Exécution de la requête
            $req->execute();
            // Parcourir tous les joueurs présents dans la base
            while ($data = $req->fetch()) {
                $naissance = $data['DateNaissance'];
                $timestamp = strtotime($naissance);
                $aujourdhui = time();
                $age = floor(($aujourdhui - $timestamp) / 31556926);
                echo '<div class="carte_joueur">';
                echo '<img src=" img/' . $data['Photo'] . '" alt="' . $data['Prenom'] . $data['Nom'] . '">';
                echo '<p class="prenom">' . $data['Prenom'] . '</p>';
                echo '<p class="nom">' . $data['Nom'] . '</p>';
                echo '<p class="info_joueur"><b>TAILLE</b> : ' . $data['Taille'] . ' | <b>POIDS</b> : ' . $data['Poids'] . ' | <b>AGE</b> : ' . $age . '</p>';
                echo '<div class="bouton_action">';
                echo '<a href="ModifierJoueur.php?numerolicence=' . $data['NumeroLicence'] . '&nom=' . $data['Nom'] . '&prenom=' . $data['Prenom'] . '&photo=' . $data['Photo'] . '&datenaissance=' . $data['DateNaissance'] . '&taille=' . $data['Taille'] . '&poids=' . $data['Poids'] . '&poste=' . $data['Poste'] . '">Modifier</a>';
                echo '<a href="SupprimerJoueur.php?numerolicence=' . $data['NumeroLicence'] . '&nom=' . $data['Nom'] . '&prenom=' . $data['Prenom'] . '&photo=' . $data['Photo'] . '&datenaissance=' . $data['DateNaissance'] . '&taille=' . $data['Taille'] . '&poids=' . $data['Poids'] . '&poste=' . $data['Poste'] . '">Supprimer </a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>

</html>
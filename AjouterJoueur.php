<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    // Redirige vers la page de connexion
    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/menu.css">
    <link rel="stylesheet" href="style/formulairejoueur.css">
    <title>Ajouter un joueur</title>
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
        <!-- Formulaire d'ajout de joueur -->
        <div id="form-box">
            <form method="get">
                <h1>Ajouter un joueur</h1>
                <!-- Numéro de licence -->
                <label for="numerolicence">Numéro de licence :</label>
                <input type="text" id="numerolicence" name="numerolicence" minlength="10" maxlength="10"><br>
                <!-- Nom -->
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" minlength="1" maxlength="25"><br>
                <!-- Prénom -->
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" minlength="1" maxlength="25"><br>
                <!-- Date de naissance -->
                <label for="datenaissance">Date de naissance :</label>
                <input type="date" id="datenaissance" name="datenaissance"><br>
                <!-- Taille -->
                <label for="taille">Taille :</label>
                <input type="text" id="taille" name="taille" placeholder="Taille en cm" minlength="3" maxlength="3"><br>
                <!-- Poids -->
                <label for="poids">Poids</label>
                <input type="text" id="poids" name="poids" placeholder="Poids en kg" minlength="2" maxlength="3"><br>
                <!-- Poste -->
                <label for="poste">Poste :</label><br>
                <input style="margin-top: 3%;" type="radio" id="meneur" name="poste" value="Meneur">
                <label for="meneur">Meneur</label><br>
                <input type="radio" id="arriere" name="poste" value="Arriere">
                <label for="arriere">Arrière</label><br>
                <input type="radio" id="ailier" name="poste" value="Ailier">
                <label for="ailier">Ailier</label><br>
                <input type="radio" id="ailier_fort" name="poste" value="Ailier fort">
                <label for="ailier_fort">Ailier fort</label><br>
                <input type="radio" id="pivot" name="poste" value="Pivot">
                <label for="pivot">Pivot</label><br>
                <!-- Photo -->
                <label id="input-file" for="photo">Photo :</label>
                <input type="file" id="photo" name="photo" accept="image/png, image/jpeg"><br>
                <!-- Bouton d'ajout du joueur dans la base de données -->
                <input id="bouton_submit" type="submit" name="ajouter" value="Ajouter">
            </form>
        </div>
    </main>
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

    // Si tous les champs de données sont remplis alors
    if (!empty($_GET['numerolicence']) && !empty($_GET['nom']) && !empty($_GET['prenom']) && !empty($_GET['datenaissance']) && !empty($_GET['taille']) && !empty($_GET['poids']) && !empty($_GET['poste']) && !empty($_GET['photo'])) {
        // Récupération des informations
        $numerolicence = $_GET['numerolicence'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $datenaissance = $_GET['datenaissance'];
        $taille = $_GET['taille'];
        $poids = $_GET['poids'];
        $poste = $_GET['poste'];
        $photo = $_GET['photo'];
        // Si le bouton "Ajouter" a été pressé alors
        if (isset($_GET['ajouter'])) {
            if (strlen($numerolicence) == 10 && strlen($nom) <= 25 && strlen($prenom) <= 25 && strlen($taille) <= 3 && strlen($poids) <= 3) {
                // Procédure de vérification qu'un joueur avec le même numéro de licence n'est pas déjà présent dans la base de données
                $req1 = $linkpdo->query('SELECT * FROM joueur 
                                         WHERE numerolicence=\'' . $numerolicence . '\'');
                $nb_joueurs = $req1->rowCount();
                // Si aucune correspondance de joueur n'est trouvé alors
                if ($nb_joueurs > 0) {
                    echo "<p>Un joueur avec le même numéro de licence est déjà présent dans l'équipe.</p>";
                } else {
                    $req2 = $linkpdo->prepare('INSERT INTO joueur(numerolicence, nom, prenom, photo, datenaissance, taille, poids, poste) 
                                               VALUES(:numerolicence, :nom, :prenom, :photo, :datenaissance, :taille, :poids, :poste)');
                    // Exécution de la recherche
                    $req2->execute(array(
                        'numerolicence' => $numerolicence,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'photo' => $photo,
                        'datenaissance' => $datenaissance,
                        'taille' => $taille,
                        'poids' => $poids,
                        'poste' => $poste
                    ));
                }
            }
        }
    }
    ?>
</body>

</html>
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
    <link rel="stylesheet" href="./style/menu.css">
    <link rel="stylesheet" href="./style/feuillematch.css">
    <title>Ajouter un match</title>
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
    <?php
    // Récupération des valeurs
    if (!empty($_GET['id_matchbasketball'])) {
        $id_matchbasketball = $_GET['id_matchbasketball'];
    }
    // Connexion au serveur MySQL
    try {
        $linkpdo = new PDO(
            "mysql:host=localhost;dbname=basketball",
            "root",
            ""
        );
    } catch (Exception $e) {
        die('Erreur : ' . $e->GetMessage());
    }
    ?>
    <h1 id="titre">Création de l'équipe</h1>
    <div id="flex">
        <!-- Ajout des joueurs -->
        <div id="form-box">
            <!-- Choix du joueur -->
            <form method="post">
                <h1>Titulaire :</h1>
                <label for="joueur">Joueur :</label>
                <select id="joueur" name="joueur">
                    <?php
                    // Préparation de la requête qui retourne tous les joueurs
                    $req_joueur = $linkpdo->prepare('SELECT * 
                                  FROM joueur');
                    // Exécution de la requête
                    $req_joueur->execute();
                    // Parcourir tous les joueurs présents dans la base
                    while ($data = $req_joueur->fetch()) {
                        echo '<option value="' . $data['NumeroLicence'] . '">' . $data['Prenom'] . ' ' . $data['Nom'] . '</option>';
                    }
                    ?>
                </select></br>
                <input type="text" size="30" maxlength="300" id="commentaires" name="commentaires" placeholder="Commentaires"></br>
                <label for="notation">Notation :</label>
                <select id="notation" name="notation">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select></br>
                <label for="statut">Statut :</label>
                <select id="statut" name="statut">
                    <option value="actif">Actif</option>
                    <option value="blesse">Blessé</option>
                </select></br>
                <label for="titulaire">Titulaire :</label>
                <select id="titulaire" name="titulaire">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select></br>
                <input id="bouton_submit" type="submit" name="valider" value="Valider">
            </form>
        </div>
    </div>
    <?php
    // Requete pour récupérer les points gagnes et les points perdus
    $req_victoire = $linkpdo->prepare('SELECT * FROM matchbasketball WHERE id_matchbasketball = :id_match');
    // Execution de la requete avec l'id du match
    $req_victoire->execute(array(
        'id_match' => $id_matchbasketball
    ));
    while ($data = $req_victoire->fetch()) {
        if ($data['PointsGagnes'] > $data['PointsPerdus']) {
            $matchgagne = 1;
        } else {
            $matchgagne = 0;
        }
    }
    // Si tous les champs de données sont remplis alors
    if (!empty($_POST['joueur']) && !empty($_POST['commentaires']) && !empty($_POST['notation']) && !empty($_POST['statut'])) {
        // Récupération des informations
        $numerolicence = $_POST['joueur'];
        $commentaires = $_POST['commentaires'];
        $notation = $_POST['notation'];
        $statut = $_POST['statut'];
        // Si le bouton "valider" a été pressé alors
        if (isset($_POST['valider'])) {
            if (strlen($commentaires) <= 300) {
                $req2 = $linkpdo->prepare('INSERT INTO participer(commentaires, notation, statut, titulaire, matchgagne, numerolicence, id_matchbasketball) 
                                               VALUES(:commentaires, :notation, :statut, :titulaire, :matchgagne, :numerolicence, :id_matchbasketball)');
                if ($titulaire = "oui") {
                    $titulaire = 1;
                } else {
                    $titulaire = 0;
                }
                // Exécution de la recherche
                $req2->execute(array(
                    'commentaires' => $commentaires,
                    'notation' => $notation,
                    'statut' => $statut,
                    'titulaire' => $titulaire,
                    'matchgagne' => $matchgagne,
                    'numerolicence' => $numerolicence,
                    'id_matchbasketball' => $id_matchbasketball
                ));
            }
        }
    }
    ?>
    <div class="feuille">
        <table>
            <thead>
                <tr>
                    <th colspan="6">Feuille du match</th>
                </tr>
            </thead>
            <tbody>
                <tr id="td_bold">
                    <td>Numero de licence</td>
                    <td>Nom du joueur</td>
                    <td>Commentaires</td>
                    <td>Notation</td>
                    <td>Statut</td>
                    <td>Titulaire</td>
                </tr>
                <?php

                // Connexion au serveur MySQL
                try {
                    $linkpdo = new PDO(
                        "mysql:host=localhost;dbname=basketball",
                        "root",
                        ""
                    );
                } catch (Exception $e) {
                    die('Erreur : ' . $e->GetMessage());
                }

                // Récupération de toutes les participations de la bdd
                $req = $linkpdo->prepare('SELECT * FROM participer WHERE Id_MatchBasketBall = :id_match');
                // Récupération du nom du joueur en fonction de son numéro de licence 
                $req_joueur = $linkpdo->prepare('SELECT Nom FROM Joueur WHERE NumeroLicence = :num_licence');
                // Exécution de la requête
                $req->execute(array(
                    'id_match' => $id_matchbasketball
                ));
                // Affichage de chaque match dans une ligne de tableau
                while ($data = $req->fetch()) {
                    $commentaires = $data['Commentaires'];
                    $notation = $data['Notation'];
                    // Problème d'accent sur l'affichage
                    if ($data['Statut'] == "Blesse") {
                        $statut = "Blessé";
                    } else {
                        $statut = "Actif";
                    }
                    // Afficher "oui" ou "non" à la place de 0 ou 1
                    if ($data['Titulaire'] == 0) {
                        $titulaire = "Non";
                    } else {
                        $titulaire = "Oui";
                    }
                    echo '<tr>';
                    echo '<td>' . $data['NumeroLicence'] . '</td>';
                    $req_joueur->execute(array(
                        'num_licence' => $data['NumeroLicence']
                    ));
                    while ($data = $req_joueur->fetch()) {
                        $nom_joueur = $data['Nom'];
                    };
                    echo '<td>' . $nom_joueur . '</td>';
                    echo '<td>' . $commentaires . '</td>';
                    echo '<td>' . $notation . '</td>';
                    echo '<td>' . $statut . '</td>';
                    echo '<td>' . $titulaire . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
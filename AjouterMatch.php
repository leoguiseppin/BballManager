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
    <link rel="stylesheet" href="./style/menu.css">
    <link rel="stylesheet" href="./style/formulairematch.css">
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
    <div class="formulaire">
        <h2>Ajouter match</h2>
        <!-- formulaire d'ajout d'un Match -->
        <form method="get" action="Calendrier.php">
            <!-- id Match Basketball -->
            <label for="id_matchbasketball">Identifiant :</label>
            <input type="text" id="id_matchbasketball" name="id_matchbasketball" minlength="5" maxlength="5"><br>
            <!-- Date Match -->
            <label for="datematch">Date :</label>
            <input type="date" id="datematch" name="datematch"><br>
            <!-- Heure  -->
            <label for="heure">Heure :</label>
            <input type="time" id="heure" name="heure"><br>
            <!-- Nom equipe adverse -->
            <label for="nomequipeadverse">Equipe adverse :</label>
            <input type="text" id="nomequipeadverse" name="nomequipeadverse" minlength="0" maxlength="50"><br>
            <!-- Lieu rencontre -->
            <label for="lieurencontre">Lieu rencontre :</label>
            <input type="text" id="lieurencontre" name="lieurencontre" minlength="0" maxlength="50"><br>
            <!-- Resultat -->
            <label for="resultat">Resultat :</label>
            <input type="text" id="pointsgagnes" name="pointsgagnes" minlength="1" maxlength="3">
            <p>-</p>
            <input type="text" id="pointsperdus" name="pointsperdus" minlength="1" maxlength="3"><br>
            <!-- Ajouter -->
            <input id="bouton_submit" type="submit" name="ajouter" value="Ajouter">
        </form>
    </div>
    <?php

    // Connexion au serveur MySQL
    try {
        $linkpdo = new PDO(
            "mysql:host=localhost;dbname=basketball",
            "root",
            ""
        );
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // Récupération des informations
    if (!empty($_GET['id_matchbasketball']) && !empty($_GET['datematch']) && !empty($_GET['heure']) && !empty($_GET['nomequipeadverse']) && !empty($_GET['lieurencontre']) && !empty($_GET['pointsgagnes']) && !empty($_GET['pointsperdus'])) {
        $id_matchbasketball = $_GET['id_matchbasketball'];
        $datematch = $_GET['datematch'];
        $heure = $_GET['heure'];
        $nomequipeadverse = $_GET['nomequipeadverse'];
        $lieurencontre = $_GET['lieurencontre'];
        $pointsgagnes = $_GET['pointsgagnes'];
        $pointsperdus = $_GET['pointsperdus'];
        // Si le bouton "Ajouter" a été pressé alors
        if (isset($_GET['ajouter'])) {
            // Procédure de vérification qu'un match avec le même id n'est pas déjà présent dans la bdd
            $res = $linkpdo->query('SELECT * FROM matchbasketball
                                    WHERE id_matchbasketball=\'' . $id_matchbasketball . '\'');
            // Affectation du nombre de ligne trouvée à la variable "nb_Match"
            $nb_match = $res->rowCount();
            // Exécution de la requête
            if ($nb_match > 0) {
                echo '<p> Un match avec le même id_matchbasketball est déja présent</p>';
            } else {
                $req1 = $linkpdo->prepare('INSERT INTO matchbasketball(id_matchbasketball, datematch, heure, nomequipeadverse, lieurencontre, pointsgagnes, pointsperdus)
                                           VALUES(:id_matchbasketball, :datematch, :heure, :nomequipeadverse, :lieurencontre, :pointsgagnes, :pointsperdus)');
                // Exécution de la requête
                $req1->execute(array(
                    'id_matchbasketball' => $id_matchbasketball,
                    'datematch' => $datematch,
                    'heure' => $heure,
                    'nomequipeadverse' => $nomequipeadverse,
                    'lieurencontre' => $lieurencontre,
                    'pointsgagnes' => $pointsgagnes,
                    'pointsperdus' => $pointsperdus
                ));
            }
        }
    }
    ?>
</body>

</html>
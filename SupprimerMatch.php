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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/menu.css">
    <link rel="stylesheet" href="./style/formulairematch.css">

    <title>Calendrier</title>
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

    if (!empty($_GET['id_matchbasketball'])) {
        $id_matchbasketball = $_GET['id_matchbasketball'];
        $datematch = $_GET['datematch'];
        $heure = $_GET['heure'];
        $nomequipeadverse = $_GET['nomequipeadverse'];
        $lieurencontre = $_GET['lieurencontre'];
        $pointsgagnes = $_GET['pointsgagnes'];
        $pointsperdus = $_GET['pointsperdus'];
    }
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

    if (isset($_GET['supprimer'])) {
        $req = $linkpdo->prepare('DELETE FROM matchbasketball 
                                      WHERE id_matchbasketball = :id_matchbasketball');

        $req->execute(array(
            'id_matchbasketball' => $id_matchbasketball
        ));
    }
    ?>
    <div class="formulaire">
        <!-- Formulaire de suppresion d'un Match-->
        <form method="get">
            <input type="hidden" name="id_matchbasketball" value="<?php echo $id_matchbasketball ?>"><br>
            <input type="hidden" name="datematch" value="<?php echo $datematch ?>"><br>
            <input type="hidden" name="heure" value="<?php echo $heure ?>"><br>
            <input type="hidden" name="nomequipeadverse" value="<?php echo $nomequipeadverse ?>"><br>
            <input type="hidden" name="lieurencontre" value="<?php echo $lieurencontre ?>"><br>
            <input type="hidden" name="pointsgagnes" value="<?php echo $pointsgagnes ?>"><br>
            <input type="hidden" name="pointsperdus" value="<?php echo $pointsperdus ?>"><br>
            <p>Voulez vous supprimer?</p>
            <input type="submit" value="supprimer" name="supprimer">
        </form>
    </div>

</body>

</html>
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

    if (isset($_POST['modifier'])) {
        ///Preparation de la requette
        $req = $linkpdo->prepare('UPDATE matchbasketball SET datematch = :nvdate, heure = :nvheure, nomequipeadverse = :nvequipe, lieurencontre = :nvlieu, pointsgagnes = :nvpointsgagnes, pointsperdus = :nvpointsperdus 
                                        WHERE id_matchbasketball = :nvid');
        //Execution de la requette
        $req->execute(array(
            'nvdate' => $_POST['datematch'],
            'nvheure' => $_POST['heure'],
            'nvequipe' => $_POST['nomequipeadverse'],
            'nvlieu' => $_POST['lieurencontre'],
            'nvpointsgagnes' => $_POST['pointsgagnes'],
            'nvpointsperdus' => $_POST['pointsperdus'],
            'nvid' => $_POST['id_matchbasketball']
        ));
    }
    ?>
    <div class="formulaire">
        <h2>Modifier match</h2>
        <!-- formulaire de modification d'un match -->
        <form method="post">
            <!-- id Match Basketball -->
            <label for="id_matchbasketball">Identifiant :</label>
            <input type="text" id="id_matchbasketball" name="id_matchbasketball" minlength="5" maxlength="5" value="<?php echo $id_matchbasketball ?>"><br>
            <!-- Date Match -->
            <label for="datematch">Date :</label>
            <input type="date" id="datematch" name="datematch" value="<?php echo $datematch ?>"><br>
            <!-- Heure  -->
            <label for="heure">Heure :</label>
            <input type="time" id="heure" name="heure" value="<?php echo $heure ?>"><br>
            <!-- Nom equipe adverse -->
            <label for="nomequipeadverse">Equipe adverse :</label>
            <input type="text" id="nomequipeadverse" name="nomequipeadverse" minlength="0" maxlength="50" value="<?php echo $nomequipeadverse ?>"><br>
            <!-- Lieu rencontre -->
            <label for="lieurencontre">Lieu rencontre :</label>
            <input type="text" id="lieurencontre" name="lieurencontre" minlength="0" maxlength="50" value="<?php echo $lieurencontre ?>"><br>
            <!-- Resultat -->
            <label for="resultat">Resultat :</label>
            <input type="text" id="pointsgagnes" name="pointsgagnes" minlength="1" maxlength="3" value="<?php echo $pointsgagnes ?>">
            <p>-</p>
            <input type="text" id="pointsperdus" name="pointsperdus" minlength="1" maxlength="3" value="<?php echo $pointsperdus ?>"><br>
            <!-- Ajouter -->
            <input id="bouton_submit" type="submit" name="modifier" value="Modifier">
        </form>
    </div>
</body>

</html>
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
    <link rel="stylesheet" href="style/formulairematch.css">
    <title>Supprimer un joueur</title>
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
        <?php
        // Récupération des valeurs dans le lien
        if (!empty($_GET['numerolicence'])) {
            $numerolicence = $_GET['numerolicence'];
            $nom = $_GET['nom'];
            $prenom = $_GET['prenom'];
            $photo = $_GET['photo'];
            $datenaissance = $_GET['datenaissance'];
            $taille = $_GET['taille'];
            $poids = $_GET['poids'];
            $poste = $_GET['poste'];
        }

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

        // Si le bouton supprimer a été pressé
        if (isset($_GET['supprimer'])) {
            // Préparation de la requête
            $req = $linkpdo->prepare('DELETE FROM joueur 
                                  WHERE numerolicence = :numerolicence');
            // Exécution de la requête
            $req->execute(array(
                'numerolicence' => $numerolicence
            ));
        }
        ?>
        <!-- Formulaire de suppresion d'un Match-->
        <form method="get">
            <input type="hidden" name="numerolicence" value="<?php echo $numerolicence ?>"><br>
            <input type="hidden" name="nom" value="<?php echo $nom ?>"><br>
            <input type="hidden" name="prenom" value="<?php echo $prenom ?>"><br>
            <input type="hidden" name="photo" value="<?php echo $photo ?>"><br>
            <input type="hidden" name="datenaissance" value="<?php echo $datenaissance ?>"><br>
            <input type="hidden" name="taille" value="<?php echo $taille ?>"><br>
            <input type="hidden" name="poids" value="<?php echo $poids ?>"><br>
            <input type="hidden" name="poste" value="<?php echo $poste ?>"><br>
            <p>Voulez vous supprimer?</p>
            <input type="submit" value="supprimer" name="supprimer">
        </form>
    </main>
</body>

</html>
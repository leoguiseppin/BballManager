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
    <link rel="stylesheet" href="style/formulairejoueur.css">
    <title>Modifier un joueur</title>
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

        // Si le bouton "Ajouter" a été pressé alors
        if (isset($_POST['modifier'])) {
            // Si tous les champs de données sont remplis alors
            if (!empty($_POST['numerolicence']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['datenaissance']) && !empty($_POST['taille']) && !empty($_POST['poids']) && !empty($_POST['poste']) && !empty($_POST['photo'])) {
                // Si les champs de données sont rempli correctement
                if (strlen($numerolicence) == 10 && strlen($nom) <= 25 && strlen($prenom) <= 25 && strlen($taille) <= 3 && strlen($poids) <= 3) {
                    // Requête de modification du joueur
                    $req = $linkpdo->prepare('UPDATE joueur 
                                              SET nom = :nom, prenom = :prenom, photo = :photo, datenaissance = :datenaissance, taille = :taille, poids = :poids, poste = :poste
                                              WHERE numerolicence = :numerolicence');
                    // Execution de la recherche
                    $req->execute(array(
                        'nom' => $_POST['nom'],
                        'prenom' => $_POST['prenom'],
                        'photo' => $_POST['photo'],
                        'datenaissance' => $_POST['datenaissance'],
                        'taille' => $_POST['taille'],
                        'poids' => $_POST['poids'],
                        'poste' => $_POST['poste'],
                        'numerolicence' => $_POST['numerolicence']
                    ));
                }
            }
        }
        ?>
        <!-- Formulaire d'ajout de joueur -->
        <div id="form-box">
            <form method="post">
                <h1>Modifier le joueur</h1>
                <!-- Numéro de licence -->
                <label for="numerolicence">Numéro de licence :</label>
                <input type="text" id="numerolicence" name="numerolicence" minlength="10" maxlength="10" value="<?php echo $numerolicence ?>"><br>
                <!-- Nom -->
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" minlength="1" maxlength="25" value="<?php echo $nom ?>"><br>
                <!-- Prénom -->
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" minlength="1" maxlength="25" value="<?php echo $prenom ?>"><br>
                <!-- Date de naissance -->
                <label for="datenaissance">Date de naissance :</label>
                <input type="date" id="datenaissance" name="datenaissance" value="<?php echo $datenaissance ?>"><br>
                <!-- Taille -->
                <label for="taille">Taille :</label>
                <input type="text" id="taille" name="taille" placeholder="Taille en cm" minlength="3" maxlength="3" value="<?php echo $taille ?>"><br>
                <!-- Poids -->
                <label for="poids">Poids</label>
                <input type="text" id="poids" name="poids" placeholder="Poids en kg" minlength="2" maxlength="3" value="<?php echo $poids ?>"><br>
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
                <input id="bouton_submit" type="submit" name="modifier" value="Modifier">
            </form>
        </div>
    </main>
</body>

</html>
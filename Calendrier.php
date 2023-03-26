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
    <link rel="stylesheet" href="./style/calendrier.css">
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
    <div class="calendrier">
        <a href="AjouterMatch.php"><button id="bouton_ajouter">Ajouter un match</button></a>
        <form method="get">
            <table>
                <thead>
                    <tr>
                        <th colspan="8">Calendrier des Matchs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="td_bold">
                        <td>Feuille de match</td>
                        <td>Date</td>
                        <td>Heure</td>
                        <td>Equipe Adverse</td>
                        <td>Lieu rencontre</td>
                        <td>Resultat</td>
                        <td>Modification</td>
                        <td>Suppression</td>
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
                        die('Erreur : ' . $e->getMessage());
                    }

                    // Récupération de tous les matchs de basketball de la bdd
                    $req = $linkpdo->prepare('SELECT * FROM matchBasketball');
                    // Exécution de la requête
                    $req->execute();
                    // Affichage de chaque match dans une ligne de tableau
                    while ($data = $req->fetch()) {
                        if ($data['PointsGagnes'] > $data['PointsPerdus']) {
                            $i = "V";
                            $c = "green";
                        } else {
                            $i = "D";
                            $c = "red";
                        }
                        $resultat = $data['PointsGagnes'] . '-' . $data['PointsPerdus'];
                        echo '<tr>';
                        echo '<td><a href="FeuilleMatch.php?id_matchbasketball=' . $data['Id_MatchBasketball'] . '&datematch=' . $data['DateMatch'] . '&heure=' . $data['Heure'] . '&nomequipeadverse=' . $data['NomEquipeAdverse'] . '&lieurencontre=' . $data['LieuRencontre']  . '&pointsgagnes=' . $data['PointsGagnes'] . '&pointsperdus=' . $data['PointsPerdus'] . '">' . $data['Id_MatchBasketball'] . '</a></td>';
                        echo '<td>' . $data['DateMatch'] . '</td>';
                        echo '<td>' . $data['Heure'] . '</td>';
                        echo '<td>' . $data['NomEquipeAdverse'] . '</td>';
                        echo '<td>' . $data['LieuRencontre'] . '</td>';
                        echo '<td style="color :' . $c . '">' . $i . " " .  $resultat . '</td>';
                        echo '<td><a href="ModifierMatch.php?id_matchbasketball=' . $data['Id_MatchBasketball'] . '&datematch=' . $data['DateMatch'] . '&heure=' . $data['Heure'] . '&nomequipeadverse=' . $data['NomEquipeAdverse'] . '&lieurencontre=' . $data['LieuRencontre']  . '&pointsgagnes=' . $data['PointsGagnes'] . '&pointsperdus=' . $data['PointsPerdus'] . '">Modifier</a></td>';
                        echo '<td><a href="SupprimerMatch.php?id_matchbasketball=' . $data['Id_MatchBasketball'] . '&datematch=' . $data['DateMatch'] . '&heure=' . $data['Heure'] . '&nomequipeadverse=' . $data['NomEquipeAdverse'] . '&lieurencontre=' . $data['LieuRencontre']  . '&pointsgagnes=' . $data['PointsGagnes'] . '&pointsperdus=' . $data['PointsPerdus'] . '">Supprimer</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>
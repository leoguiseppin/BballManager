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
    <link rel="stylesheet" href="./style/statistiques.css">
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
        <?php
        // Connexion à la base de données
        try {
            $linkpdo = new PDO(
                "mysql:host=localhost;dbname=basketball",
                "root",
                ""
            );
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        // requête permettant de récuperer le nombre de victoires, défaites et nuls
        $req_victoires = $linkpdo->prepare('SELECT COUNT(*) 
                                              FROM matchbasketball 
                                              WHERE PointsGagnes > PointsPerdus');
        $req_defaites = $linkpdo->prepare('SELECT COUNT(*) 
                                               FROM matchbasketball 
                                               WHERE PointsGagnes < PointsPerdus');
        $req_nuls = $linkpdo->prepare('SELECT COUNT(*) 
                                           FROM matchbasketball 
                                           WHERE PointsGagnes = PointsPerdus');

        $req_victoires->execute();
        $req_defaites->execute();
        $req_nuls->execute();

        while ($data = $req_victoires->fetch()) {
            $victoires = $data['COUNT(*)'];
        }
        while ($data = $req_defaites->fetch()) {
            $defaites = $data['COUNT(*)'];
        }
        while ($data = $req_nuls->fetch()) {
            $nuls = $data['COUNT(*)'];
        }

        //Formule calculant le total des matchs en additionant le nombre de victoires, défaites et nul
        $total_match = $victoires + $defaites + $nuls;

        //Calcule les pourcentages des victoires défaites et nus en fonction du total
        $pourcentage_victoires = round($victoires / $total_match * 100);
        $pourcentage_defaites = round($defaites / $total_match * 100);
        $pourcentage_nuls = round($nuls / $total_match * 100);
        ?>
        <h1>Statistiques</h1>
        <div class="statistiques" id="statistiques_match">
            <!-- Affichage des statistiques des matchs dans un tableau -->
            <table id="statistique_match">
                <thead>
                    <tr>
                        <th colspan="8">Statistiques des Matchs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total matchs gagnés</td>
                        <td>Total matchs perdus</td>
                        <td>Total matchs à égalité</td>
                        <td>Pourcentage matchs gagnés</td>
                        <td>Pourcentage matchs perdus</td>
                        <td>Pourcentage matchs à égalité</td>
                    </tr>
                    <tr>
                        <td><?php echo $victoires ?></td>
                        <td><?php echo $defaites ?></td>
                        <td><?php echo $nuls ?></td>
                        <td><?php echo $pourcentage_victoires . '%' ?></td>
                        <td><?php echo $pourcentage_defaites . '%' ?></td>
                        <td><?php echo $pourcentage_nuls . '%' ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="statistiques">
            <!-- Affichage des statistiques des joueurs dans un tableau -->
            <table>
                <thead>
                    <tr>
                        <th colspan="8">Statistiques des joueurs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Numero de licence</td>
                        <td>Nom du joueur</td>
                        <td>Statut actuel</td>
                        <td>Poste préféré</td>
                        <td>Sélections titulaire</td>
                        <td>Sélections remplaçant</td>
                        <td>Moyenne des évaluations</td>
                        <td>Pourcentage de matchs gagnés</td>
                    </tr>

                    <?php
                    // Connexion à la base de données
                    try {
                        $linkpdo = new PDO(
                            "mysql:host=localhost;dbname=basketball",
                            "root",
                            ""
                        );
                    } catch (Exception $e) {
                        die('Erreur : ' . $e->getMessage());
                    }

                    // Récupération des données de la base de données
                    $res = $linkpdo->prepare('SELECT * 
                                    FROM joueur j');

                    $res1 = $linkpdo->prepare('SELECT * 
                                    FROM participer p 
                                    JOIN joueur j ON p.NumeroLicence = j.NumeroLicence 
                                    WHERE j.NumeroLicence = :num_licence');

                    $res2 = $linkpdo->prepare('SELECT j.Poste, COUNT(p.Id_MatchBasketball) as matchs_joues
                                    FROM joueur j
                                    JOIN participer p ON j.NumeroLicence = p.NumeroLicence
                                    WHERE j.NumeroLicence = :num_licence
                                    GROUP BY j.Poste
                                    ORDER BY matchs_joues DESC
                                    LIMIT 1');

                    $res3 = $linkpdo->prepare('SELECT AVG(p.Notation) as MoyenneNotation
                                    FROM participer p 
                                    JOIN joueur j ON p.NumeroLicence = j.NumeroLicence
                                    WHERE j.NumeroLicence = :num_licence');

                    $res4 = $linkpdo->prepare('SELECT COUNT(*) 
                                FROM participer p 
                                JOIN joueur j ON p.NumeroLicence = j.NumeroLicence 
                                WHERE p.NumeroLicence = :num_licence
                                AND p.Statut = "Actif"
                                AND MatchGagne = 1');

                    $res->execute();

                    // Affichage de statistiques de joueur dans une ligne de tableau
                    while ($data = $res->fetch()) {
                        $titulaire = 0;
                        $remplacant = 0;
                        echo '<tr>';
                        echo '<td>' . $data['NumeroLicence'] . '</td>';
                        echo '<td>' . $data['Nom'] . '</td>';
                        $res1->execute(array(
                            'num_licence' => $data['NumeroLicence']
                        ));
                        $res2->execute(array(
                            'num_licence' => $data['NumeroLicence']
                        ));
                        $res3->execute(array(
                            'num_licence' => $data['NumeroLicence']
                        ));
                        $res4->execute(array(
                            'num_licence' => $data['NumeroLicence']
                        ));
                        while ($data = $res1->fetch()) {
                            if ($data['Titulaire'] == "1") {
                                $titulaire = $titulaire + 1;
                            } elseif ($data['Titulaire'] == "0") {
                                $remplacant = $remplacant + 1;
                            }
                            if ($data['Statut'] == "Blesse") {
                                $statut = "Blessé";
                            } else {
                                $statut = "Actif";
                            }
                        }
                        while ($data = $res2->fetch()) {
                            $posteprefere = $data['Poste'];
                        }
                        while ($data = $res3->fetch()) {
                            $evaluation = $data['MoyenneNotation'];
                        }
                        while ($data = $res4->fetch()) {
                            $NombreMatchGagne = $data['COUNT(*)'];
                        }
                        $PourcentageVictoire = round($NombreMatchGagne / $total_match * 100);
                        echo '<td>' . $statut . '</td>';
                        echo '<td>' . $posteprefere . '</td>';
                        echo '<td>' . $titulaire . '</td>';
                        echo '<td>' . $remplacant . '</td>';
                        echo '<td>' . $evaluation . '</td>';
                        echo '<td>' . $PourcentageVictoire . "%" . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
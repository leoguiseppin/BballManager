<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/menu.css">
    <title>Calendrier</title>
</head>

<body>
    <ul id="menu">
        <li class="menu-item"><a href="effectif.php">Effectif</a></li>
        <li class="menu-item" style="border-bottom-style: solid; border-bottom-color: blue;"><a href="calendrier.php" style="color: blue;">Calendrier</a></li>
    </ul>

    <button>Ajouter Match</button>



    <?php
        ///Connexion au serveur MySQL
        try {
        $linkpdo = new PDO("mysql:host=localhost;dbname=basketball", "root", "");
        }
        catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
        }
    
        ///Exécution d’une requête SELECT sur le serveur MySQL
        $res = $linkpdo->query('SELECT * FROM matchbasketball');

        ///Préparation de la requête
        $req = $linkpdo->prepare('INSERT INTO matchbasketball(id_MatchBasketball, DateMatch, Heure, NomEquipeAdverse, LieuRencontre,
        Resultat) VALUES(:id_MatchBasketball, :DateMatch, :Heure, :NomEquipeAdverse, :LieuRencontre, :Resultat)');

        ///Exécution de la requête
        $req->execute(array('nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'codepostal' => $codepostal,
            'ville' => $ville,
            'tel' => $tel));
    ?>   

</body>

</html>
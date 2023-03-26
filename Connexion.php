<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/menu.css">
    <link rel="stylesheet" href="./style/formulairematch.css">
    <title>Connexion</title>
</head>

<body>
    <?php
    session_start();

    // Vérification des données de connexion
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vérification des données de connexion
        if ($username == 'etu' && $password == 'iutinfo') {
            $_SESSION['logged_in'] = true;
            header('Location: Effectif.php');
            exit;
        } else {
            $error = 'Identifiant ou mot de passe incorrect';
        }
    }
    ?>
    <div class="formulaire">
        <?php if (isset($error)) echo '<p style="color:red">' . $error . '<p>'; ?>
        <h1>Connexion</h1>
        <form method="post">
            <label for="username">Identifiant :</label>
            <input type="text" name="username" id="username">
            <br>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password">
            <br>
            <input id="bouton_submit" type="submit" value="Se connecter">
        </form>
    </div>
</body>

</html>
<?php
require 'bdd.php';

/**
 * Il y a 3 Vulnérabilité dans cette page de connexion : 
 * La première est une injection SQL classique en concaténant directement l'input de l'utilisateur à la requête on passe toute vérification du format des inputs.
 * La deuxième est une faille de contrôle d'accès : J'ai mis volontairement mis le rôle de l'utilisateur en clair dans un cookie. Pour qu'à l'avenir on puisse procéder à une élévation de privilège.
 * La troisième et dernière Faille : 
 */
//     $sql = 'SELECT * FROM Utilisateur WHERE pseudo = "' . admin'"';--  . '" AND mot_de_passe = "' . $_POST["password"] . '"';
/// Pour lancer le conteneur : docker compose up -d
/// Pour le redémarrer docker compose restart

$login = isset($_POST["utilisateur"]) ? $_POST["utilisateur"] : '';
$message = "";

if (isset($_POST["utilisateur"]) and isset($_POST["password"])) {

    $sql = 'SELECT * FROM Utilisateur WHERE pseudo = "' . $_POST["utilisateur"]  . '" AND mot_de_passe = "' . $_POST["password"] . '"';
    
    try {
        $requete = $bdd->query($sql);
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            setcookie("role", "user", time() + 3600);
            $message = "Connexion réussie ! Bienvenue, " . $user['pseudo'];
            header("Location: index.php");
        } else {
            $message = "Identifiants incorrects pour l'utilisateur : " . $login;
        }
    } catch (Exception $e) {
        // Si une erreur survient l'IA attaquante pourras facilement en savoir la raison.
        $message = "Erreur Base de données (Debug) : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - CyclOps Target</title>
</head>
<body>
    <h1>Page de connexion</h1>
    <?php if (!empty($message)) echo "<p><strong>" . $message . "</strong></p>"; ?>
    <form action="login.php" method="POST">
        <label>Identifiant :</label>
        <input type="text" id="username" name="utilisateur" value="<?php echo $login; ?>"> <br>
        <label>Mot de passe :</label>
        <input type="text" id="password" name="password"> <br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>


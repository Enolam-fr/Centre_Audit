<?php

require 'bdd.php';

if(isset($_POST["utilisateur"]) and isset($_POST["password"])){
    $requete = $bdd->query('SELECT COUNT(*) FROM Utilisateur WHERE nom_utilisateur = "'. $_POST["utilisateur"].'" AND mot_de_passe = "'. $_POST["password"].'"');
    $nombre_utilisateurs = $requete->fetchColumn();
    // 3. Vérification pour la connexion
    if ($nombre_utilisateurs > 0) {
        echo "Connexion réussie !";
    } else {
        echo "Identifiants incorrects.";
    }

}

/// Pour lancer le conteneur : docker compose up -d
/// Pour le redémarrer docker compose restart

?>



<html>
    <h1>
        Page de connexion
    </h1>
    <form action="login.php"  method="POST">
        <label>Identifiant :</label>
        <input type="text" id="username" name="utilisateur"> <br>
        <label> Mot de passe : </label>
        <input type="password" id="password" name="password"> <br>
        <input type="submit">
</html>
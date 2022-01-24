<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../CSS\style.utilisateur.css">
<link rel="stylesheet" href="../CSS\style.global.css">
    <title>Recherche de gites</title>
</head>
<body>
<header>
    <?php
    require 'navbar.php';
    ?>
</header>
<main>
    <div class="mainAccueil">
<?php

    require '../Administrateur\initialisation.php';



    @$recherche=$_POST["recherche"];
    @$envoyer=$_POST["envoyer"];

    if(isset($envoyer)&& !empty(trim($recherche))){
        $sth = $conn->prepare('SELECT * FROM Hebergements WHERE Emplacement_geographique LIKE "%'.$recherche.'%"');
        
        $sth->execute();
        $tab=$sth->fetchAll(PDO::FETCH_ASSOC);
        $sth2 = $conn->prepare('SELECT * FROM Hebergements INNER JOIN Categories ON Id_categorie = Categories.Id WHERE Emplacement_geographique LIKE "%'.$recherche.'%"');
        $sth2->execute();
        $tab2=$sth2->fetchAll(PDO::FETCH_ASSOC);
        $afficher='oui';
    }
?>
    <form method="POST">
        <div class="recherche-container">
            <label for="lieux">Où souhaitez-vous aller?</label>
            <input type="search" name="recherche" placeholder="Destination">
            <input type="submit" name="envoyer" value="Rechercher">
        </div>
    </form>

    <?php if (@$afficher=='oui'){?>
        <div id="resultat"></div>
        <div id="nbr"><?=count($tab)."".(count($tab)>1?" résultats trouvés":" résultat trouvé") ?></div>
            
        <h2>Liste des hébergements disponibles</h2>
<div class="liste-gite-container">

<?php for($i=0;$i<count($tab);$i++){ ?>

    <div class="liste-gite-content">
            <?= '<img src= "../images/'. $tab[$i]["Photo"]. '" alt="photo hébergement">'; ?>
            <p><?php echo  $tab2[$i]["Nom"] .'<br>' . '<br>' ?></p>
            <p><?= '<a href="./testfiche.php?Id='. $tab[$i]['Id'] . '">' .  $tab[$i]['Intitule'].  '</a><br>' . '<br>';?></p>
            <p>Lieux : <?php echo $tab2[$i]["Emplacement_geographique"] ?></p>
            <p>Nombre de couchage : <?php echo $tab[$i]["Nombre_de_couchages"] ?></p>
            <p>Prix : <?php echo $tab[$i]["Prix"] ?>€</p>
    </div>
<?php } ?>
</div>
        <?php } ?>
        </div>
    </main>
</body>
</html>
<?php
    include "_connexionBD.php";

    $reqRenforts=$bd->prepare("SELECT * FROM renforts ORDER BY cavaliers DESC");
    $reqRenforts->execute();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rohan</title>
</head>
<body>
    <header>
        <h1>Le Rassemblement des Rohirrims À Dunharrow</h1>
        <p>Le roi Théoden du Rohan mobilise ses troupes à Dunharrow pour partir à la guerre, défendre le Gondor.
            Rapidement, les renforts venus des 4 coins du pays se joignent à la grande armée du roi, qui a bien du 
            mal à compter le nombre de ses cavaliers. <br>
            Heureusement, il peut compter sur vous pour coder une interface en PHP reliée à une base de données 
            MySQL pour mettre à jour le nombre de cavaliers se joignant à l'armée. </p>
    </header>
    <div id="renforts">
        <img src="rohirrims.jpg" alt="group of soldiers near a custletown in war">
        <div id="renforts_liste">

            <?php
                while($renforts=$reqRenforts->fetch()){
                    $id_renfort=$renforts['id_renfort'];
                    $clan_name=$renforts['clan'];
                    $cavaliers=$renforts['cavaliers'];
                    $border_color=$renforts['couleur_banniere'];
                    $id_commandant=$renforts['id_commandant'];
                    $estimation=$renforts['estimation'];

                    if ($cavaliers>=1000){
                        $font_size='28px';
                    }elseif ($cavaliers>=100 and $cavaliers<=999){
                        $font_size='24px';
                    }elseif ($cavaliers>=10 and $cavaliers<=99){
                        $font_size='20px';
                    }elseif ($cavaliers>=0 and $cavaliers<=9){
                        $font_size='16px';
                    }else {$font_size='14px';}

                    echo "<a href='upload.php?page=$id_renfort' class='renforts_links' style='font-size: $font_size; border-left: $border_color solid 10px;'>$clan_name : $cavaliers";
                    
                    echo "<span id='img_container'>";

                    if ($estimation > 0) {
                        $pourcentage = ($cavaliers * 100) / $estimation;

                        if ($pourcentage < 25) {
                            echo "<img src='exclamation.png' alt='attention' class='exclamations'>
                                <img src='exclamation.png' alt='attention' class='exclamations'>
                                <img src='exclamation.png' alt='attention' class='exclamations'>";
                        } elseif ($pourcentage >= 25 and $pourcentage < 50) {
                            echo "<img src='exclamation.png' alt='attention' class='exclamations'>
                                <img src='exclamation.png' alt='attention' class='exclamations'>";
                        } elseif ($pourcentage >= 50 and $pourcentage < 75) {
                            echo "<img src='exclamation.png' alt='attention' class='exclamations'>";
                        } else {echo "";}
                    } elseif ($estimation=0) {
                        echo "<img src='exclamation.png' alt='attention' class='exclamations'>
                                <img src='exclamation.png' alt='attention' class='exclamations'>
                                <img src='exclamation.png' alt='attention' class='exclamations'>";
                    }else {echo "";}

                    echo "</span>";
                    
                    echo "</a><br>";
                }
            
            ?>    

        </div>
    </div>
    <footer id="comandants">
        <p>lala</p>
        
    </footer>
    
</body>
</html>
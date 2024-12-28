<?php 
    include "_connexionBD.php";
    $reqClan=$bd->prepare("SELECT r.id_renfort, r.clan, r.id_commandant, c.commandant, r.cavaliers, r.estimation FROM renforts AS r JOIN commandants AS c ON r.id_commandant=c.id_commandant WHERE r.id_renfort=:id_renfort");
    $reqClan->bindvalue("id_renfort", (int)$_GET['page']);
    $reqClan->execute();
    
    $reqCommandants=$bd->prepare("SELECT id_commandant, commandant FROM commandants");
    $reqCommandants->execute();

    if(isset($_GET['page'])){
        $page=(int)$_GET['page'];
    }else {header('Location:index.php');}

    if($page== null){
        header('Location:index.php');}

    if (isset($_POST['cavaliers_number']) and (isset($_POST['commandant_select']))){
        $updateRenforts=$bd->prepare("UPDATE renforts SET cavaliers = :new_cavaliers, id_commandant = :new_commandant WHERE id_renfort = :id_renfort");
        $updateRenforts->bindvalue("new_cavaliers", $_POST['cavaliers_number']);
        $updateRenforts->bindvalue("new_commandant", $_POST['commandant_select']);
        $updateRenforts->bindvalue("id_renfort", $page);
        $updateRenforts->execute();
        header('Location:index.php');
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modification</title>
</head>
<body>
    <header>
        <h1>Modification</h1>
    </header>
    <div id="modification_cavalier_container">
        <form action='upload.php?page=<?php echo $page; ?> ' method='POST'>
            <?php 
                while ($clan=$reqClan->fetch()){
                    $id_renfort=(int)$_GET['page'];
                    $clan_name=$clan['clan'];
                    $cavaliers=$clan['cavaliers'];
                    $estimation=$clan['estimation'];
                    
                    echo "<h2>$clan_name</h2>";
                    echo "<label for='cavaliers_number'>Cavaliers : </label>";
                    echo "<input type='number' name='cavaliers_number' min ='0' id='cavaliers_number' value='$cavaliers' required><p>ESTIMATION : ($estimation)</p>";
                    
                    echo "<label for='commandant_select'>Commandant : </label>";
                    echo "<select name='commandant_select' id='commandant_select' >";

                    while ($commandants=$reqCommandants->fetch()){
                        $commandant_name=$commandants['commandant'];
                        $commandant_id=$commandants['id_commandant'];
                        echo "<option value='$commandant_id'";
                        if($commandant_id==$clan['id_commandant']) {echo "selected";}
                        echo ">$commandant_name</option>";
                    }
                    echo "</select>";

                }?>
            <input type="submit" value="Modifier">
        </form>
    </div>
</body>
</html>
<?php

//Inclusion des themes
include 'theme.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php (isset($title))?$title:'Titre de la page';?></title>
    <link id="theme-style" rel="stylesheet" href="<?=$theme?>.css">
</head>
<body>

<!-- Inclusion des pages -->
    <?php
    // Affichage de la page actualite par defaut
    if (!isset($write)) {
        include './actualite.php';
    }
    ?>
    <!-- Inclusion de la barre de titre -->
    <?php include './title_bar.php'?>

    <!-- Inclusion de la barre de navigation -->
    <?php include './navigation.php'?>
    

    <!-- Le corp de Weconnect -->
    <div class="body">
        <?=@$write?>
    </div>
</script>
</body>
</html>
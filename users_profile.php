<?php
$title='profile';
ob_start();

//Profile des autres utilisateurs
?>

<!-- Affichage de donnees de profile d'utilisateurs -->

<svg class='more' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
</svg>

    <div class="profileId">
        <a href="./router.php?weconnect=profile_picture&image=<?=$_GET['photo']?>">
            <div class="picture_profile"">
                <img class="profile_photo" src="<?=$_GET['photo']?>" alt="">
            </div>
        </a>


        <div class="name"><di class="online"></di><h3><?=$_GET['name']?> - <?=$_GET['prenom']?></h3></div>

        <div class="">
        <h3>bio:</h3><p class="bio">
            <?=$_GET['bio']?>
        </p>
        </div>
    </div>

    <div class="personal_info">
        <h4>Autres Informations 
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        </h4>
        <br>
        <br>

        <div class="content_infos">
            <div class=""><h3>Email : <?=$_GET['email']?></h3></div>


            <div class=""><h3>Numero : <?=$_GET['numero']?></h3></div>

            <div class=""><h3>Date de naissance : <?=$_GET['dates']?></h3></div>

            <div class=""><h3>sexe : <?=$_GET['genre']?></h3></div>

            <div class=""><h3>Pays : <?=$_GET['pays']?></h3></div>
        </div>
    </div>
<?php
$write=ob_get_clean();
include 'Weconnect.php';
?>
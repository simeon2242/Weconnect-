<?php

include './db.php';

//recuperation des informations necessaires pour l'utilisateur
$conn=$db->query('SELECT * FROM user WHERE id=1');
$user=$conn->fetch(PDO::FETCH_ASSOC);

$name=$user['nom'];
$pic=$user['photo'];
$prenom=$user['prenom'];
$sender_id=$user['id'];



//Script pour recuperer les amis de l'utilisateur
$select_friend=$db->prepare("SELECT u.nom AS friend_name,
u.id AS friend_id,
u.prenom AS friend_prenom,
u.email AS friend_email,
u.photo AS friend_photo,
u.numero AS friend_numero,
u.dates AS friend_dates,
u.genre AS friend_genre,
u.pays AS friend_pays,
u.bio AS friend_bio
FROM friend f JOIN user u ON u.id = f.friend_id WHERE f.user_id = :user_id AND f.status = 'friends'");

$select_friend->execute(['user_id'=>1]);

$friends=$select_friend->fetchAll(PDO::FETCH_ASSOC);

$title='amis';
ob_start();
?>



<div class="amis">
<h1>Message <svg style="color: var(--text-col);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
            </svg>
</h1>
    <div class="publier">
    <a href="./router.php?weconnect=profile" class="profile">
        <img src="<?=$pic?>" alt="">
        <h3><?=$name?> <?=' '.$user['prenom']?></h2>
    </a>

    <form class="form_search" action="" method="GET">
        <input type="search" name="query" class="search" placeholder="Rechercher les mess..." <?php if(isset($query)):?>value="<?=$query?><?php endif?>">
        <button class="research" type="submit">
            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </form>
</div>
    <br>
    <br>

    <h4>Messages Recent
            <svg style="color: var(--text-col)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
            </svg>
    </h4>

    <!-- Affichage des amis de l'utilisateur pour la conversation -->
<?php foreach($friends as $friend):?>
    <div class="friend_users">
        <div class="friend_user">
            <a style="display: flex; gap: 1rem;" href="./router.php?weconnect=profile_users&name=<?=$friend['friend_name']?>
            &prenom=<?=$friend['friend_prenom']?>&email=<?=$friend['friend_email']?>&numero=<?=$friend['friend_numero']?>
            &dates=<?=$friend['friend_dates']?>&genre=<?=$friend['friend_genre']?>&pays=<?=$friend['friend_pays']?>&bio=<?=$friend['friend_bio']?>
            &photo=<?=$friend['friend_photo']?>">
                <img class="friend_img" src="<?=$friend['friend_photo']?>" alt="">
                <h3 class="friend_name"><?=$friend['friend_name']?> <?=$friend['friend_prenom']?></h3>
            </a>

            <div class="action">
            <a href="./router.php?weconnect=messenger_friend&receiver_id=<?=$friend['friend_id']?>&receiver_name=<?=$friend['friend_name']?>&receiver_prenom=<?=$friend['friend_prenom']?>&receiver_photo=<?=$friend['friend_photo']?>">
                <svg style="height: 35px; width: 35px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>
            </a>

            </div>
        </div>
    </div>

<?php endforeach?>

    
</div>
<br>
<br>


<?php
$write=ob_get_clean();
include('./Weconnect.php');
?>
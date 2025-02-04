<?php
include './db.php';

//Selection de données de l'utilisateur
$conn=$db->query('SELECT * FROM user WHERE id = 1');
$user=$conn->fetch(PDO::FETCH_ASSOC);

$name=$user['nom'];
$pic=$user['photo'];
$prenom=$user['prenom'];


//Script pour recuperer les amis de l'utilisateur
$select_friend=$db->prepare("SELECT u.nom AS friend_name,
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

//script pour recupere les utilisateurs qui ne sont pas les amis de l'utilisateur
$select_no_friend=$db->prepare("SELECT u.nom AS not_friend_name,
u.prenom AS not_friend_prenom,
u.email AS not_friend_email,
u.photo AS not_friend_photo,
u.numero AS not_friend_numero,
u.dates AS not_friend_dates,
u.genre AS not_friend_genre,
u.pays AS not_friend_pays,
u.bio AS not_friend_bio
FROM friend f JOIN user u ON u.id=f.friend_id WHERE f.user_id=:user_id AND f.status='not_friends'");

$select_no_friend->execute(['user_id'=>1]);

$not_friends=$select_no_friend->fetchAll(PDO::FETCH_ASSOC);


$title='amis';
ob_start();
?>
<!-- Affichage des informations -->
<div class="amis">
    <h1>Amis
    <svg style="color: var(--text-col);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
    </svg>
    </h1>
    <div class="publier">
    <a href="./router.php?weconnect=profile" class="profile">
        <img src="<?=$pic?>" alt="">
        <h3><?=$name?> <?=' '.$user['prenom']?></h2>
    </a>

    <form class="form_search" action="" method="GET">
        <input type="search" name="query" class="search" placeholder="Rechercher les Amis..." <?php if(isset($query)):?>value="<?=$query?><?php endif?>">
        <button class="research" type="submit">
            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </form>
</div>
<div class="groupe_community">
    <a href="" class="option">
        <h4>Amis<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
        </h4>
    </a>
    <a href="" class="option">
        <h4>communautés
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
            </svg>
        </h4>
    </a>
    <a href="" class="option">
        <h4>Groupe
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
        </svg>
        </h4>
    </a>
    <a href="" class="option">
        <h4>Pages
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
        </svg>
        </h4>
    </a>
</div>
    <br>
    <br>

    <h4>Vos amis
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
    </svg>
    </h4>

<!-- Afficher des amis de l'utilisateur -->
<?php foreach($friends as $friend):?>
    <div class="friend_users">
        <div class="friend_user">
            <a style="display: flex; gap:1rem;" href="./router.php?weconnect=profile_users&name=<?=$friend['friend_name']?>
            &prenom=<?=$friend['friend_prenom']?>&email=<?=$friend['friend_email']?>&numero=<?=$friend['friend_numero']?>
            &dates=<?=$friend['friend_dates']?>&genre=<?=$friend['friend_genre']?>&pays=<?=$friend['friend_pays']?>&bio=<?=$friend['friend_bio']?>
            &photo=<?=$friend['friend_photo']?>">
                <img class="friend_img" src="<?=$friend['friend_photo']?>" alt="">
                <h3 class="friend_name"><?=$friend['friend_name']?> <?=$friend['friend_prenom']?></h3>
            </a>

            <div class="action">
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>
            </a>

            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </a>
            </div>
        </div>
    </div>

<?php endforeach?>

    
</div>
<br>
<br>


<div class="amis">
    <h4>Pouvez-vous peut etre connaitre
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
    </svg>

    </h4>

    
<!-- Affichage de personnes qui ne sont pas les amis de l'utilisateur-->
    <?php foreach($not_friends as $not_friend):?>
    <div class="friend_users">
        <div class="friend_user">
        <a style="display: flex; gap:1rem;" href="./router.php?weconnect=profile_users&name=<?=$not_friend['not_friend_name']?>
            &prenom=<?=$not_friend['not_friend_prenom']?>&email=<?=$not_friend['not_friend_email']?>&numero=<?=$not_friend['not_friend_numero']?>
            &dates=<?=$not_friend['not_friend_dates']?>&genre=<?=$not_friend['not_friend_genre']?>&pays=<?=$not_friend['not_friend_pays']?>&bio=<?=$not_friend['not_friend_bio']?>
            &photo=<?=$not_friend['not_friend_photo']?>">
                <img class="friend_img" src="<?=$not_friend['not_friend_photo']?>" alt="">
                <h3 class="friend_name"><?=$not_friend['not_friend_name']?> <?=$not_friend['not_friend_prenom']?></h3>
            </a>

            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
            </div>
    </div>
    <?php endforeach?>
</div>
</div>
<?php
$write=ob_get_clean();
include('./Weconnect.php');
?>
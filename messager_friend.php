<?php

include './db.php';

//recuperation de l'utilisateur connecté et amis selectionné
session_start();
$currentUserId=$_SESSION['user_id'];
$receiver_id=$_GET['receiver_id'];


//recuperation des identifiants du destinataire
$receiver_photo=$_GET['receiver_photo'];
$receiver_name=$_GET['receiver_name'];
$receiver_prenom=$_GET['receiver_prenom'];

//Recuperation de messages
$selectMessage=$db->prepare("SELECT * FROM messages
            WHERE (sender_id = :current_userId AND receiver_id = :friend)
            OR (sender_id = :friend AND receiver_id = :current_userId)
            ORDER BY created_at ASC
");


$selectMessage->execute(['current_userId'=>$currentUserId,
                'friend'=>$receiver_id
]);


$messages=$selectMessage->fetchAll(PDO::FETCH_ASSOC);


//recuperation des utilisateurs connectés
$selectfriend=$db->prepare("SELECT id, nom FROM user WHERE id = :user_id");
$selectfriend->execute([':user_id'=>$receiver_id]);
$friend=$selectfriend->fetch(PDO::FETCH_ASSOC);


//Recuperation des donnes de formulaire
if (isset($_POST['submit'])) {
    $destinataire_id=$_POST['receiver_id'];
    $message=$_POST['message'];
    $currentUserId=$_SESSION['user_id'];


    if (empty($message)) {
        $error = "Vous n'avez rien envoyé";
    }else {
        //Inserer le message dans la base de données
    $insertMessage=$db->prepare("INSERT INTO messages(sender_id, receiver_id, message) VALUES (:sender_id,:receiver_id,:message)");
    $insertMessage->execute(['sender_id'=>$currentUserId,
                            'receiver_id'=>$destinataire_id,
                            'message'=>$message]);

    header('locaton:router.php?weconnect=messenger_friend&receiver_id=$reveiver_id');

    }

}


$title='message';
ob_start();
?>

<!-- Affichage de messages -->
<div class="publier">
    <a href="" class="profile">
        <img src="<?=$receiver_photo?>" alt="">
        <h3><?=$receiver_name?> <?=' '.$receiver_prenom?></h2>
    </a>

    <form class="form_search" action="" method="GET">
        <input type="search" name="query" class="search" placeholder="Rechercher les Mess..." <?php if(isset($query)):?>value="<?=$query?><?php endif?>">
        <button class="research" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </form>
</div>

<div class="msg_container">

<h2>Discussions
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
</svg>
</h2>

<!-- Boucle pour afficher les messages -->
    <?php foreach ($messages as $msg):?>
        <div class="message <?=$msg['sender_id'] == $currentUserId ? 'msg_A' : 'msg_B'?>">
            <h3><?= $msg['sender_id'] == $currentUserId ? "vous" : $friend['nom']?></h3>
            <p class="msg_para"><?=$msg['message']?></p>
            <small><?= $msg['created_at']?></small>
        </div>
    <?php endforeach?>
</div>

<?php if(isset($error)):?>
<small style="color: red;"><?=$error?></small>
<?php endif?>

<!-- Formulaire pour envoyer un message -->
<form class="msg_sending" method="POST" action="">
    <input type="hidden" name="receiver_id" value="<?= $receiver_id?>">
    <textarea class="msg_holder" name="message" placeholder="Entrer le message ici..." id=""></textarea>
    <button type="submit" name="submit">Envoyer</button>
</form>


<?php
$write=ob_get_clean();
include('./Weconnect.php');
?>
<?php

include './db.php';

//Recuperation de publications
$actualite=$db->prepare ("SELECT 
actualite.id AS id_actualite,
user.nom AS user_name,
user.prenom AS user_prenom,
user.photo AS user_photo,
actualite.pub_pic,
actualite.description,
actualite.created_at
FROM
actualite
INNER JOIN
user
ON
actualite.user_id=user.id
ORDER BY actualite.created_at DESC    
");
$actualite->execute();
$selects=$actualite->fetchAll(PDO::FETCH_ASSOC);


//recuperation de données d'utilisateur
$user_id=1;
$conn=$db->query('SELECT * FROM user WHERE id=1');
$user=$conn->fetch(PDO::FETCH_ASSOC);

$name=$user['nom'];
$pic=$user['photo'];
$prenom=$user['prenom'];
$userId=$user['id'];


//Recuperation de données pour le recherche
if (isset($_GET['query'])) {
    $query=htmlspecialchars($_GET['query']);

    if (!empty($query)) {
        $request=$db->prepare("SELECT 
actualite.id AS id_actualite,
user.nom AS user_name,
user.prenom AS user_prenom,
user.photo AS user_photo,
actualite.pub_pic,
actualite.description,
actualite.created_at
FROM
actualite
INNER JOIN
user
ON
actualite.user_id=user.id
WHERE description 
LIKE :query
ORDER BY actualite.created_at DESC"
);

        $request->execute(['query'=>'%'.$query.'%']);

        $results=$request->fetchAll(PDO::FETCH_ASSOC);

    }else{
        $error="Pas de contenus dans la zone de recherche";
    }
}


//Envoi de publication
if (isset($_POST['text'])) {
    if (empty($_POST['text'])) {
        $error='Cher utilisateur, avez laissé le champ de publication vide';
    }else{
    $description=$_POST['text'];
    $_SESSION['user_id']=$userId;
    if (isset($_FILES['file'])) {

        //Recuperer le chemin temporaire ou PHP stocke le fichier
        $tempPath=$_FILES['file']['tmp_name'];

        //Recuperer le nom original du fichier
        $originalName=$_FILES['file']['name'];

        //Deplacer les fichier pour voir chemin final
        $uploadDir='uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);//Creer le dossier necessaire
        }

        $destinationPath = $uploadDir.$originalName;

        move_uploaded_file($tempPath, $destinationPath);
    
    //Insersion de données dans la table actualité
        $insert=$db->prepare("INSERT INTO actualite(user_id,pub_pic,description) VALUES(?,?,?)");
        $insert->execute(array(
        $user_id,
        $destinationPath,
        $description));

        header('location:weconnect.php');
    }
}
}

?>

<?php

$title='actualite';
ob_start();
?>
<h1 class="page_title">
    Actualités
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
    </svg>
    
    <form class="form_search" action="" method="GET">
        <input type="search" name="query" class="search" placeholder="Rechercher les info..." <?php if(isset($query)):?>value="<?=$query?><?php endif?>">
        <button class="research" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </form>
</h1>

<div class="publier">
    <a href="./router.php?weconnect=profile" class="profile">
        <img src="<?=$pic?>" alt="">
        <h3><?=$name?> <?=' '.$user['prenom']?></h2>
    </a>

    <form class="pub" method="post" enctype="multipart/form-data">
        <input type="file" class="fichier" name="file" accept="image/*" require>
        
        <textarea class="text" name="text" id="" placeholder="Saisir la publication..." cols="40" rows="2"></textarea>
        <button type="submit">Publier</button>
    </form>
</div>

<!-- Affichage de l'erreur si celui çi existe -->
<?php if(isset($error)):?>
    <small style="color: red;"><?=$error?></small>
<?php endif?>
<h2>Publications
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
    </svg>              
</h2>
<h4>Plus Recent</h4>

<!-- Resultat de la zone de recherche -->
<?php if(!empty($results)):?>
    <?php foreach($results as $row):?>
    Date/heur: <?=$row['created_at']?>
    <div class="actualite">
    <div class="publicator">
        <img class="publicator_photo" src="<?= $row['user_photo']?>" alt="">
        <span><?= $row['user_name']?> <?=' '.$row['user_prenom']?></span>
    </div>
    <div class="pub">
        <div class="content_left">
            <img class="publication_photo" src="<?= $row['pub_pic']?>" alt="">
        </div>
        <div class="content_right">
            <p class="publication">
                <?= $row['description']?>
            </p>
            
            <div class="reaction">
                <div class="react">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>                                  
                    </div>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                        </svg>                                  
                    </div>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>                                  
                    </div>
                </div>
                
                <div class="comment">
                    <textarea name="" id="" placeholder="Commenter..."></textarea>
                    <div>
                        <button type="submit">Commenter</button>
                    </div>
                </div>
                <button class="see_comment">Voir</button>
            </div>   
        </div>    
    </div>
</div>

<?php endforeach?>

<?php endif?>



<!-- affichage de publicaions -->
<?php foreach($selects as $select):?>
    Date/heur: <?=$select['created_at']?>
    <div class="actualite">
    <div class="publicator">
        <img class="publicator_photo" src="<?= $select['user_photo']?>" alt="">
        <span><?= $select['user_name']?> <?=' '.$select['user_prenom']?></span>
    </div>
    <div class="pub">
        <div class="content_left">
            <img class="publication_photo" src="<?= $select['pub_pic']?>" alt="">
        </div>
        <div class="content_right">
            <p class="publication">
                <?= $select['description']?>
            </p>
            
            <div class="reaction">
                <div class="react">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>                                  
                    </div>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                        </svg>                                  
                    </div>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>                                  
                    </div>
                </div>
                
                <div class="comment">
                    <textarea name="" id="" placeholder="Commenter..."></textarea>
                    <div>
                        <button type="submit">Commenter</button>
                    </div>
                </div>
                <button class="see_comment">Voir</button>
            </div>   
        </div>    
    </div>
</div>

<?php endforeach?>

<?php
$write=ob_get_clean();
include './Weconnect.php';
?>
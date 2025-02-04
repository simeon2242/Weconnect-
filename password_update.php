<?php
include "./db.php";

//Recuperation des informations necessaire de l'utilisateur
$conn=$db->query('SELECT * FROM user');
$user=$conn->fetch(PDO::FETCH_ASSOC);


$name=$user['nom'];
$pic=$user['photo'];
$prenom=$user['prenom'];


//Recuperation de l'ID
if (isset($_GET['id'])) {
    $id=$_GET['id'];

$conn=$db->query("SELECT * FROM user WHERE id=$id");

$select=$conn->fetch();

$old=$select['password'];


//Validation des donnees
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $new_pass=htmlspecialchars($_POST['new']);
    $old_pass=htmlspecialchars($_POST['old']);

    if (!empty($new_pass)&&!empty($old_pass)) {
        
        if ($old_pass===$old) {
            $update=$db->prepare("UPDATE user SET password=? WHERE id=?");

            $update->execute([$new_pass,$id]);

            header('location:router.php?weconnect=profile');
        }else {
            $error="Mot de passe incorrecte";
        }
    }else {
        $error="Champs vide";
    }

}
}


$title="password update";
ob_start();
?>


<div class="publier">
    <a href="./router.php?weconnect=profile" class="profile">
        <img src="<?=$pic?>" alt="">
        <h3><?=$name?> <?=' '.$user['prenom']?></h2>
    </a>
</div>

<form action="" class="formUpdate" method="post">
    
    <div style="border: none;" class="update_profileA">
    <h1 style="width:100%; display: flex; justify-content:center;">Souhaitez vous modifier votre mot de passe?</h1>
    <div>
        <label for="">Entrer l'ancien mot de passe:</label>
        <input type="password" name="old" placeholder="Entrer l'ancien mot de passe...">
    </div>

    <div>
        <label for="">Entrer le nouveau mot de passe:</label>
        <input type="password" name="new" placeholder="Entrer le nouveau mot de passe...">
    </div>

    </div>
    <div style="width: 100%; display:flex;justify-content:center;margin-top:50px;">

    <!-- Affichage des erreurs -->
        <?php if(isset($error)):?>
        <small style="color: red;"><?=$error?></small>
        <?php endif?>
    </div>

    <button class="submit" type="submit">Enregistrer</button>
</form>

<?php
$write=ob_get_clean();
include './weconnect.php';
?>
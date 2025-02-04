<?php
include './db.php';


//Recuperation des information necessaire de l'utilisateur
$conn=$db->query('SELECT * FROM user');
$user=$conn->fetch(PDO::FETCH_ASSOC);

$name=$user['nom'];
$pic=$user['photo'];
$prenom=$user['prenom'];


if (isset($_GET['id'])) {
    $id=$_GET['id'];

//Recuperation de l'ID du destinaire
    $get=$db->query("SELECT * FROM user WHERE id=$id");
    $select=$get->fetch();
    

    if (isset($_POST['submit'])) {
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $bio=$_POST['bio'];
        $email=$_POST['email'];
        $numero=$_POST['numero'];
        $dates=$_POST['dates'];
        $genre=$_POST['genre'];
        $pays=$_POST['pays'];
    
    //Validaion du formulaire
        if (!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['bio'])&&
        !empty($_POST['email'])&&!empty($_POST['numero'])&&!empty($_POST['dates'])&&
        !empty($_POST['genre'])&&!empty($_POST['pays'])) {

    //Modification de donnees de l'utilisateur  
            $update=$db->prepare("UPDATE user SET nom=?,prenom=?,bio=?,email=?,numero=?,dates=?,
                                genre=?,pays=? WHERE id=?");

  
            $modify=$update->execute([$nom,$prenom,$bio,$email,$numero,$dates,$genre,$pays,$id]);
    
            header('location:router.php?weconnect=profile');
        }else{
            $error="Cher utilisateur, Certains champs sont vide";
        }
    }
}



$title='Update';
ob_start();
?>
<!-- Affichage de tous les donnees de l'utlisateur -->

<div class="publier">
    <a href="./router.php?weconnect=profile" class="profile">
        <img src="<?=$pic?>" alt="">
        
        <h3><?=$name?> <?=' '.$user['prenom']?></h2>
    </a>
</div>
<form action="" class="formUpdate"  method="post">
    <h1 class="form_title">Souhaitez-vous Modifier certains elements?</h1>
    
    <div class="update_profile">
    <div class="update_profileA">
    <div>
        <label for="">Nom</label>
        <input type="text" name="nom" value="<?=$select['nom']?>">
    </div>

    <div>
        <label for="">Prenom</label>
        <input type="text" name="prenom" value="<?=$select['prenom']?>">
    </div>

    
    <div>
        <label for="">Bio  </label>
        <textarea name="bio" id="" value="">
        <?=$select['bio']?>
        </textarea>
    </div>

    <div>
        <label for="">Email</label>
        <input type="text" name="email" value="<?=$select['email']?>">
    </div>
    </div>

    
    <div class="update_profileB">
    <div>
        <label for="">Numero</label>
        <input type="number" name="numero" value="<?=$select['numero']?>">
    </div>

    <div>
        <label for="">Date</label>
        <input type="date" name="dates" value="<?=$select['dates']?>">
    </div>

    <div>
        <label for="">Genre</label>
        <input type="text" name="genre" value="<?=$select['genre']?>">
    </div>

    <div>
        <label for="">Pays</label>
        <input type="text" name="pays" value="<?=$select['pays']?>">
    </div>
    
    </div>
    </div>

    <div style="width: 100%; display:flex;justify-content:center;margin-top:50px;">
        <?php if(isset($error)):?>
            <small style="color:red"><?=$error?></small>
        <?php endif?>
    </div>

    <button class="submit" type="submit" name="submit">Enregistrer</button>


</form>



<?php
$write=ob_get_clean();
include './Weconnect.php';
?>
<?php

if (isset($_GET['weconnect'])) {
    $page = $_GET['weconnect'];
}else{
    $page = 'home';
}   

if ($page=='home') {
    include('./actualite.php');
}elseif($page=='profile'){
    include('./profile.php');
}elseif ($page=='profile_users') {
    include('./users_profile.php');
}elseif ($page == 'profile_picture'){
    include ('./profile_picture.php');
} elseif ($page=='update') {
    include('./user_update.php');
}elseif ($page=='password') {
    include('./password_update.php');
}elseif ($page=='amis') {
    include('./amis.php');
}elseif ($page=='messagerie'){
    include('./messagerie.php');
}elseif ($page=='messenger_friend'){
    include('./messager_friend.php');
}elseif ($page=='notification') {
    include('./notification.php');
}elseif ($page=='setting') {
    include('./setting.php');
}



else{
    include './error.php';
}

?>
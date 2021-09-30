<?php
session_start();
$SessionClient=$_SESSION['NeuroClient'];

$VerifSessionClient=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
$VerifSessionClient->bindParam(':email', $SessionClient, PDO::PARAM_STR);
$VerifSessionClient->execute();

$NumRowSessionClient=$VerifSessionClient->rowCount();

if ((isset($SessionClient))&&($NumRowSessionClient==1)) {
    $Cnx_Ok=true;
}
else {
    $Cnx_Ok=false;

    $PageActu=$_SERVER['REQUEST_URI'];
    $Page=array("0" => "/Admin/Album/", "1" => "/Admin/Article/");

    if (in_array($PageActu, $Page)) {
        header('location:'.$Home.'/Admin');
    }
}
?>
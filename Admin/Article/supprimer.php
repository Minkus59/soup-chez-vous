<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Admin/lib/script/redirect.inc.php");

$Erreur=$_GET['erreur'];
$Id=$_GET['id'];

if ((!empty($_GET['id']))&&(isset($_POST['oui']))) {

    $Select=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_Actu WHERE id=:id");
    $Select->bindParam(':id', $Id, PDO::PARAM_INT);
    $Select->execute();
    $Lien=$Select->fetch(PDO::FETCH_OBJ);

    $deleteActu=$cnx->prepare("DELETE FROM ".$Prefix."neuro_Actu WHERE id=:id");
    $deleteActu->bindParam(':id', $Id, PDO::PARAM_INT);
    $deleteActu->execute();

    header('Location:'.$Lien->page);
}

if ((!empty($_GET['id']))&&(isset($_POST['non']))) {  
    header('Location:'.$Lien->page);
}
?>  


<!-- ************************************
*** Script réalisé par NeuroSoft Team ***
********* www.neuro-soft.fr *************
**************************************-->

<!DOCTYPE html>
<html>
<head>
<title>NeuroSoft Team - Accès PRO</title>

<META http-equiv="Content-Type" content="text/html;charset=ISO-8859-15"> 
<META name="robots" content="noindex, nofollow">

<META name="author".content="NeuroSoft Team">
<META name="publisher".content="Helinckx Michael">
<META name="reply-to" content="contact@neuro-soft.fr">

<META name="viewport" content="width=device-width" >                                                            
<link rel="alternate" hreflang="fr-be" href="<?php echo $Home; ?>/">

<link rel="shortcut icon" href="<?php echo $Home; ?>/Admin/lib/img/icone.ico">

<link rel="stylesheet" type="text/css" media="screen AND (max-width: 480px)" href="<?php echo $Home; ?>/lib/css/misenpatel.css" />
<link rel="stylesheet" type="text/css" media="screen AND (min-width: 480px) AND (max-width: 960px)" href="<?php echo $Home; ?>/lib/css/misenpatab.css" />
<link rel="stylesheet" type="text/css" media="screen AND (min-width: 960px)" href="<?php echo $Home; ?>/lib/css/misenpapc.css" >
</head>

<body>
<CENTER>

<header>
<div id="Center">
<a href="<?php echo $Home; ?>/"><img src="<?php echo $Home; ?>/Admin/lib/img/En-tete.png"></a>
</div>
</header>

<div id="MenuAdmin">
<?php require_once($_SERVER['DOCUMENT_ROOT']."/Admin/lib/script/menu.inc.php"); ?>
</div>

<div id="Center">
<section>
<article>
<?php if (isset($Erreur)) { echo "<font color='#FF0000'>".$Erreur."</font><BR />"; }
if (isset($Valid)) { echo "<font color='#009900'>".$Valid."</font><BR />"; } ?>

Etes-vous sur de vouloir supprimer cette article ? </p>

<TABLE width="300">
<form action="" method="POST">
<TR><TD align="center"><input name="oui" type="submit" value="OUI"></TD><TD align="center"><input name="non" type="submit" value="NON"/></TD></TR>
</form></TABLE>

</article>
</section>
</div>
</CENTER>
</body>

</html>
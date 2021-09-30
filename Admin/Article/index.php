<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Admin/lib/script/redirect.inc.php");

$Erreur=$_GET['erreur'];
$Valid=$_GET['valid'];
$Id=$_GET['id'];
$Now=time();

$SelectPhoto=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_Album");
$SelectPhoto->execute();

if (isset($_GET['id'])) { 
    $Select=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_Actu WHERE id=:id");
    $Select->BindParam(":id", $Id, PDO::PARAM_STR);
    $Select->execute();
    $Actu=$Select->fetch(PDO::FETCH_OBJ);
}

if ((isset($_POST['Modifier']))&&(isset($_GET['id']))) {
    $Titre=FiltreText('titre');
    $Message=$_POST['message'];
    $Page=$_POST['page'];

    if ($Titre[0]===false) {
        $Erreur=$Titre[1];  
    }
    else {
        $Insert=$cnx->prepare("UPDATE ".$Prefix."neuro_Actu SET titre=:titre, message=:message, page=:page, created=:created WHERE id=:id");
        $Insert->BindParam(":id", $Id, PDO::PARAM_STR);
        $Insert->BindParam(":titre", $Titre, PDO::PARAM_STR);
        $Insert->BindParam(":message", $Message, PDO::PARAM_STR);
        $Insert->BindParam(":page", $Page, PDO::PARAM_STR);   
        $Insert->BindParam(":created", $Now, PDO::PARAM_STR);
        $Insert->execute();

        if (!$Insert) {
            $Erreur="Erreur serveur, veuillez réessayer ultérieurement !";
        }
        else  {     
            $Valid="Article modifier avec succès";
        }
    }
} 

if ((isset($_POST['Ajouter']))&&(!isset($_GET['id']))) {
    $Titre=FiltreText('titre');
    $Message=$_POST['message'];
    $Page=$_POST['page'];
    

    if ($Titre[0]===false) {
        $Erreur=$Titre[1];  
    }
    else {
        $Insert=$cnx->prepare("INSERT INTO ".$Prefix."neuro_Actu (titre, message, page, created) VALUES(:titre, :message, :page, :created)");
        $Insert->BindParam(":titre", $Titre, PDO::PARAM_STR);
        $Insert->BindParam(":message", $Message, PDO::PARAM_STR);
        $Insert->BindParam(":page", $Page, PDO::PARAM_STR);        
        $Insert->BindParam(":created", $Now, PDO::PARAM_STR);
        $Insert->execute();

        if (!$Insert) {
            $Erreur="Erreur serveur, veuillez réessayer ultérieurement !";
        }
        else  {     
            $Valid="Article ajouter avec succès";
        }
    }
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

<script type="text/javascript" src="<?php echo $Home; ?>/Admin/lib/js/nicEdit.js"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
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

<H1>Ajouter un nouvel article</H1></p>

<form name="form_actu" action="" method="POST" enctype="multipart/form-data">
<select name="page" required>
<option value="">--  --</option>
<option value="<?php echo $Home."/"; ?>"" <?php if ((isset($_GET['id']))&&($Actu->page == $Home."/")) { echo "selected"; } ?>>Accueil</option>
<option value="<?php echo $Home."/Recette/"; ?>"" <?php if ((isset($_GET['id']))&&($Actu->page == $Home."/Recette/")) { echo "selected"; } ?>>La carte</option>
<option value="<?php echo $Home."/Concept/"; ?>"" <?php if ((isset($_GET['id']))&&($Actu->page == $Home."/Concept/")) { echo "selected"; } ?>>Le concept</option>
<option value="<?php echo $Home."/Ou-manger/"; ?>"" <?php if ((isset($_GET['id']))&&($Actu->page == $Home."/Ou-manger/")) { echo "selected"; } ?>>La tournée</option>
<option value="<?php echo $Home."/Privatisation/"; ?>"" <?php if ((isset($_GET['id']))&&($Actu->page == $Home."/Privatisation/")) { echo "selected"; } ?>>Privatisation</option>
</select></p>

<input class="titre" type="text" name="titre" placeholder="Titre*" value="<?php if (isset($_GET['id'])) { echo $Actu->titre; } ?>" require="required"></p>

<textarea name="message" placeholder="Message*" require="required"><?php if (isset($_GET['id'])) { echo stripslashes($Actu->message); } ?></textarea></p>

<?php if (isset($_GET['id'])) { ?><input type="submit" name="Modifier" value="Modifier"/> <?php } else { ?><input type="submit" name="Ajouter" value="Ajouter"/><?php } ?>
</form>
<p><font color='#FF0000'>*</font> Champ de saisie requis</p>

<p><HR /></p>

<H1>Album Photo</H1></p>

<?php
while ($Photo=$SelectPhoto->fetch(PDO::FETCH_OBJ)) {
      echo "<p><img max-height='100px' src='$Photo->lien'/><BR />";
      echo $Photo->lien."</p>";
}
?>

</article>
</section>
</div>
</CENTER>
</body>

</html>
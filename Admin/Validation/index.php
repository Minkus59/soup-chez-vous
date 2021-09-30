<?php 
require($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");

$Client=trim($_GET['id']);
$Valided=trim($_GET['Valid']);

if ((isset($Client))&&(!empty($Client))&&(isset($Valided))&&(!empty($Valided))) {

    $VerifClient=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
    $VerifClient->bindParam(':email', $Client, PDO::PARAM_STR);
    $VerifClient->execute();
    $NbRowsClient=$VerifClient->rowCount();

    $VerifValid=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE activate=:valid AND email=:email");
    $VerifValid->bindParam(':valid', $Valided, PDO::PARAM_STR);
    $VerifValid->bindParam(':email', $Client, PDO::PARAM_STR);
    $VerifValid->execute();
    $NbRowsValid=$VerifValid->rowCount();
        
    if ($Valided!=1) {
        $Erreur="Le lien de v�rification a �t� modifi�, v�rifier qu'il correspond a celui re�u dans l'e-mail de confirmation 2!";   
    }

    elseif ($NbRowsClient!=1) {
        $Erreur="Le lien de v�rification a �t� modifi�, v�rifier qu'il correspond a celui re�u dans l'e-mail de confirmation 3!";
    }

    elseif ($NbRowsValid==1) {
        $Erreur="Votre compte est d�j� actif vous pouvez d�s � pr�sent vous connecter !<br />";
    }

    else {   
        $InsertValided=$cnx->prepare("UPDATE ".$Prefix."neuro_compte_Admin SET activate=1 WHERE email=:email");
        $InsertValided->bindParam(':email', $Client, PDO::PARAM_STR);
        $InsertValided->execute();

        if ((!$VerifValid)||(!$VerifClient)||(!$InsertValided)) {
            $SupprValided=$cnx->prepare("UPDATE ".$Prefix."neuro_compte_Admin SET activate=0 WHERE email=:email");
            $SupprValided->bindParam(':email', $Client, PDO::PARAM_STR);
            $SupprValided->execute();

            $Erreur="L'enregistrement des donn�es � �chou�e, veuillez r�essayer ult�rieurement !";
        }

        else {
            $Erreur= "Merci d'avoir valid� votre compte.<br />";
            $Erreur.= "Vous pouvez d�s � pr�sent vous connecter�!<br />";
        }   
    }
}
else {
    $Erreur="Erreur !";
}
?>

<!-- *******************************
*** Script r�alis� par NeuroSoft Team ***
********* www.neuro-soft.fr *********
*********************************-->

<!DOCTYPE html>
<html>
<head>
<title>NeuroSoft Team - Acc�s PRO</title>

<META http-equiv="Content-Type" content="text/html;charset=ISO-8859-15"> 
<META name="robots" content="noindex, nofollow">

<META name="author".content="NeuroSoft Team">
<META name="publisher".content="Helinckx Michael">
<META name="reply-to" content="contact@neuro-soft.fr">

<META name="viewport" content="width=device-width" >                                                            
<link rel="alternate" hreflang="fr-be" href="<?php echo $Home; ?>">

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
if (isset($Valid)) { echo "<font color='#009900'>".$Valid."</font><BR />"; }   ?>
</article>
</section>
</div>
</CENTER>
</body>

</html>
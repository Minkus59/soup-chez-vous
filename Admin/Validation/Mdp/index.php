<?php 
require($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");

$Erreur=$_GET['erreur'];
$Client=$_GET['id'];
$Hash=$_GET['hash'];

if (isset($_POST['Valider'])) {
        $Mdp=FiltreMDP('mdp');
        $Mdp2=FiltreMDP('mdp2');

        if ($Mdp[0]===false) {
           $Erreur=$Mdp[1];
        }
        elseif ($Mdp2[0]===false) {
           $Erreur=$Mdp2[1];
        }
        elseif ($Mdp2!=$Mdp) {
           $Erreur="Les mots de passe ne sont pas identique !";
        }
    else {
        $RecupHash=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_secu_mdp WHERE hash=:hash");
        $RecupHash->bindParam(':hash', $Hash, PDO::PARAM_STR);
        $RecupHash->execute();

        $NbRowsClient=$RecupHash->rowCount();
    
         if ($NbRowsClient!=1) {
                 $Erreur="Erreur de procédure, veuillez recommencé !<br />";
         }
         else {
              $RecupCreated=$cnx->prepare("SELECT (created) FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
              $RecupCreated->bindParam(':email', $Client, PDO::PARAM_STR);
              $RecupCreated->execute();

              $DateCrea=$RecupCreated->fetch(PDO::FETCH_OBJ);
              $Salt=md5($DateCrea->created);
              $MdpCrypt=crypt($Mdp2, $Salt);

              $InsertMdp=$cnx->prepare("UPDATE ".$Prefix."neuro_compte_Admin SET mdp=:mdpcrypt WHERE email=:email");
              $InsertMdp->bindParam(':mdpcrypt', $MdpCrypt, PDO::PARAM_STR);
              $InsertMdp->bindParam(':email', $Client, PDO::PARAM_STR);
              $InsertMdp->execute();

              $DeleteSecu=$cnx->prepare("DELETE FROM ".$Prefix."neuro_secu_mdp WHERE email=:email");
              $DeleteSecu->bindParam(':email', $Client, PDO::PARAM_STR);
              $DeleteSecu->execute();

              $Erreur= "Votre mot de passe a bien été validé !<br />";
              $Erreur.= "Vous pouvez dès à présent vous connecter !<br />";
              $Erreur.= '<input type=button onClick=(parent.location="'.$Home.'Admin/") value="Se connecter"><br/>';
        }
        
    }
}

?>

<!-- *******************************
*** Script réalisé par NeuroSoft Team ***
********* www.neuro-soft.fr *********
*********************************-->

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

<?php
if (isset($Erreur)) { echo "<font color='#FF0000'>".$Erreur."</font><BR />"; }

if ((isset($Client))&&(!empty($Client))) {
    $RecupHash=$cnx->prepare("SELECT * FROM neuro_secu_mdp WHERE hash=:hash");
    $RecupHash->bindParam(':hash', $Hash, PDO::PARAM_STR);
    $RecupHash->execute();
    $NbRowsHash=$RecupHash->rowCount();

    $VerifClient=$cnx->prepare("SELECT (email) FROM neuro_secu_mdp WHERE email=:email");
    $VerifClient->bindParam(':email', $Client, PDO::PARAM_STR);
    $VerifClient->execute();
    $NbRowsClient=$VerifClient->rowCount();

    if ($NbRowsClient!=1) {
        echo "Aucune procédure de changement de mot de passe n'a été demander !<br />";
    }
    elseif ($NbRowsHash!=1) {
        echo "Erreur de procédure, veuillez recommencé !<br />";
    }

    else { ?>
        <form id="form_mdp" action="" method="POST">

        <label class="col_2">Nouveau mot de passe :</label>
        <input type="password" name="mdp" required="required"/>
        <br />
        <label class="col_2">Confirmer le mot de passe :</label>
        <input type="password" name="mdp2" required="required"/>
        <br />
        <span class="col_2"></span>
        <input type="submit" name="Valider" value="Valider"/>
        </form><?php 
    }
}
else {
    echo "Erreur !";
}
?>
</article>
</section>
</div>
</CENTER>
</body>

</html>
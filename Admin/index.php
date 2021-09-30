<?php
require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Admin/lib/script/redirect.inc.php");

$Erreur=$_GET['erreur'];
$Valid=$_GET['valid']; 

if ((isset($_GET['NeuroSoft']))&&($_GET['NeuroSoft']=="CQDFX301")) {
   if (isset($_POST['inscription'])) {
        $Email=FiltreEmail('email');
        $Mdp=FiltreMDP('mdp');
        $Mdp2=FiltreMDP('mdp2');

        $Entete = "From: ".$Societe."<".$Expediteur.">\r\n";
        $Entete .= "Reply-to: ".$Societe."<".$Email.">\r\n";
        $Entete .= 'MIME-Version: 1.0' . "\r\n";                        
        $Entete .='Content-Type: text/html; charset="iso-8859-15"'."\r\n";
        $Entete .='Content-Transfer-Encoding: 8bit';

        $Message ="<html><head><title>Validation d'inscription</title>
            </head><body>
            <font color='#9e2053'><H1>Validation d'inscription</H1></font>          
            Veuillez cliquer sur le lien suivant pour valider votre inscription.</p>
            <a href='".$Home."/Admin/Validation/?id=".$Email."&Valid=1'>Cliquez ici</a></p>
            ____________________________________________________</p>
            Cordialement NeuroSoft Team<br />
            www.neuro-soft.fr</p>
            <font color='#FF0000'>Cet e-mail contient des informations confidentielles et / ou protégées par la loi. Si vous n'en êtes pas le véritable destinataire ou si vous l'avez reçu par erreur, informez-en immédiatement son expéditeur et détruisez ce message. La copie et le transfert de cet e-mail sont strictement interdits.</font>                 
            </body></html>";

        if ($Email[0]===false) {
           $Erreur=$Email[1];
        }

        elseif ($Mdp[0]===false) {
           $Erreur=$Mdp[1];
        }
        elseif ($Mdp2[0]===false) {
           $Erreur=$Mdp2[1]; 
        }
        elseif ($Mdp2!=$Mdp) {
           $Erreur="Les mots de passe ne sont pas identique !"; 
        }
        else {
            $RecupClient=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
            $RecupClient->bindParam(':email', $Email, PDO::PARAM_STR);
            $RecupClient->execute();
            $RecupC=$RecupClient->fetch(PDO::FETCH_OBJ);
            $NbRowsEmail=$RecupClient->rowCount();

            if ($NbRowsEmail==1) {
                $Erreur="Cette adresse E-mail existe déjà !<br />"; 
            }
            else {
                 $InsertUser=$cnx->prepare("INSERT INTO ".$Prefix."neuro_compte_Admin (email, created) VALUES (:email, NOW())");
                 $InsertUser->bindParam(':email', $Email, PDO::PARAM_STR);
                 $InsertUser->execute();

                 $RecupCreated=$cnx->prepare("SELECT (created) FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
                 $RecupCreated->bindParam(':email', $Email, PDO::PARAM_STR);
                 $RecupCreated->execute();

                 $DateCrea=$RecupCreated->fetch(PDO::FETCH_OBJ);
                 $Salt=md5($DateCrea->created);
                 $MdpCrypt=crypt($Mdp2, $Salt);

                 $InsertMdp=$cnx->prepare("UPDATE ".$Prefix."neuro_compte_Admin SET mdp=:mdpcrypt WHERE email=:email");
                 $InsertMdp->bindParam(':mdpcrypt', $MdpCrypt, PDO::PARAM_STR);
                 $InsertMdp->bindParam(':email', $Email, PDO::PARAM_STR);
                 $InsertMdp->execute();

                 if ($InsertMdp) {
                      if (!mail($Email, "Validation d'inscription", $Message, $Entete)) {
                            $Erreur="L'e-mail de confirmation n'a pu être envoyé, vérifiez que vous l'avez entré correctement !<br />"; 
                      }
                        
                      else {
                           $Valid="Bonjour,<br />";
                           $Valid.="Merci de vous être inscrit<br />";
                           $Valid.="Un E-mail de confirmation vous a été envoyé à l'adresse suivante : ".$Email."<br />";
                           $Valid.="Veuillez valider votre adresse e-mail avant de vous connecter !<br />";
                           header("location:".$Home."/Admin/?valid=".urlencode($Valid));
                      }
                 }
            }
       }
   }
}

if (isset($_POST['OK'])) {

    $Email=FiltreEmail('email');
    $Mdp=FiltreMDP('mdp');
    
    if ($Email[0]===false) {
       $Erreur=$Email[1];
    }

    elseif ($Mdp[0]===false) {
       $Erreur=$Mdp[1]; 
    }
    else {
        $RecupClient=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
        $RecupClient->bindParam(':email', $Email, PDO::PARAM_STR);
        $RecupClient->execute();
        $RecupC=$RecupClient->fetch(PDO::FETCH_OBJ);
        $NbRowsEmail=$RecupClient->rowCount();

        if ($NbRowsEmail!=1) {
            $Erreur="Cette adresse E-mail ne correspond à aucun compte !<br />";
        }
        elseif ($RecupC->activate!=1) {
            $Erreur="le compte n'est pas activé, veuillez activer votre compte avant de vous connecter!<br />";
        }

        else {
            $Salt=md5($RecupC->created);
            $MdpCrypt=crypt($Mdp, $Salt);

            $Mdp=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE mdp=:mdp AND email=:email");
            $Mdp->bindParam(':mdp', $MdpCrypt, PDO::PARAM_STR);
            $Mdp->bindParam(':email', $Email, PDO::PARAM_STR);
            $Mdp->execute();
            $nb_rows=$Mdp->rowCount();

            if ($nb_rows!=1) { 
                $Erreur="Le mot de passe ne correspond pas à cette adresse e-mail !<br />";
            }
            else {  
                session_start();                
                $_SESSION['NeuroClient']=$Email;
                $Valid="Vous êtes connecté ";
                header("location:".$Home."/Admin/?valid=".urlencode($Valid));
            } 
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

<?php if (isset($Erreur)) { echo "<p><font color='#FF0000'>".$Erreur."</font></p>"; }
if (isset($Valid)) { echo "<p><font color='#009900'>".$Valid."</font></p>"; }

if ($Cnx_Ok==false) { ?>

    <p><H1>Connexion</H1></p>
    <form name="form_cnx" action="" method="POST">
    <label class="col_2">E-mail<font color='#FF0000'>*</font> : </label>
    <input name="email" type="email" required="required"/>
    <br />
    <label class="col_2">Mot de passe<font color='#FF0000'>*</font> : </label>
    <input name="mdp" type="password" required="required"/>
    </p>
    <span class="col_2"></span>
    <input type="submit" name="OK" value="OK"/>
    </form>
    <p><label><a href="<?php echo $Home; ?>/Admin/Securite/">Mot de passe oublié ?</a></label></p>
<?php }
else { ?>
    <a href="<?php echo $Home; ?>/Admin/lib/script/deconnexion.php">Déconnexion</a>
<?php }

if ((isset($_GET['NeuroSoft']))&&($_GET['NeuroSoft']=="CQDFX301")) {    ?>
    <p><form name="form_inscription" action="" method="POST">
    <label class="col_2">Adresse E-mail<font color='#FF0000'>*</font> :</label>
    <input type="email" name="email" required="required"/> 
    <br />
    <label class="col_2">Créer un mot de passe<font color='#FF0000'>*</font> :</label>
    <input type="password" name="mdp" required="required"/> 
    <br />
    <label class="col_2">Confirmer le mot de passe<font color='#FF0000'>*</font> :</label>
    <input type="password" name="mdp2" required="required"/>
    <input type="submit" name="inscription" value="Inscription"/></p>
    </form>
    </p>
<?php
}
?>
</article>
</section>
</div>
</CENTER>
</body>

</html>
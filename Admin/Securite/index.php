<?php 
require($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");

if (isset($_POST['Recevoir'])) {

    $Email=FiltreEmail('email');
    $Hash=md5(uniqid(rand(), true));

    if ($Email[0]===false) {
         $Erreur=$Email[1];
    }
    else {

         $VerifEmail=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_compte_Admin WHERE email=:email");
         $VerifEmail->bindParam(':email', $Email, PDO::PARAM_STR);
         $VerifEmail->execute();
         $NbRowsEmail=$VerifEmail->rowCount();
         $Data=$VerifEmail->fetch(PDO::FETCH_OBJ);

         $Client=$Data->hash_client;
       
         $VerifSecu=$cnx->prepare("SELECT (email) FROM ".$Prefix."neuro_secu_mdp WHERE email=:email");
         $VerifSecu->bindParam(':email', $Email, PDO::PARAM_STR);
         $VerifSecu->execute();
         $NbRowsClient=$VerifSecu->rowCount();
    
         if ($NbRowsClient==1) {
                 $Erreur="Une procédure de changement de mot de passe à déja été demander !<br />";
         }
        
        elseif ($NbRowsEmail!=1) {          
            $Erreur="Cette adresse n'existe pas !<br />";
            $Erreur.='<input type=button value=Retour onclick=javascript:history.back()><br />';    
        }

        else {
            $InsertHash=$cnx->prepare("INSERT INTO ".$Prefix."neuro_secu_mdp (hash, email, created) VALUES (:hash, :email, NOW())");
            $InsertHash->bindParam(':hash', $Hash, PDO::PARAM_STR);
            $InsertHash->bindParam(':email', $Email, PDO::PARAM_STR);
            $InsertHash->execute();
        
            $Entete = "From: ".$Societe."<".$Expediteur.">\r\n";
            $Entete .= "Reply-to: ".$Societe."<".$Email.">\r\n";
            $Entete .= 'MIME-Version: 1.0' . "\r\n";                        
            $Entete .='Content-Type: text/html; charset="iso-8859-15"'."\r\n";
            $Entete .='Content-Transfer-Encoding: 8bit';

            $Message ="<html><head><title>Changement de mot de passe</title>
                </head><body>
                <font color='#9e2053'><H1>Procédure de changement de mot de passe</H1></font>           
                Veuillez cliquer sur le lien suivant pour changer votre mot de passe sur www.neuro-soft.fr .</p>                        
                <a href='".$Home."Admin/Validation/Mdp/?id=$Email&hash=$Hash'>Cliquez ici</a></p>
                ____________________________________________________</p>
                Cordialement<br />
                www.neuro-soft.fr</p>
                <font color='#FF0000'>Cet e-mail contient des informations confidentielles et / ou protégées par la loi. Si vous n'en êtes pas le véritable destinataire ou si vous l'avez reçu par erreur, informez-en immédiatement son expéditeur et détruisez ce message. La copie et le transfert de cet e-mail sont strictement interdits.</font>                 
                </body></html>";

            if (!mail($Email, "Changement de mot de passe", $Message, $Entete)) {                           
                $Erreur="L'e-mail de confirmation n'a pu etre envoyé, vérifiez que vous l'avez entré correctement !<br />";
                $Erreur.='<input type=button value=Retour onclick=javascript:history.back()><br />';                            
            }
            else {
                $Erreur="Un E-mail de confirmation vous a été envoyé à l'adresse suivante : ".$Email."<br />";
            }
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
if (isset($Valid)) { echo "<font color='#009900'>".$Valid."</font><BR />"; } ?>

<H1>Procédure de changement de mot de passe</H1></p>

<form id="form_email" action="" method="POST">

<label class="col_2">Adresse E-mail :</label>
<input type="email" name="email"required="required"/>
<br />

<span class="col_2"></span>
<input type="submit" name="Recevoir" value="Recevoir"/>
</form>
</article>
</section>
</div>
</CENTER>
</body>

</html>
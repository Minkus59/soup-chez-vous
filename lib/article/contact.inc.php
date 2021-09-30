<?php 
$Erreur=$_GET['erreur'];
$Valid=$_GET['valid'];

session_start();
?>

<section>
<div id="Center">
<article>
<?php 
if (isset($Erreur)) { echo "<font color='#FF0000'>".$Erreur."</font></p>"; } 
if (isset($Valid)) { echo "<font color='#00CC00'>".$Valid."</font></p>"; }
?>

<H1>Contact</H1></p>

<div id="Gauche">

Pour toutes questions commerciales ou techniques </p>

Tel : <b>07 86 56 41 14</b></p>

E-mail : <b><?php echo $Destinataire; ?></b> ou via le <b>formulaire ci-dessous</b> </p>

<form name="form_contact" id="form_contact" action="<?php echo $Home; ?>/lib/script/contact.php" method="POST">

<input type="text" value="<?php if (isset($_SESSION['nom'])) { echo $_SESSION['nom']; } ?>" name="nom" placeholder="Nom / Prénom*" required="required"></p>
<input type="text" value="<?php if (isset($_SESSION['tel'])) { echo $_SESSION['tel']; } ?>" name="tel" placeholder="Numero de téléphone*" required="required"/></p>
<input type="text" value="<?php if (isset($_SESSION['cp'])) { echo $_SESSION['cp']; } ?>" name="cp" placeholder="Code postal*" required="required"/></p>
<input type="text" value="<?php if (isset($_SESSION['sujet'])) { echo $_SESSION['sujet']; } ?>" name="sujet" placeholder="Sujet*" required="required"/></p>
<textarea cols="40" rows="10" name="message" placeholder="Message ou détailles pour devis*" required="required"><?php if (isset($_SESSION['message'])) { echo $_SESSION['message']; } ?></textarea></p>
<input type="email" value="<?php if (isset($_SESSION['email'])) { echo $_SESSION['email']; } ?>" name="email" placeholder="Votre adresse e-mail*" required="required"/></p>
<input type="submit" name="Envoyer" value="Envoyer"/>

</form></p>

<font color='#FF0000'>*</font> : Informations requises</p>
</div>

<div id="Gauche">
<img src="<?php echo $Home; ?>/lib/img/food-truk.png"/>

<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d40462.65562932709!2d3.0362223878819665!3d50.66582057517272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1453808358524" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
</article>
</div>
</section>


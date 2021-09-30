<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");                      
?>
<!DOCTYPE HTML>
<html>

<head>
<meta charset="ISO-8859-15"/>

<title>Food truck Villeneuve d'ascq - <?php echo $Societe; ?> - Contactez nous</title>

<meta name="category" content="Contactez-nous" />
<meta name="description" content="<?php echo $Societe; ?> - 14 rue Roland de provin - 59840 LOMPRET"/>
<meta name="keywords" content="<?php echo $Societe; ?>, contact, devis"/>

<meta name="robots" content="index, follow"/>

<meta name="author" content="NeuroSoft Team">
<meta name="publisher" content=""/>
<meta name="reply-to" content="<?php echo $Destinataire; ?>"/>

<meta name="viewport" content="width=device-width" >
<link rel="alternate" hreflang="fr" href="<?php echo $Home; ?>" />

<link rel="shortcut icon" href="<?php echo $Home; ?>lib/img/icone.ico" >
<link rel="stylesheet" type="text/css" media="screen AND (max-width: 480px)" href="<?php echo $Home; ?>/lib/css/misenpatel.css" />
<link rel="stylesheet" type="text/css" media="screen AND (min-width: 480px) AND (max-width: 960px)" href="<?php echo $Home; ?>/lib/css/misenpatab.css" />
<link rel="stylesheet" type="text/css" media="screen AND (min-width: 960px)" href="<?php echo $Home; ?>/lib/css/misenpapc.css" >

<!--[if !IE]><!-->
<script type="text/javascript" src="<?php echo $Home; ?>/lib/script/jquery-2.0.3.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo $Home; ?>/lib/js/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gt IE 8]>
<script type="text/javascript" src="<?php echo $Home; ?>/lib/js/fix.js"></script>
<![endif]-->

<script type="text/javascript" src="<?php echo $Home; ?>/lib/js/analys.js"></script>
</head>
<body>
<center>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/header.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/nav.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/article/pub.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/article/contact.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/footer.inc.php"); ?>
</center>
</body>
</html>
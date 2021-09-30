<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/fonction_perso.inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Admin/lib/script/redirect.inc.php");
?>
<!DOCTYPE HTML>
<html>

<head>
<meta charset="ISO-8859-15"/>

<title>Food Truck Villeneuve d'ascq - La tourn�e de l'agglom�ration lilloise - <?php echo $Societe; ?></title>

<meta name="category" content="Ou manger" />
<meta name="description" content="Soup'chez vous vous pr�sente sa tourn�e de dans l'agglom�ration lilloise, pour vous servir une d�licieuse soupe maison id�al pour votre pose repas. " />
<meta name="keywords" content="<?php echo $Societe; ?>, "/>

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

<script type="text/javascript" src="<?php echo $Home; ?>/lib/js/analys.js"></script>
</head>
<body>
<center>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/header.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/nav.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/article/pub.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/article/Page.inc.php"); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/script/footer.inc.php"); ?>
</center>
</body>
</html>
<section>
<div id="Center">
<?php
$PageActu=$Home.$_SERVER['REQUEST_URI'];

$List=$cnx->prepare("SELECT * FROM ".$Prefix."neuro_Actu WHERE page=:page");
$List->bindParam(':page', $PageActu, PDO::PARAM_STR);
$List->execute();
$Count=$List->rowcount();

if ($Count>0) {

    while($Actu=$List->fetch(PDO::FETCH_OBJ)) { 

        echo '
        <article>
        <H1>'.stripslashes($Actu->titre).'</H1></p>';

        if ($Actu->photo=="1") { echo '<img class="droite" src="'.$Actu->lien.'" alt="'.$Actu->alt.'">'; }

        echo stripslashes($Actu->message);
        if ($Cnx_Ok==true) { 
            echo '<a href="'.$Home.'/Admin/Article/?id='.$Actu->id.'"><img src="'.$Home.'/Admin/lib/img/modifier.png"></a><a href="'.$Home.'/Admin/Article/supprimer.php?id='.$Actu->id.'"><img src="'.$Home.'/Admin/lib/img/supprimer.png"></a>';
        } 
        echo '</article>';
    }
}
else {
    echo '<article>Aucun article pour le moment !</article>';
}
?>

</div>
</section>
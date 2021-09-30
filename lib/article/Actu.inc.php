<article>
<?php
$Valid=$_GET['valid'];

if (isset($Valid)) { 
    echo "<font color='#00BB00'>".$Valid."</font><BR />"; 
} 

$List=$cnx->prepare("SELECT * FROM neuro_Actu ORDER BY id DESC");
$List->execute();
$Count=$List->rowcount();

if ($Count>0) {

    while($Actu=$List->fetch(PDO::FETCH_OBJ)) { 

        echo '
        <article>
        <H1>'.$Actu->titre.'</H1>
        <span class="created">Le '.date("d-m-y", time($Actu->created)).'</span>';

        if ($Actu->photo=="1") { echo '<img class="droite" src="'.$Actu->lien.'" alt="'.$Actu->alt.'">'; }

        echo '<p>'.nl2br($Actu->message).'</p>';
        if ($Cnx_Ok==true) { 
            echo '<a href="'.$Home.'/Admin/Article/?id='.$Actu->id.'"><img src="'.$Home.'/lib/img/modifier.png"></a><a href="'.$Home.'/Admin/Article/supprimer.php?id='.$Actu->id.'"><img src="'.$Home.'/lib/img/supprimer.png"></a>';
        } 
        echo '</article>';
    }
}
else {
    echo '<article>Aucun article pour le moment !</article>';
}
?>
</article>
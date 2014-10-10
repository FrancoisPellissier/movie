<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-3">
    	<?php echo '<img src="'.$curFiche['folder'].$curFiche['movieid'].'.jpg" alt="Affiche du film" title="'.$curFiche['titrevf'].'" class="img-rounded" />'; ?>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-9">
    	<h1><?php echo $curFiche['titrevf']; ?></h1>
        
        <p>
            <?php
            foreach(array('bluray' => 'Blu-Ray', 'dvd' => 'DVD') AS $type => $typename) {
                echo "\n\t\t\t".'<a title="'.$type.'" href="film/'.$curFiche['movieid'].'/addBiblio/'.$type.'" class="addBiblio"><button type="button" class="btn '.($user['hasFilm'][$type] == 1 ? 'btn-success' : 'btn-default').'" id="'.$type.'">'.$typename.'</button></a>';
            }
            ?>
        </p>
    	
        <p><strong>Date de sortie :</strong> <?php echo $curFiche['datesortie']; ?></p>
    	<p><strong>Réalisateur :</strong> <?php echo $curFiche['realisateur']; ?></p>
    	<p><strong>Acteurs principaux :</strong> <?php echo $curFiche['acteur']; ?></p>
    	<p><strong>Synopsis :</strong> <?php echo $curFiche['synopsis']; ?></p>
    </div>
</div>

<div class="row">
	<?php
	foreach($curFiche['acteurs'] AS $acteur)
		echo "\n\t".'<div class="col-xs-4 col-sm-3 col-md-2"><img src="'.$acteur['folder'].$acteur['personid'].'.jpg" title="'.$acteur['fullname'].' - '.$acteur['role'].'" /></div>';
	?>
</div>
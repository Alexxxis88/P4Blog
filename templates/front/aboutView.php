<?php
$title = 'A propos de Jean';
ob_start();
?>
	<div class=" container about">
        <div class="row">
            <div class="textAbout col-md-8">
                <h2>Jean Forteroche...un écrivain pas commes les autres</h2>
                    <p>Jean Forteroche naît à Ville-d'Avray dans les Hauts-de-Seine en 1956. Victime d'un rhumatisme articulaire aigu à l'âge de 12 ans, il en garde une insuffisance aortique et le désir de vivre intensément chaque instant. Après avoir obtenu son baccalauréat littéraire , il part vivre au Canada afin de rejoindre son frère aîné.
                    </p>
                    <p>Il entreprend des études supérieures en langues à l'université de Calgary où il rencontrera sa femme. À l'issue de ses études, il travaille, jusqu'en 1986, comme professeur de lettres modernes au lycée français Aristide Briand de Vancouver. Durant ses loisirs, il écrit et joue de la musique de jazz tout en fréquentant les cafés locaux.
                    </p>
                    <p>"La mer au clair de lune", le premier roman de Jean Forteroche publié en 1995, sera remarqué par une maison d'édition canadienne, lui permettant une distribution à l'international, qui lui permettra de vivre plusieurs années sur le succès de cet ouvrage. Il a à son actif une dizaine de romans. Le plus célèbre est "J'irai au bout du chemin", écrit en 2001 relate une aventure humaine poignante et chargée d'émotion.
                    </p>
                    <p>Dans ce nouveau roman, "Billet simple pour l'Alaska", Jean Forteroche raconte l'histoire de Christopher McCandless : un étudiant américain brillant qui vient d'obtenir son diplôme et qui est promis à un grand avenir. Rejetant les principes de la société moderne, après un dîner dans un restaurant avec ses parents, pour fêter son diplôme, il décide de partir sur les routes, sans prévenir sa famille. Découvrez les aventures trépidantes de ce personnage attachant et au caractère bien trempé tout au long de ce nouvel ouvrage...
                    </p>
            </div>
            <div class="imageAbout col-md-4">
                    <img src="public/img/jeanforteroche.jpg" alt="Jean Forteroche"/>
            </div>
        </div>
    </div>
    <p style="text-align : center"><a href="index.php">Retour à la page d'accueil</a></p>
<?php
$content = ob_get_clean();
require('templates/base.php');
?>
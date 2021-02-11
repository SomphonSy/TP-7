<?php
require_once('common.php');
$title = "Déconnexion";
// session_destroy();
session_destroy_all();
$icon_info=html_icon('info','inverse');
$icon_user=html_icon('user','inverse');
$message =<<<END
<ul>
    <li> <mark>Vous êtes déconnecté.e $icon_info</mark></li>
    <li>Fermer l'onglet ou le navigateur</li>
</ul>
<a href="login.php" class="button inverse">Nouvelle Connexion $icon_user</a>
END;
$modal_html = html_modal($title,$message,"modal-control-1",$class="",FALSE);
$connexion ='<a href="login.php">Connexion</a>';
html_send_page($title,$modal_html,FALSE);
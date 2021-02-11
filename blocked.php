<?php
require_once('common.php');
$title = "Compte Bloqué";
$message ='<li>Merci de contacter le support '.html_icon('phone','inverse').'</li>';
$main_html = html_modal($title." ".html_icon('lock','inverse'),$message,"modal-control-1","error",FALSE);
html_send_page($title,$main_html,FALSE);

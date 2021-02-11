<?php
require_once('common.php');
session_destroy_all();

$title = "Reset";

sql_exec($database,'DELETE FROM user');
$insert_query = <<<END
INSERT INTO user (id,user,first_name,last_name,password,blocked)
VALUES
(1,'kqui','Kevin','QUI','manGe',0),
(2,'jbon','Jean','BON','cUit',0),
(3,'echirac','Evelyne','CHIRAC','President',0),
(4,'mpage','Marc','PAGE','livRE',1),
(5,'jmohamed','Jean','MOHAMED','prout',0),
(6,'eanderson','Eliott','ANDERSON','poop',0),
(7,'gimpact','Genshin','IMPACT','Pipi',0),
(8,'nuzumaki','Naruto','Uzumaki','Boruto',0),
(9,'j-cvandamne','Jean-Claude','VAN-DAMNE','Water',1),
(10,'otom','Olive','TOM','Ballon',0),
(11,'ots-ubasa','Ozaru','TSUBASA','Football',0),
(12,'jneymar','Jean','NEYMAR','Brazilia',0),
(13,'nPasBon','prenomPasBon','nomPasBon','poop',1),
(14,'Jean','jean-Castex','Jean-Castex','poop',0)
END;
sql_exec($database,$insert_query);

html_send_page($title,"",FALSE);

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
(4,'mpage','Marc','PAGE','livRE',1)
END;
sql_exec($database,$insert_query);

html_send_page($title,"",FALSE);
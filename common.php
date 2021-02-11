<?php
if (session_exist()) {
    session_start();
}
$database = new SQLite3('database.db3');

// SQL
function sql_exec($database,$query) {
    sql_log($query);
    return $database->exec($query); 
} 

function sql_log($query){
    if(isset($_SESSION['user.id'])){
        $log= "Time : ".time()."| IP : ".$_SERVER['REMOTE_ADDR']."| User : ".$_SESSION['user.id']."\nSQLQuery : \n".$query."\n";        
    }
    else{
        $log= "Time : ".time()."| IP : ".$_SERVER['REMOTE_ADDR']."\nSQLQuery : \n".$query."\n";
    }
    if(file_exists("logs/sqlquery.log")){
        $log="-------------------------------------\n".$log;
        file_put_contents("logs/sqlquery.log",$log, FILE_APPEND | LOCK_EX);
    }
    else{
        $logfile = fopen("logs/sqlquery.log", 'w') or die("Can't create file");        
        fwrite($logfile,$log);
        fclose($logfile);
    }
}

function sql_select($database,$select,$data) {
    #$results = $database->query($select);
    $stmt = $database->prepare($select);
    foreach($data as $key => $value){
        $stmt->bindValue($key,$value[0],$value[1]);
    }
    $results = $stmt->execute();
    sql_log($stmt->getSQL(true));
    $rows=[];
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $rows[] = $row;
    }
    return $rows;
}

// HTTP
function http_get_method() {
    return $_SERVER['REQUEST_METHOD'];
}

function http_redirection($page) {
    header("location: $page");
    exit();
}

// SESSION
function session_exist() {
    if (isset($_COOKIE['PHPSESSID'])) {
        return true;
    }
    return false;
}

function session_destroy_all() {
// https://www.php.net/manual/fr/function.session-destroy.php
if (session_status() == PHP_SESSION_ACTIVE) {
  unset($_SESSION);
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
  );
  session_destroy();
}
}

// HTML
function html_icon($icon,$color_modifier="") {
	return '<span class="icon-'.$icon.' '.$color_modifier.'"></span>';
}

function html_version() {
    return '<div id="version">'.html_icon("bookmark")." ".basename(__DIR__)."</div>";
}

function html_modal($titre,$message,$id,$class="",$close=TRUE) {
$close_html = "";
if ($close) {
    $close_html = '<label for="'.$id.'" class="modal-close"></label>';
}
return <<< END
<input type="checkbox" class="modal" id="$id" checked>
<div>
  <div class="card $class">
    $close_html
    <h3 class="section">$titre</h3>
    <div class="section">
        $message
    </div>
  </div>
</div>
END;
}

function html_table($colonnes,$lignes) {
    $thead_html = "<thead><tr>";
    foreach ($colonnes as $th) {
        $thead_html .= '<th>'.$th.'</th>';
    }
    $thead_html .= "</tr></thead>";
    $tbody_html = "<tbody>";
    foreach ($lignes as $tr) {
        $tbody_html .= '<tr>';
        foreach ($tr as $td) {
             $tbody_html .= '<td>'.$td.'</td>';
        }
        $tbody_html .= '</tr>';
    }
    $tbody_html .= "</tbody>";

    $table_html = '<table class="striped hoverable">'.$thead_html.$tbody_html.'</table>';
    return $table_html;
}

function html_card($title,$content,$class="") {
    return <<<END
    <div class="card $class">
    <div class="section"><h4>$title</h4></div>
    <div class="section">$content</div>
    </div>
END;
}

function html_header($title) {
  $user_icon = html_icon('user');
  $logout_icon = html_icon('link');
  $user_html=<<<END
  <span class="col-md-2 button">
  $user_icon
  <span id="userFirstName">{$_SESSION['user.firstName']}</span>
  <span id="userLastName">{$_SESSION['user.lastName']}</span>
  </span>
  <a href="logout.php" id="logout" class="col-md-2 button">$logout_icon Déconnexion</a>
END;
  return <<<END
   <header class="sticky row">
   <span class=" button logo col-md-2">$title</span>
   <span class="col-md col-sm button"></span>
    $user_html
   </header>
END;
}
function html_send_page($title,$main_html,$header_footer=TRUE){

if ($header_footer) {
    $header_html = html_header($title);
} else {
    $header_html = $footer_html = "";
}

$body_id = "body-".strtolower($title);

$version_html = html_version();

$page = <<<END
<!doctype html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="mini-default.css">
<link rel="stylesheet" href="application.css">
<title>$title</title>
</head>
<body id="$body_id">
$header_html
<main>
$main_html
</main>
$version_html
</body>
</html>
END;
exit($page);
}


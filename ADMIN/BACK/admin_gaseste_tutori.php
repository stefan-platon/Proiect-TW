<?php
include("conectare_db.php");

$query = "SELECT t.tutor_id,t.first_name,t.last_name,t.username,t.email,p.username,p.email from PLAYER p join TUTOR t on p.tutor_id=t.tutor_id
                  where
                  (p.first_name like :p_name or p.last_name like :p_name) and p.username like :p_username and p.email like :p_email and
                  (t.first_name like :t_name or t.last_name like :t_name) and t.username like :t_username and t.email like :t_email";

$stid = oci_parse($connection, $query);

$p_name_sec = '%' . $_POST["player_name"] . '%';
$p_username = '%' . $_POST["player_username"] . '%';
$p_email = '%' . $_POST["player_email"] . '%';
$t_name_sec = '%' . $_POST["tutor_name"] . '%';
$t_username = '%' . $_POST["tutor_username"] . '%';
$t_email = '%' . $_POST["tutor_email"] . '%';

if(preg_match('/\W/', $_POST["player_name"]) && $_POST["player_name"]!=null){
  session_start();
  $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
  header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
  exit;
}
oci_bind_by_name($stid, ":p_name", $p_name_sec);
if(preg_match('/\W/', $_POST["player_username"]) && $_POST["player_username"]!=null){
  session_start();
  $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
  header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
  exit;
}
oci_bind_by_name($stid, ":p_username", $p_username);
if(preg_match('/\W/', $_POST["player_email"]) && $_POST["player_email"]!=null){
  session_start();
  $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
  header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
  exit;
}
oci_bind_by_name($stid, ":p_email", $p_email);
if(preg_match('/\W/', $_POST["tutor_name"]) && $_POST["tutor_name"]!=null){
  session_start();
  $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
  header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
  exit;
}
oci_bind_by_name($stid, ":t_name", $t_name_sec);
if(preg_match('/\W/', $_POST["tutor_username"]) && $_POST["tutor_username"]!=null){
  session_start();
  $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
  header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
  exit;
}
oci_bind_by_name($stid, ":t_username", $t_username);
if(preg_match('/\W/', $_POST["tutor_email"]) && $_POST["tutor_email"]!=null ){
  session_start();
  $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
  header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
  exit;
}
oci_bind_by_name($stid, ":t_email", $t_email);

oci_execute($stid);

if (($row = oci_fetch_array($stid, OCI_BOTH)) != false)
    $flag = true;
else
    $flag = false;
$flag_primar = $flag;
echo "<div class = 'clasa_2'>";
if ($flag_primar == false)
    $result = "No result with given parameters was found.";
else
{
    $result = '<table border="1">' . '<tr>' . '<td>Tutor ID</td>' . '<td>First Name</td>' . '<td>Last Name</td>' . '<td>Username</td>' . '<td>Email</td>' . '<td>Player Username</td>' . '<td>Player Email</td></tr>';
}
while ($flag != false) {
    if ($row['TUTOR_ID'] != null)
        $result = $result . "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</tr>";
    if (($row = oci_fetch_array($stid, OCI_BOTH)) != false)
        $flag = true;
    else
        $flag=false;
}
if ($flag_primar != false) {
    $result = $result . "</table>";
    oci_free_statement($stid);
} else
    $flag = false;
echo $result;
echo "</div>";
oci_close($connection);
?>

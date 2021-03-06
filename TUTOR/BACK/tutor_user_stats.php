<?php
/**
 * Created by PhpStorm.
 * User: Catalin
 * Date: 28-May-17
 * Time: 22:19
 */
include ("conectare_db.php");

session_start();
if (isset($_POST["name"]))
    $_SESSION["player_name"] = $_POST["name"];
/*$player_name = $_SESSION["player_name"];
echo '<div id = "profile_user">' . $player_name . '</div>';
$player_name2 = str_replace(" ",".","$player_name");*/
echo '<table class="tabel_body">';

/*$stid = oci_parse($connection, 'SELECT PLAYER_ID FROM player where USERNAME = :player_name2');
oci_bind_by_name($stid, ':player_name2', $player_name2);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
$player_id = $row[0];
oci_free_statement($stid);*/

if (isset($_POST["player_username"])) {
    $player_username = $_POST["player_username"];
    $_SESSION["player_username"] = $player_username;
}
else
    $player_username = $_SESSION["player_username"];

if (isset($_POST["player_id"])) {
    $player_id = $_POST["player_id"];
    $_SESSION["player_id"] = $player_id;
}
else
    $player_id = $_SESSION["player_id"];




$stid = oci_parse($connection, 'SELECT sum(total_score) FROM player_stats where player_id = :player_id');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
echo '<tr class="profil_tr">' . '<td class="profil_td">Scorul total:</td>' . '<td class="profil_td">' . $row[0] . '</td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'SELECT to_char(min(logged_in),\'DD.MM.YYYY\') FROM player_activity where player_id = :player_id');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
echo '<tr class="profil_tr">' . '<td class="profil_td">Jucator JfK din:</td>' . '<td class="profil_td">' . $row[0] . '</td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'SELECT d.DOMAIN_NAME, p.total_score from PLAYER_STATS p join DOMAINS d on p.DOMAIN_ID = d.DOMAIN_ID where p.PLAYER_ID = :player_id order by p.total_score desc');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
if ($row[0] != 0)
    echo '<tr class="profil_tr">' . '<td class="profil_td">Domeniul cu scorul cel mai mare:</td>' . '<td class="profil_td">' . $row[0] . ' (' . $row[1] . ')</td></tr>';
else
    echo '<tr class="profil_tr">' . '<td class="profil_td">Domeniul cu scorul cel mai mare:</td>' . '<td class="profil_td"> - </td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'SELECT d.DOMAIN_NAME, p.total_score from PLAYER_STATS p join DOMAINS d on p.DOMAIN_ID = d.DOMAIN_ID where p.PLAYER_ID = :player_id order by p.total_score');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
if ($row[0] != 0)
    echo '<tr class="profil_tr">' . '<td class="profil_td">Domeniul cu scorul cel mai mic:</td>' . '<td class="profil_td">' . $row[0] . ' (' . $row[1] . ')</td></tr>';
else
    echo '<tr class="profil_tr">' . '<td class="profil_td">Domeniul cu scorul cel mai mic:</td>' . '<td class="profil_td"> - </td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'SELECT round(sum(score)/count(score)*10, 2) FROM tests where PLAYER_ID = :player_id');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
if ($row = oci_fetch_array($stid, OCI_BOTH) == true)
    echo '<tr class="profil_tr">' . '<td class="profil_td">Procentajul de raspunsuri corecte:</td>' . '<td class="profil_td">' . $row[0] . '%</td></tr>';
else
    echo '<tr class="profil_tr">' . '<td class="profil_td">Procentajul de raspunsuri corecte:</td>' . '<td class="profil_td"> - </td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'select sum(number_of_plays) from player_stats where PLAYER_ID = :player_id group by player_id');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
echo '<tr class="profil_tr">' . '<td class="profil_td">Numarul de teste:</td>' . '<td class="profil_td">' . $row[0] . '</td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'select count(test_id) from tests where PLAYER_ID = :player_id and score >= 5');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
echo '<tr class="profil_tr">' . '<td class="profil_td">Numarul de teste cu nota peste 5:</td>' . '<td class="profil_td">' . $row[0] . '</td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'select count(test_id) from tests where PLAYER_ID = :player_id and score < 5');
oci_bind_by_name($stid, ':player_id', $player_id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
echo '<tr class="profil_tr">' . '<td class="profil_td">Numarul de teste cu nota sub 5:</td>' . '<td class="profil_td">' . $row[0] . '</td></tr>';
oci_free_statement($stid);

$stid = oci_parse($connection, 'SELECT difficulty FROM player_profile_view WHERE username = :username');
oci_bind_by_name($stid, ':username', $player_username);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
echo '<tr class="profil_tr">' . '<td class="profil_td">Dificultate:</td>' . '<td class="profil_td">' . $row[0] . '</td></tr>';

oci_free_statement($stid);

oci_close($connection);

echo '</table>';


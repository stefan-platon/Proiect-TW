<?php
/**
 * Created by PhpStorm.
 * User: Catalin
 * Date: 03-Jun-17
 * Time: 20:14
 */
include ("../../BACK/conectare_db.php");

$username = $_SESSION["username"];
$stid = oci_parse($connection, 'SELECT LINK FROM tutor WHERE username = :username');
oci_bind_by_name($stid, ':username', $username);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_BOTH);
$link = $row[0];
oci_free_statement($stid);

    echo '<img src="../'. $link . '" style="max-width:100%; max-height:100%;" alt="alt2">';

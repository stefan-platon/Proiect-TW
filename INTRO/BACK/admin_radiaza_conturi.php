<?php
include ("conectare_db.php");
$sql = 'call user_pachet.radiaza_conturi';
$stid = oci_parse($connection, $sql);
if(!oci_execute($stid))
{
    $e = oci_error($stid);
    echo "Something went wrong :( <br/>";
    echo "Error: " . $e['message'];
}
oci_free_statement($stid);
oci_close($connection);
header('Location: ../HTML/admin_frame.html')
?>
<?php
    header('Content-type: text/xml');
    include ("../INTRO/BACK/conectare_db.php");
    $sql = 'select p.username, t.username, t.score, d.domain_name from player p join tutor t on t.tutor_id = p.tutor_id join tests t on t.player_id = p.player_id join domains d on d.domain_id = t.domain_id order by t.test_id desc';
    $stid = oci_parse($connection, $sql);
    if(!oci_execute($stid))
    {
        $error_flag = 0;
        $e = oci_error($stid);
        echo "Something went wrong :( <br/>";
        echo "Error: " . $e['message'];
    }
    else
    {
        echo "<?xml version='1.0' encoding='iso-8859-1' ?>";
        ?>
        <feed xml:lang="ro-RO" xmlns="http://www.w3.org/2005/Atom">
  			<title>Rezultate J.F.K.</title>
			<subtitle>Ultimele rezultate ale utilizatorilor nostri!</subtitle>
 			<link href="http://localhost:8181/ATOM/atom_feed.php" rel="self"/>
			<updated><?php echo date('d-m-Y H:i:s'); ?></updated>
            <author>
                <name>J.F.K.</name>
                <email>platonfanica@yahoo.com</email>
            </author>
            <id>tag:J.F.K,2017:http://localhost:8181/atom_feed.php</id>

            <?php
            $i = 0;
            while($row = oci_fetch_array($stid, OCI_BOTH))
            {
                if($i < 100)
                {
                    if ($i > 0) {
                        echo "</entry>";
                    }

                    echo "<entry>";
                    echo "<title>";
                    echo $row[0];
                    echo "</title>";
                    echo "<link type='text/html' href='http://localhost:8181/TUTOR/FRONT/HTML/tutor_user_stats.html'/>";
                    echo "<id>";
                    echo "tag:J.F.K,2017:http://localhost:8181/ATOM/atom_feed.php?nume=".$row[0];
                    echo "</id>";
                    echo "<updated>";
                    echo date('d-m-Y H:i:s');
                    echo "</updated>";
                    echo "<author>";
                    echo "<name>";
                    echo $row[0];
                    echo "</name>";
                    echo "</author>";
                    echo "<summary>";
                    echo "Utilizatorul ".$row[0].", supervizat de ".$row[1].", a obtinut scorul de ".$row[2]." in domeniul ".$row[3].".";
                    echo "</summary>";

                    $i++;
                }
            }
            ?>

        </feed>
    <?php
    }
    ?>
?>



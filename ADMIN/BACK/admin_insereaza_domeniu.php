<?php
include("conectare_db.php");
$sql = 'begin :rezultat :=  admin_pachet.insert_domeniu(:v_nume,:v_tip, :v_img); END;';
$stid = oci_parse($connection, $sql);
if (preg_match('/\W/', $_POST["nume"]) && $_POST["nume"] != null) {
    session_start();
    $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
    header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
    exit;
}
oci_bind_by_name($stid, ":v_nume", $_POST["nume"]);
if (preg_match('/\W/', $_POST["tip"]) && $_POST["tip"] != null) {
    session_start();
    $_SESSION["mesaj_err"] = "Textul contine caractere invalide!";
    header('Location: ../FRONT/HTML/pagina_eroare_admin.html');
    exit;
}
oci_bind_by_name($stid, ":v_tip", $_POST["tip"]);
$target_dir = "../../../IMG/DOMENII/";
$info = pathinfo($_FILES['fileToUpload']['name']);
$ext = $info['extension']; // get the extension of the file
$newname = $_POST["nume"] . "." . $ext;
$target_file = $target_dir . $newname;
$uploadOk = 1;
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Allow certain file formats
if ($ext != "jpg" && $ext != "png" && $ext != "jpeg") {
    echo "Sorry, only JPG, and PNG files are allowed.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your picture was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        oci_bind_by_name($stid, ":v_img", $target_file);
        oci_bind_by_name($stid, ':rezultat', $rezultat, 100);
        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            echo "Something went wrong :( <br/>";
            echo "Error: " . $e['message'];
        }
        oci_free_statement($stid);
        oci_close($connection);
        echo $rezultat;
    } else {
        echo "Sorry, there was an error uploading your picture.";
    }
}
?>
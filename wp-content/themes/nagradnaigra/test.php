<?php
require_once('connection.php');

$slikaName = $_FILES['file']['name']; 
$slikaType = $_FILES['file']['type'];
$slikaTmpName = $_FILES['file']['tmp_name'];
$slikaErr = $_FILES['file']['error']; 
$slikaSize = $_FILES['file']['size'] / (1024*1024); 

$arr_file_types = ['image/jpeg', 'image/png', 'image/jpg'];
 
if (!(in_array($slikaType, $arr_file_types))) {
    echo "Error: Format nije podržan";
} else if($slikaSize > 5) {
    echo "Error: Datoteka ne smije biti veća od 5mb";
} else if($slikaErr != 0) {
    echo "Error: Došlo je do pogreške";
} else {

    $imagePath = $_SERVER["DOCUMENT_ROOT"] . "/wordpress/wp-content/themes/nagradnaigra/uploads/";


    $fileUploadName = time() . '_' . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $fileUploadName);

    print_r($fileUploadName);


    $array = [];

    try {
        $sql = "SELECT slika FROM prijave";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            array_push($array, $row['slika']);
        }
        $conn->close();
        
    } catch (Exeption $e) {
        print_r($e);
    }


    $files1 = scandir($imagePath);

    for ($i=2; $i < (count($files1)); $i++) { 
        if (!in_array($files1[$i], $array)) {
            if($files1[$i] != $fileUploadName) {
               unlink($_SERVER["DOCUMENT_ROOT"] . "/wordpress/wp-content/themes/nagradnaigra/uploads/" . $files1[$i]);
            }

        }
    }

}
 




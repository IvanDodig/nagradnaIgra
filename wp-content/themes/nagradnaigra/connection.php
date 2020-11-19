<?php

    $conn = mysqli_connect('localhost', 'root', '', 'wordpress');

    if (!$conn) {
        echo 'Problem sa spajanjem na bazu: ' . mysqli_connect_error();
    }

?>
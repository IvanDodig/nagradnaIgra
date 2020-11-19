<?php

    get_header(); 

    $user = wp_get_current_user();
    if($user->roles[0] == "administrator"){
        echo '<h2> Popis prijava </h2>';
        require('popis-prijava.php');
    } else {
        echo "Samo administrator može pristupiti ovoj stranici";
    }

    get_footer(); 

?>
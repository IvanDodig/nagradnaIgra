
<?php
    require_once("connection.php");

    try {
        $sql = "SELECT * FROM prijave ORDER BY id DESC";
        $result = $conn->query($sql);
        
    } catch (Exeption $e) {
        print_r($e);
    }
?>


    <?php

        while($row = $result->fetch_assoc()) {

            echo 
            '
            <div class="popis-prijava">
                <div class="col-1">
                    <img src="http://localhost/wordpress/wp-content/themes/nagradnaigra/uploads/'.$row['slika'].'" alt="Nema fotografije">
                </div>
                <div class="col-2">
                    <div>
                        Broj racuna: '.$row['broj_racuna'].'<br>
                        Ime: '.$row['ime'].'<br>
                        Prezime: '.$row['prezime'].'<br>
                        Adresa: '.$row['adresa'].'<br>
                    </div>
                    
                </div>
                <div class="col-3">
                    <div>
                        Kućni broj: '.$row['kucni_broj'].'<br>
                        Mjesto: '.$row['mjesto'].'<br>
                        Poštanski broj: '.$row['postanski_broj'].'<br>
                    
                    </div>
                    
                </div>
                <div class="col-4">
                    <div>
                        Država: '.$row['drzava'].'<br>
                        Kontakt telefon: '.$row['kontakt_telefon'].'<br>
                        E-mail: '.$row['mail'].'<br>
                    </div>
                </div>
            </div>
            ';
        }


    ?>

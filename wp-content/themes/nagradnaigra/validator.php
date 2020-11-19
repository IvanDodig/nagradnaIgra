<?php

require("connection.php");

class Validator {
    private $data;
    private $slika = [];
    private $errors = [];
    private static $fields = ['slika','broj-racuna','ime','prezime','adresa','kucni-broj','mjesto','postanski-broj','drzava','kontakt-telefon','e-mail'];


    public function __construct($post_data,$connection){
        $this->data = $post_data;
        $this->conn = $connection;
    }

    public function validateForm(){
        $this->validateSlika();
        $this->validateBrojRacuna();
        $this->validateIme();
        $this->validatePrezime();
        $this->validateAdresa();
        $this->validateKucniBroj();
        $this->validateMjesto();
        $this->validatePostanskiBroj();
        $this->validateDrzava();
        $this->validateKontaktTelefon();
        $this->validateEmail();

        if (!$this->errors) {
            $d = $this->data;
            try {
                $stmt = $this->conn->prepare("INSERT INTO prijave (slika, broj_racuna, ime, prezime, adresa, kucni_broj, mjesto, postanski_broj, drzava, kontakt_telefon, mail) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param("sssssssssss", $d['slika'],
                    $d['broj-racuna'], $d['ime'], $d['prezime'], $d['adresa'],
                    $d['kucni-broj'], $d['mjesto'], $d['postanski-broj'],
                    $d['drzava'], $d['kontakt-telefon'], $d['e-mail']);

                $stmt->execute();
                $stmt->close();
                $this->conn->close();

            } catch (Exeption $e) {

                $imagePath = $_SERVER["DOCUMENT_ROOT"] . "/wordpress/wp-content/themes/nagradnaigra/uploads/" . $this->data['slika'];
            
            }
        }
        return $this->errors;

    }

    private function validateSlika(){
        $this->basicValidation('slika');
    }

    private function validateBrojRacuna(){
       

        $broj = $this->data['broj-racuna'];

        $stmt = $this->conn->prepare( "SELECT `broj_racuna` FROM `prijave` WHERE `broj_racuna` = ?" );
        $stmt->bind_param( "s", $broj );
        $stmt->execute();
        $racun = $stmt->fetch();
        $stmt->close();

        if ($racun) {
            $this->addError('broj-racuna', "*Broj racuna je zauzet");
            echo 'ne znam';
        }

        $this->basicValidation('broj-racuna');

    }

    private function validateIme(){
        $this->basicValidation('ime');
    }

    private function validatePrezime(){
        $this->basicValidation('prezime');
    }

    private function validateAdresa(){
        $this->basicValidation('adresa');
    }

    private function validateKucniBroj(){
        $this->basicValidation('kucni-broj');
    }

    private function validateMjesto(){
        $this->basicValidation('mjesto');
    }

    private function validatePostanskiBroj(){
        $this->basicValidation('postanski-broj');
    }

    private function validateDrzava(){
        $this->basicValidation('drzava');
    }

    private function validateKontaktTelefon(){
        $this->basicValidation('kontakt-telefon');

        $phone = $this->data['kontakt-telefon'];

        if(!preg_match("/^[0-9]/", $phone)) {
            $this->addError('kontakt-telefon', "Unesite ispravan kontakt telefon");
        }
    }

    private function validateEmail(){

        $email = $this->data['e-mail'];

        $stmt = $this->conn->prepare( "SELECT `mail` FROM `prijave` WHERE `mail` = ?" );
        $stmt->bind_param( "s", $email );
        $stmt->execute();
        $user = $stmt->fetch();
        $stmt->close();


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('e-mail', "*Unesite važeću adresu");
        } else if( $user) {
            $this->addError('e-mail', "*Unesena adresa je već prijavljena");
            echo 'asdasdas';
        }

        $this->basicValidation('e-mail');
     
    }

    private function basicValidation($field) {
        if(!$this->data[$field]) {
            $this->addError($field, "*Obavezna ispuna polja");
        }
    }

    private function addError($key, $value){
        $this->errors[$key] = $value;
    }
}

?>

<?php 
    get_header(); 
    require('validator.php');

    $home = home_url();
    function showError($error, $left) {
        if($error){
            if($left){
                echo '<span class="error error-left">'. $error .'</span>';
            } else {
                echo '<span class="error">'. $error .'</span>';
            }
        } else {
            if($left){
                echo '<span class="important important-left">Obavezno*</span>';
            } else {
                echo '<span class="important">Obavezno*</span>';
            }
        }
    }

    function imgError($error){
        if($error) {
            echo '<span class="error error-img">'. $error .'</span>';
        }
    }

    if(isset($_POST['submit'])) {

        $validation = new Validator($_POST, $conn);
        $errors = $validation->validateForm();
        
        if(!$errors) {
            echo '<div class="full-screen">
                    
                        <img src="http://localhost/wordpress/wp-content/themes/nagradnaigra/img/success-icon.svg">
                        <h2>
                            Uspješna prijava
                        </h2>
                        <p>
                            Dok čekaš rezultate ovog zadatka opusti se uz neko dobro pivo! Kod nas u Enterwellu nema razloga za brigu.
                        </p>
            
                        <div class="full-screen-button">
                                <div class="btn-upper"></div>
                                <div class="btn-lower"></div>
                                <a href= '.$home.'>
                                    <input type="submit" name="submit" class="btn" value="OK" onclick="header(home_url())">
                                </a>
                        </div>
                  
                </div';
        } else {
            echo '<div class="full-screen">
                    
                        <img src="http://localhost/wordpress/wp-content/themes/nagradnaigra/img/alert-icon.svg">
                        <h2>
                            Neuspješna prijava
                        </h2>
                        <p>
                            Tko radi taj i griješi.
                        </p>
            
                        <div class="full-screen-button">
                                <div class="btn-upper"></div>
                                <div class="btn-lower"></div>
                                <input id="try-again" type="submit" name="submit" class="btn" value="Pokušajte ponovo  ">

                        </div>
                  
                </div';
        }
    }
    

?>
    <h2><?php bloginfo('description') ?></h2>
    
    <div class="span">
        U ovoj igri svi dobivamo! Ti ćeš izraditi ovu cool formu, a mi ćemo imati priliku vidjeti tvoje zlatne linije koda 
    </div>
    
    <div class="form-container">
        <img src="http://localhost/wordpress/wp-content/themes/nagradnaigra/img/i-3-ew.svg" class="lighten I-3-EW">
        <form action="" method="POST" novalidate>
            <div class="split left">
                <!-- <div class="centered"> -->
                    <div class="drop-zone input-div" id="dropzone">


                        <img id="dropzone-img" src="http://localhost/wordpress/wp-content/themes/nagradnaigra/img/upload-icon.svg" class="upload-icon"><br>
                        <img id="upload-success" src="http://localhost/wordpress/wp-content/themes/nagradnaigra/img/uploaded-icon.svg" class="upload-icon">
                        <img id="upload-fail" src="http://localhost/wordpress/wp-content/themes/nagradnaigra/img/upload-failed-icon.svg" class="upload-icon">
                        
                        <span class="success-info"></span>
                        
                        <div class="text-1">
                            <div class="text-1-1">
                                Povuci i ispusti datoteku kako bi započeo prijenos
                            </div>

                            <div class="text-1-2">

                                ili
                                <span style="color: white; margin-left: 10px; width: 128px;">
                                 
                                <p><input id="fakeInput" type="button" value="Pretražite računalo" onclick="file_explorer();" class="drop-zone-input"></p>
                                <hr>
                                <input type="file" id="pretraziteRacunalo" accept="image/*"> 
                                <input required type="text" name="slika" id="slika"  value="<?php echo isset($_POST['slika']) ? $_POST['slika'] : '' ?>">
                                </span>                           
                            </div>

                        </div>
                
                        <div class="text-2">
                            PODRŽANI FROMATI
                            <br>
                            pdf,png,jpg
                        </div>
                        <span class="frontend-error"></span>
                        <?php imgError($errors['slika']) ?>
                    </div>
                
                    <div class="input-div <?php echo $errors['ime'] ? 'errors' : '' ?> lighten">
                        <input required type="text" name="broj-racuna" class="normal-input left-input" value="<?php echo isset($_POST['broj-racuna']) ? $_POST['broj-racuna'] : '' ?>">
                        <span  class="placeholder left-placeholder">Broj računa*</span>
                        <?php showError($errors['broj-racuna'], true) ?>
                    </div>
                    
                <!-- </div> -->
            </div>

            <div class="split right lighten">
                <!-- <div class="centered"> -->
                    
                    <div class="input-div <?php echo $errors['ime'] ? 'errors' : '' ?>">
                        <input required type="text" name="ime" class="normal-input"  value="<?php echo isset($_POST['ime']) ? $_POST['ime'] : '' ?>" >
                        <span class="placeholder">Ime*</span>
                        <?php showError($errors['ime'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['prezime'] ? 'errors' : '' ?>"">
                        <input required type="text" name="prezime" class="normal-input" value="<?php echo isset($_POST['prezime']) ? $_POST['prezime'] : '' ?>">
                        <span class="placeholder">Prezime*</span>
                        <?php showError($errors['prezime'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['adresa'] ? 'errors' : '' ?>">
                        <input required type="text" name="adresa" class="normal-input" value="<?php echo isset($_POST['adresa']) ? $_POST['adresa'] : '' ?>">
                        <span class="placeholder">Adresa*</span>
                        <?php showError($errors['adresa'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['kucni-broj'] ? 'errors' : '' ?>">
                        <input required type="text" name="kucni-broj" class="normal-input" value="<?php echo isset($_POST['kucni-broj']) ? $_POST['kucni-broj'] : '' ?>">
                        <span class="placeholder">Kućni broj*</span>
                        <?php showError($errors['kucni-broj'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['mjesto'] ? 'errors' : '' ?>">
                        <input required type="text" name="mjesto" class="normal-input" value="<?php echo isset($_POST['mjesto']) ? $_POST['mjesto'] : '' ?>">
                        <span class="placeholder">Mjesto*</span>
                        <?php showError($errors['mjesto'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['postanski-broj'] ? 'errors' : '' ?>">
                        <input required type="text" name="postanski-broj" class="normal-input" value="<?php echo isset($_POST['postanski-broj']) ? $_POST['postanski-broj'] : '' ?>">
                        <span class="placeholder">Poštanski broj*</span>
                        <?php showError($errors['postanski-broj'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['drzava'] ? 'errors' : '' ?>">
                        <select required name="drzava" class="normal-input dropdown-input" value="<?php echo isset($_POST['drzava']) ? $_POST['drzava'] : '' ?>">
                            <option value="hrvatska">Hrvatska</option>
                            <option value="bih">Bosna i Hercegovina</option>
                            <option value="srbija">Srbija</option>
                            <option value="cg">Crna Gora</option>
                        </select>
                        <span class="placeholder">Država*</span>
                        <?php showError($errors['drzava'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['kontakt-telefon'] ? 'errors' : '' ?>">
                        <input required type="text" name="kontakt-telefon" class="normal-input" value="<?php echo isset($_POST['kontakt-telefon']) ? $_POST['kontakt-telefon'] : '' ?>">
                        <span class="placeholder">Kontakt telefon*</span>
                        <?php showError($errors['kontakt-telefon'], false) ?> 
                    </div>
                    <div class="input-div <?php echo $errors['e-mail'] ? 'errors' : '' ?>">
                        <input required type="text" name="e-mail" class="normal-input" value="<?php echo isset($_POST['e-mail']) ? $_POST['e-mail'] : '' ?>">
                        <span class="placeholder">E-mail*</span>
                        <?php showError($errors['e-mail'], false) ?> 
                    </div>

                    

                <!-- </div> -->
            </div>

            <div class="test">
                <div class="btn-upper"></div>
                <div class="btn-lower"></div>
                <input type="submit" name="submit" class="btn" value="Pošalji">
            </div>
        </form>
    </div>
       

<?php get_footer(); ?>
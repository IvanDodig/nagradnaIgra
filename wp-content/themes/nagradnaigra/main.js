const DOMStrings = {
    dropzone: document.getElementById("dropzone"),
    lighten: document.getElementsByClassName("lighten"),
    leftSide: document.querySelector(".left"),
    successDrop: document.querySelector("#upload-success"),
    failDrop: document.querySelector("#upload-fail"),
    defaultDrop: document.querySelector("#dropzone-img"),
    button: document.getElementById('pretraziteRacunalo'),
    dropText1: document.querySelector('.text-1'),
    dropText2: document.querySelector('.text-2'),
    dropError: document.querySelector('.frontend-error'),
    successInfo: document.querySelector('.success-info'),
    tryAgain: document.querySelector('#try-again'),
    inputDiv: document.getElementsByClassName("input-div"),
    normalInput: document.getElementsByClassName("normal-input"),
    error: document.getElementsByClassName("error"),
    slikaInput: document.querySelector("#slika"),
    imgError: document.querySelector(".error-img"),
    fullScreenMsg: document.querySelector(".full-screen")
}
// border za dropzone
const lightDashed = "url(\"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='10' ry='10' stroke='%23FFFFFF45' stroke-width='2' stroke-dasharray='17%2c 5' stroke-dashoffset='10' stroke-linecap='square'/%3e%3c/svg%3e\")";
const hardDashed = "url(\"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='10' ry='10' stroke='%23FFFFFF' stroke-width='2' stroke-dasharray='17%2c 5' stroke-dashoffset='10' stroke-linecap='square'/%3e%3c/svg%3e\")";

// uklananje errora na input
for(let i = 1; i < DOMStrings.inputDiv.length; i++){
    DOMStrings.normalInput[i - 1].addEventListener('input', e => {
        if(DOMStrings.inputDiv[i].classList.contains("errors")) {
            DOMStrings.inputDiv[i].classList.remove("errors");
            DOMStrings.inputDiv[i].childNodes[5].innerText = "";
        }
    })
    
}

// pamćenje inputa slike
if(DOMStrings.slikaInput.value != ""){
    uploadSuccess(DOMStrings.slikaInput.value);
}

// uklananje zaslona s porukom o neuspješnoj prijavi
if (DOMStrings.tryAgain) {
    DOMStrings.tryAgain.addEventListener("click", e => {
        DOMStrings.fullScreenMsg.remove();
    })
}


//Animacije na dragover dropzonea
DOMStrings.dropzone.addEventListener("dragover",  e => {
    e.preventDefault();
    DOMStrings.leftSide.style.borderRight = "solid 0.5px rgba(255,255,255,0.2) ";
    DOMStrings.dropzone.style.backgroundImage = hardDashed;
    DOMStrings.dropzone.style.border = "none";
    if(DOMStrings.imgError) {
        DOMStrings.imgError.innerText = "";
    }
    DOMStrings.successDrop.style.display = "none";
    DOMStrings.failDrop.style.display = "none";
    DOMStrings.defaultDrop.style.display = "block";



    for(let i = 0; i < DOMStrings.lighten.length; i++){
        if (!DOMStrings.lighten[i].classList.contains("light")){
            DOMStrings.lighten[i].classList.add("light");
        }
    }
});

//Animacije na dragleave dropzonea
DOMStrings.dropzone.addEventListener("dragleave",  e => {

    for(let i = 0; i < DOMStrings.lighten.length; i++){
        if (DOMStrings.lighten[i].classList.contains("light")){
            DOMStrings.lighten[i].classList.remove("light");
        }
    }
    DOMStrings.dropzone.style.backgroundImage = lightDashed;
    DOMStrings.leftSide.style.borderRight = "solid 0.5px white "
    

});

// Animacije na uploadanje slike
DOMStrings.dropzone.addEventListener("drop", e => {
    e.preventDefault();
    
    const allowedExt = ['jpeg', 'png', 'jpg'],
        files = e.dataTransfer.files;
    let fileName, fileExt, fileSize;

    if(files.length === 1){

        fileName = files[0].name;
        fileSize = files[0].size / (1024*1024);
        fileExt = fileName.split(".").pop().toLowerCase();

        if(!allowedExt.includes(fileExt)){
            uploadFailed("*Format nije podržan");
        } else if (fileSize > 5 ) {
            uploadFailed("*Prevelika datoteka");
        } else {
            uploadSuccess(fileName);
            upload_file(e);
        }

    } else {

        uploadFailed("*Unesite točno jednu sliku");

    }
});

// funkcija za uploadanje datoteke za drop
function upload_file(e) {
    let fileobj;
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj);
}

// Animacije na klik buttona "Pretražite računalo"
function file_explorer() {
    DOMStrings.button.click();
    DOMStrings.button.onchange = function() {

        const allowedExt = ['pdf', 'png', 'jpg'];
        let  fileName, fileSize, fileExt, fileobj;

        fileobj = DOMStrings.button.files[0];        
      
        fileName = fileobj.name;
        fileSize = fileobj.size / (1024*1024);
        fileExt = fileName.split(".").pop().toLowerCase();

        if(!allowedExt.includes(fileExt)){
            uploadFailed("*Format nije podržan");
        } else if (fileSize > 5 ) {
            uploadFailed("*Prevelika datoteka");
        } else {
            uploadSuccess(fileName);
            ajax_file_upload(fileobj);
        };        
    };
}

// uploadanje datoteke
function ajax_file_upload(file_obj) {
    if(file_obj != undefined) {
        var form_data = new FormData();                  
        form_data.append('file', file_obj);
        $.ajax({
            type: 'POST',
            url: 'http://localhost/wordpress/wp-content/themes/nagradnaigra/test.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
                console.log(response);
                document.getElementById('slika').value = response;
                $('#pretraziteRacunalo').val('');
            }
        });
    } 
}


// animacije dropzonea za neuspješan upload
function uploadFailed(error) {
    DOMStrings.dropError.innerText = error;
    DOMStrings.successInfo.innerText = "Prijenos nije uspio";
    DOMStrings.successInfo.style.color = "#d9452d"

    DOMStrings.dropzone.style.backgroundImage = lightDashed;
    DOMStrings.leftSide.style.borderRight = "solid 0.5px white ";
    DOMStrings.slikaInput.value = "";

    DOMStrings.dropzone.style.backgroundImage = "none";
    DOMStrings.dropzone.style.border = "1px solid #d9452d";

    DOMStrings.dropText1.style.marginTop = "100px";
    DOMStrings.dropText2.style.display = "none";
    
    DOMStrings.successDrop.style.display = "none";
    DOMStrings.failDrop.style.display = "block";
    DOMStrings.defaultDrop.style.display = "none";

    for(let i = 0; i < DOMStrings.lighten.length; i++){
        if (DOMStrings.lighten[i].classList.contains("light")){
            DOMStrings.lighten[i].classList.remove("light");
        }
    }
}

// animacije dropzonea za uspješan upload
function uploadSuccess(fileTitle) {
    DOMStrings.dropError.innerText = "";
    DOMStrings.successInfo.innerText = fileTitle;
    DOMStrings.successInfo.style.color = "white";

    DOMStrings.dropzone.style.backgroundImage = "none";
    DOMStrings.dropzone.style.border = "1px solid white";

    DOMStrings.dropText1.style.marginTop = "100px";
    DOMStrings.dropText2.style.display = "none";

    DOMStrings.successDrop.style.display = "block";
    DOMStrings.failDrop.style.display = "none";
    DOMStrings.defaultDrop.style.display = "none";

    document.querySelector(".text-2").style.display = "none";
    for(let i = 0; i < DOMStrings.lighten.length; i++){
        if (DOMStrings.lighten[i].classList.contains("light")){
            DOMStrings.lighten[i].classList.remove("light");
        }
    }
}







function openModal(content, name) {
    document.getElementById('modal-background').style.display = 'block';
    document.getElementById('modal-box').style.display = 'block';
    document.getElementById('modal-title').innerText = "Fotos da " + name;
    for(i=1; i < 5; i++){
        var imageElement = document.getElementById("modal-img"+(i-1));
        imageElement.src = "Images/casas/" + content + "/" + (i-1) + ".jpeg";
    }
}
  
function closeModal() {
    document.getElementById('modal-background').style.display = 'none';
    document.getElementById('modal-box').style.display = 'none';
}

function redirect() {
    window.location.href = 'signIn.php'
}
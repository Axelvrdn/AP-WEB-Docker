const myForm = document.getElementById('connexionForm');
const myEmail = document.getElementById('email');
const myPwd = document.getElementById('password');
const myErrorEmailExist = document.getElementById('errorEmailExist');
const myErrorPwd = document.getElementById('errorPwd');

// Définir la couleur des messages d'erreur
myErrorEmailExist.style.color = "red";
myErrorPwd.style.color = "red";

// Vérification du formulaire
function validationForm() {
    let isValid = true;

    // Vérification de l'email
    if (myEmail.value.trim() === "") {
        myErrorEmailExist.innerHTML = "Une adresse e-mail est requise.";
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(myEmail.value)) {
        myErrorEmailExist.innerHTML = "L'adresse e-mail n'est pas valide.";
        isValid = false;
    } else {
        myErrorEmailExist.innerHTML = "";
    }

    // Vérification du mot de passe
    if (myPwd.value.trim() === "") {
        myErrorPwd.innerHTML = "Un mot de passe est requis.";
        isValid = false;
    } else {
        myErrorPwd.innerHTML = "";
    }

    return isValid;
}

// Ajout d'un écouteur pour effacer les erreurs en tapant
myEmail.addEventListener('input', () => myErrorEmailExist.innerHTML = "");
myPwd.addEventListener('input', () => myErrorPwd.innerHTML = "");

// Gestion de la soumission du formulaire
myForm.addEventListener('submit', function (e) {
    if (!validationForm()) {
        e.preventDefault(); // Empêche l'envoi du formulaire si des erreurs existent
    }
});

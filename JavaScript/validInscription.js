const myForm = document.getElementById('leForm');
const myRegexUser = /^[a-zA-Z]+$/; // Vérifie qu'il n'y a que des lettres dans le nom et le prénom
const myRegexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Vérifie le format de l'adresse e-mail
const myRegexPwd = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{12,}$/; // Vérifie le mot de passe

const myNom = document.getElementById('nom');
const myPrenom = document.getElementById('prenom');
const myEmail = document.getElementById('email');
const myPwd = document.getElementById('password');

const myErrorNom = document.getElementById('errorNom');
const myErrorPrenom = document.getElementById('errorPrenom');
const myErrorEmailExist = document.getElementById('errorEmailExist');
const myErrorEmailInvalid = document.getElementById('errorEmailInvalid');
const myErrorPwd = document.getElementById('errorPwd');
const myErrorInscription = document.getElementById('erreurInscription');
const myMsgInscription = document.getElementById('messageInscription');

// Initialiser la couleur des erreurs
myErrorNom.style.color = "red";
myErrorPrenom.style.color = "red";
myErrorEmailExist.style.color = "red";
myErrorEmailInvalid.style.color = "red";
myErrorPwd.style.color = "red";
myErrorInscription.style.color = "red";
myMsgInscription.style.color = "green"; // Message de succès en vert

function validationForm() {
  
  // Validation du nom
  if (myNom.value.trim() === "") {
    myErrorNom.innerHTML = "Un nom est requis.";
  } else if (!myRegexUser.test(myNom.value)) {
    myErrorNom.innerHTML = "Le nom doit contenir seulement des lettres.";
  } else {
    myErrorNom.innerHTML = ""; // Pas d'erreur
  }

  // Validation du prénom
  if (myPrenom.value.trim() === "") {
    myErrorPrenom.innerHTML = "Un prénom est requis.";
  } else if (!myRegexUser.test(myPrenom.value)) {
    myErrorPrenom.innerHTML = "Le prénom doit contenir seulement des lettres.";
  } else {
    myErrorPrenom.innerHTML = ""; // Pas d'erreur
  }

  // Validation de l'email
  if (myEmail.value.trim() === "") {
    myErrorEmailExist.innerHTML = "Une adresse e-mail est requise.";
  } else if (!myRegexEmail.test(myEmail.value)) {
    myErrorEmailInvalid.innerHTML = "L'adresse e-mail n'est pas valide.";
  } else {
    myErrorEmailExist.innerHTML = ""; // Pas d'erreur
    myErrorEmailInvalid.innerHTML = ""; // Pas d'erreur
  }

  // Validation du mot de passe
  if (myPwd.value.trim() === "") {
    myErrorPwd.innerHTML = "Un mot de passe est requis.";
  } else if (!myRegexPwd.test(myPwd.value)) {
    myErrorPwd.innerHTML = "Le mot de passe doit faire au moins 12 caractères et contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial."; 
  } else {
    myErrorPwd.innerHTML = ""; // Pas d'erreur
  }
}

myForm.addEventListener('submit', function(e) {
  validationForm(); // Appelle la fonction qui permet de valider le formulaire

  // Si des erreurs sont présentes, empêcher l'envoi du formulaire
  if (myErrorNom.innerHTML || myErrorPrenom.innerHTML || myErrorEmailExist.innerHTML || myErrorEmailInvalid.innerHTML || myErrorPwd.innerHTML) {
    e.preventDefault(); // Empêcher l'actualisation de la page
  } else {
    myMsgInscription.innerHTML = "Inscription réussie !!"; // Afficher un message de succès
  }
});
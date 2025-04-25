document.addEventListener("DOMContentLoaded", function () {
  const myForm = document.getElementById("leForm");
  const myDate = document.getElementById("date");
  const myHeure = document.getElementById("heure");
  const myDesc = document.getElementById("Description");
  const myBateau = document.getElementById("bateau");

  const myErrorDate = document.getElementById("errorDate");
  const myErrorHeure = document.getElementById("errorHeure");
  const myErrorDesc = document.getElementById("errorDescription");
  const myErrorAdd = document.getElementById("errorAdd");


  // Initialiser la couleur des erreurs
    myErrorDate.style.color = "red";
    myErrorHeure.style.color = "red";
    myErrorDesc.style.color = "red";
    myErrorAdd.style.color = "red";

  function validationForm(event) {
      let isValid = true;

      // Validation de la date
      if (myDate.value.trim() === "") {
          myErrorDate.textContent = "Veuillez entrer une date.";
          isValid = false;
      } else {
          myErrorDate.textContent = "";
      }

      // Validation de l'heure
      if (myHeure.value.trim() === "") {
          myErrorHeure.textContent = "Veuillez entrer une heure.";
          isValid = false;
      } else {
          myErrorHeure.textContent = "";
      }

      // Validation de la description
      if (myDesc.value.trim() === "") {
          myErrorDesc.textContent = "Veuillez entrer une description.";
          isValid = false;
      } else {
          myErrorDesc.textContent = "";
      }

      // Validation du bateau sélectionné
      if (myBateau.value.trim() === "") {
          myErrorAdd.textContent = "Veuillez sélectionner un bateau.";
          isValid = false;
      } else {
          myErrorAdd.textContent = "";
      }

      if (!isValid) {
          event.preventDefault(); // Empêcher l'envoi du formulaire si une erreur est présente
      }
  }

  myForm.addEventListener("submit", validationForm);
});



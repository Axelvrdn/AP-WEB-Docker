let secteurSelectionne = null;

function selectionnerSecteur(nomSecteur) {
    secteurSelectionne = nomSecteur; // Enregistre le secteur sélectionné
    console.log("Secteur sélectionné :", secteurSelectionne); // Vérification

    // Réinitialisation des listes
    let selectTraversee = document.querySelector('select[name="traversee"]');
    selectTraversee.innerHTML = '<option value="">Sélectionner une traversée</option>';

    let selectDate = document.getElementById('date_traversee');
    selectDate.innerHTML = '<option value="">Sélectionner une date</option>';

    // Mise à jour des traversées
    fetch('../Get/get_traverseesAdmin.php?nom_secteur=' + encodeURIComponent(nomSecteur))
        .then(response => response.json())
        .then(data => {
            data.forEach(desc => {
                let option = document.createElement('option');
                option.value = desc;
                option.textContent = desc;
                selectTraversee.appendChild(option);
            });
        })
        .catch(error => console.error('Erreur AJAX (traversées) :', error));

    // Mise à jour de la table avec les traversées
    fetch('../Get/get_infosAdmin.php?nom_secteur=' + encodeURIComponent(nomSecteur))
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('tbody');
            tbody.innerHTML = ""; // Nettoie l'ancienne table

            if (data.length === 0) {
                tbody.innerHTML = "<tr><td colspan='7'>Aucune traversée disponible</td></tr>";
                return;
            }

            data.forEach(info => {
                let row = `<tr>
                    <td>${info.id_travers}</td>
                    <td>${info.desc_travers}</td>
                    <td>${info.date_travers}</td>
                    <td>${info.heure_travers}</td>
                    <td>${info.nom_bateau}</td>
                    <td>${info.Passager}</td>
                    <td>${info["véhicule inf2m"]}</td>
                    <td>${info["véhicule sup2m"]}</td>
                    <td><input type="radio" name="id_travers" value="${info.id_travers}"></td>
                </tr>`;
                tbody.innerHTML += row;
            });
        })
        .catch(error => console.error('Erreur AJAX (infos) :', error));
}





function selectionnerTraversee(descTravers) {
    if (!descTravers) {
        document.getElementById('date_traversee').innerHTML = '<option value="">Sélectionner une date</option>';
        return;
    }

    // Vérifier si un secteur est bien sélectionné
    if (!secteurSelectionne) {
        console.error("Erreur : Aucun secteur sélectionné !");
        return;
    }

    // Mise à jour de la liste des dates
    fetch('../Get/get_datesAdmin.php?desc_travers=' + encodeURIComponent(descTravers))
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('date_traversee');
            select.innerHTML = '<option value="">Sélectionner une date</option>';

            data.forEach(date => {
                let option = document.createElement('option');
                option.value = date;
                option.textContent = date;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Erreur AJAX (dates) :', error));

    // Mettre à jour la table avec les infos
    fetch('../Get/get_infosAdmin.php?nom_secteur=' + encodeURIComponent(secteurSelectionne) + '&desc_travers=' + encodeURIComponent(descTravers))
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('tbody');
            tbody.innerHTML = ""; // Nettoie l'ancienne table

            if (data.length === 0) {
                tbody.innerHTML = "<tr><td colspan='7'>Aucune traversée disponible</td></tr>";
                return;
            }

            data.forEach(info => {
                let row = `<tr>
                    <td>${info.id_travers}</td>
                    <td>${info.desc_travers}</td>
                    <td>${info.date_travers}</td>
                    <td>${info.heure_travers}</td>
                    <td>${info.nom_bateau}</td>
                    <td>${info.Passager}</td>
                    <td>${info["véhicule inf2m"]}</td>
                    <td>${info["véhicule sup2m"]}</td>
                    <td><input type="radio" name="id_travers" value="${info.id_travers}"></td>
                </tr>`;
                tbody.innerHTML += row;
            });
        })
        .catch(error => console.error('Erreur AJAX (infos) :', error));
}

function selectionnerDate(dateTravers) {
    let descTravers = document.querySelector('select[name="traversee"]').value;

    if (!dateTravers || !descTravers || !secteurSelectionne) {
        console.error("Erreur : Sélection incomplète !");
        return;
    }

    console.log(`🔍 Mise à jour du tableau avec : Secteur = ${secteurSelectionne}, Traversée = ${descTravers}, Date = ${dateTravers}`);

    fetch(`../Get/get_infosAdmin.php?nom_secteur=${encodeURIComponent(secteurSelectionne)}&desc_travers=${encodeURIComponent(descTravers)}&date_travers=${encodeURIComponent(dateTravers)}`)
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('tbody');
            tbody.innerHTML = ""; // Vide le tableau avant d'insérer les nouvelles données

            if (data.length === 0) {
                tbody.innerHTML = "<tr><td colspan='7'>Aucune traversée disponible</td></tr>";
                return;
            }

            data.forEach(info => {
                let row = `<tr>
                    <td>${info.id_travers}</td>
                    <td>${info.desc_travers}</td>
                    <td>${info.date_travers}</td>
                    <td>${info.heure_travers}</td>
                    <td>${info.nom_bateau}</td>
                    <td>${info.Passager}</td>
                    <td>${info["véhicule inf2m"]}</td>
                    <td>${info["véhicule sup2m"]}</td>
                    <td><input type="radio" name="id_travers" value="${info.id_travers}"></td>
                </tr>`;
                tbody.innerHTML += row;
            });
        })
        .catch(error => console.error('❌ Erreur AJAX (infos) :', error));
}

document.getElementById('date_traversee').addEventListener('change', function() {
    selectionnerDate(this.value);
});


document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById("selectionForm");
    let selectTraversee = document.querySelector('select[name="traversee"]');
    let selectDate = document.getElementById('date_traversee');
    let heureField = document.getElementById("heure_travers_field");

    // Écouteur pour capter le changement de sélection du radio button
    document.querySelector("tbody").addEventListener("change", function (event) {
        if (event.target.name === "id_travers") {
            let selectedRow = event.target.closest("tr");
    
            // 🧠 Assure-toi que les index correspondent bien à ton tableau HTML
            document.getElementById('id_travers_field').value = selectedRow.cells[0].textContent.trim(); // id_travers
            document.getElementById('desc_travers_field').value = selectedRow.cells[1].textContent.trim(); // desc_travers
            document.getElementById('date_travers_field').value = selectedRow.cells[2].textContent.trim(); // date_travers
            document.getElementById('heure_travers_field').value = selectedRow.cells[3].textContent.trim(); // heure_travers
            document.getElementById('nom_bateau_field').value = selectedRow.cells[4].textContent.trim(); // nom_bateau
            
        }
    });
    
    

    /*form.addEventListener("submit", function () {
        document.getElementById('desc_travers_field').value = selectTraversee.value || "";
        document.getElementById('date_travers_field').value = selectDate.value || "";
    });*/
});

document.getElementById("selectionForm").addEventListener("submit", function(event) {
    let selectedTravers = document.querySelector('input[name="id_travers"]:checked');
    if (!selectedTravers) {
        event.preventDefault(); // Empêche l'envoi du formulaire
        alert("Veuillez sélectionner une traversée avant de valider.");
    }
});
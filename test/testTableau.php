<?php
        include '../Fonctions/scriptReserver.php';

        // Récupérer tous les secteurs
        $id_secteur = 2; // À remplacer par la vraie valeur
        $descriptions = getDescTraversées($id_secteur);
        $secteurs = getSecteurs();
        $infos = GetInfo();
    ?>

    <div class="blockR">
        <div class="destination">
            <ul>
            <?php foreach ($secteurs as $secteurItem): ?>
                    <?php echo htmlspecialchars($secteurItem['nom_secteur']); ?>
                    <button type="button" onclick="selectionnerSecteur('<?php echo htmlspecialchars($secteurItem['nom_secteur']); ?>')">
                        Sélectionner
                    </button>
            <?php endforeach; ?>
            </ul>
        </div>

        <div class="tableauReservation">
            <select name="traversee" data-nom-secteur="<?= htmlspecialchars($nom_secteur) ?>" onchange="selectionnerTraversee(this.value)">
                <option value="">Sélectionner une traversée</option>
                <?php foreach ($descriptions as $desc) : ?>
                    <option value="<?= htmlspecialchars($desc) ?>"><?= htmlspecialchars($desc) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="date_traversee" id="date_traversee">
                <option value="">Sélectionner une date</option>
            </select>
        </div>
    </div>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <form id="selectionForm" action="reservation.php" method="GET">
    <!-- Champs cachés pour stocker les infos -->
    <input type="hidden" name="desc_travers" id="desc_travers_field">
    <input type="hidden" name="date_travers" id="date_travers_field">
    <input type="hidden" name="heure_travers" id="heure_travers_field">

        <table>
            <thead>
                <tr>
                    <th colspan="3">Traversée</th>
                    <th colspan="3">Places disponibles</th>
                    <th>Sélectionner</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Heure</th>
                    <th>Bateau</th>
                    <th>Passager</th>
                    <th>Véhicule Inf 2m</th>
                    <th>Véhicule Sup 2m</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($infos as $info) : ?>
                <tr>
                    <td><?= htmlspecialchars($info['id_travers']) ?></td>
                    <td><?= htmlspecialchars($info['heure_travers']) ?></td>
                    <td><?= htmlspecialchars($info['nom_bateau']) ?></td>
                    <td><?= htmlspecialchars($info['Passager']) ?></td>
                    <td><?= htmlspecialchars($info['véhicule inf2m']) ?></td>
                    <td><?= htmlspecialchars($info['véhicule sup2m']) ?></td>
                    <td>
                        <input type="radio" name="id_travers" value="<?= htmlspecialchars($info['id_travers']) ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Valider la sélection</button>
    </form>

    
    <script src="../JavaScript/ScriptRéserver.js"></script>
<?php
        include '../Fonctions/scriptReserver.php';

        // Récupérer tous les secteurs
        $id_secteur = 2; // À remplacer par la vraie valeur
        $descriptions = getDescTraversées($id_secteur);
        $secteurs = getSecteurs();
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
            <select name="traversee" onchange="selectionnerTraversee(this.value)">
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

    
<script src="../JavaScript/ScriptRéserver.js"></script>
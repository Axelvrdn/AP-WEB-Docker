<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MarieTeam</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            outline: none;
        }

        input:focus {
            border-color: #0056b3;
        }

        /* ✅ Style des jours autorisés */
        .flatpickr-day.allowed {
            color: #003366 !important;  /* Bleu foncé */
            font-weight: bold !important;
            background: #D6EAF8 !important; /* Bleu clair */
            border-radius: 5px;
        }

        /* ❌ Style des jours interdits */
        .flatpickr-day.disabled {
            color: #999 !important; /* Gris foncé */
            background: #EAEAEA !important; /* Gris clair */
            cursor: not-allowed !important;
            opacity: 1 !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <label for="date">📅 Choisissez une date :</label>
    <input type="text" id="date" placeholder="Sélectionnez une date">
    <script src="../JavaScript/scriptTestAgenda.js"></script>

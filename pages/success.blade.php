<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message de Succès</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .message-container {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .message-container .icon {
            font-size: 40px;
            color: #28a745;
            margin-bottom: 10px;
        }
        .close-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .close-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="message-container" id="successMessage">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <p>Succès! Votre réservation a été réalisée avec succès.</p>
        <button class="close-btn" onclick="closeMessage()">Fermer</button>
    </div>

    <script>
        function closeMessage() {
            document.getElementById('successMessage').style.display = 'none';
        }
    </script>
</body>
</html>

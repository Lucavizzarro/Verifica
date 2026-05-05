<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vizzarro_gym");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeutente = $_POST['nomeutente'];
    $password = $_POST['password'];

    // Verifica credenziali
    if ($nomeutente === strtolower($nomeutente) && $password === 'verifica') {
        $_SESSION['user_id'] = $nomeutente;
        header("Location: gestione.php");
        exit();
    } else {
        echo "<div style='color: red;'>Credenziali non valide.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <label>Nome utente:</label>
        <input type="text" name="nomeutente" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Accedi</button>
    </form>
</body>
</html>
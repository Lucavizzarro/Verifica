<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vizzarro_gym");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cognome = $_POST['cognome'];
    $password = $_POST['password'];

    // Verifica se il cognome esiste nella tabella Istruttori e la password è "verifica"
    $query = $conn->prepare("SELECT * FROM Istruttori WHERE cognome = ?");
    $query->bind_param("s", $cognome);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0 && $password === 'verifica') {
        $_SESSION['user_id'] = $cognome; // Salva il cognome nella sessione
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
    <h1>Login</h1>
    <form method="POST">
        <label>Cognome:</label>
        <input type="text" name="cognome" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Accedi</button>
    </form>
</body>
</html>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "palestra");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeutente = $_POST['nomeutente'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM utenti WHERE nomeutente = ? AND password = ?");
    $query->bind_param("ss", $nomeutente, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $nomeutente;
        header("Location: gestione.php");
        exit();
    } else {
        echo "Credenziali non valide.";
    }
}
?>

<form method="POST">
    <label>Nome utente:</label>
    <input type="text" name="nomeutente" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Accedi</button>
</form>
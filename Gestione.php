<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vizzarro_gym");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica autenticazione
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Inserire un nuovo iscritto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuovo_iscritto'])) {
    $id_corso = $_POST['id_corso'];
    $id_membro = $_POST['id_membro'];
    $data_iscrizione = date('Y-m-d');
    $orario_preferito = $_POST['orario_preferito'];

    $query = $conn->prepare("INSERT INTO Iscrizioni_Corsi (id_corso, id_membro, data_iscrizione, orario_preferito) VALUES (?, ?, ?, ?)");
    $query->bind_param("iiss", $id_corso, $id_membro, $data_iscrizione, $orario_preferito);
    $query->execute();

    echo "Iscritto aggiunto con successo!";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione</title>
</head>
<body>
    <h1>Gestione Iscrizioni</h1>
    <form method="POST">
        <label>Corso:</label>
        <select name="id_corso" required>
            <?php
            $result = $conn->query("SELECT id_corso, nome_corso FROM Corsi");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_corso']}'>{$row['nome_corso']}</option>";
            }
            ?>
        </select>
        <label>Membro:</label>
        <select name="id_membro" required>
            <?php
            $result = $conn->query("SELECT id_membro, nome, cognome FROM Membri");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_membro']}'>{$row['nome']} {$row['cognome']}</option>";
            }
            ?>
        </select>
        <label>Orario preferito:</label>
        <input type="time" name="orario_preferito" required>
        <button type="submit" name="nuovo_iscritto">Aggiungi Iscritto</button>
    </form>
</body>
</html>
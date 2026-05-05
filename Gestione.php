<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // se non è loggato, reindirizza alla pagina di login
    header("Location: dashboard.php");
    exit();
}

//logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
// Inserire un nuovo iscritto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuovo_iscritto'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $id_corso = $_POST['id_corso'];

    $query = $conn->prepare("INSERT INTO iscritti (nome, cognome, id_corso) VALUES (?, ?, ?)");
    $query->bind_param("ssi", $nome, $cognome, $id_corso);
    $query->execute();

    echo "Iscritto aggiunto con successo!";
}
?>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <label>Cognome:</label>
    <input type="text" name="cognome" required>
    <label>Corso:</label>
    <select name="id_corso">
        <?php
        $result = $conn->query("SELECT id, nome_corso FROM corsi");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nome_corso']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="nuovo_iscritto">Aggiungi Iscritto</button>
</form>
<?php
$conn = new mysqli("localhost", "root", "", "vizzarro_gym");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Report completo con istruttori in ordine alfabetico
$query = "
    SELECT i.nome AS nome_istruttore, i.cognome AS cognome_istruttore, c.nome_corso, m.nome AS nome_membro, m.cognome AS cognome_membro
    FROM Istruttori AS i
    LEFT JOIN Corsi AS c ON i.id_istruttore = c.id_istruttore
    LEFT JOIN Iscrizioni_Corsi AS iscr ON c.id_corso = iscr.id_corso
    LEFT JOIN Membri AS m ON iscr.id_membro = m.id_membro
    ORDER BY i.cognome, i.nome, c.nome_corso, m.cognome, m.nome
";

$result = $conn->query($query);
$current_istruttore = "";
$current_corso = "";

while ($row = $result->fetch_assoc()) {
    // Mostra l'istruttore solo quando cambia
    $istruttore = "{$row['nome_istruttore']} {$row['cognome_istruttore']}";
    if ($current_istruttore !== $istruttore) {
        echo "<h2>Istruttore: {$istruttore}</h2>";
        $current_istruttore = $istruttore;
        $current_corso = ""; // Resetta il corso per il nuovo istruttore
    }

    // Mostra il corso solo quando cambia
    if ($current_corso !== $row['nome_corso']) {
        echo "<h3>Corso: {$row['nome_corso']}</h3>";
        $current_corso = $row['nome_corso'];
    }

    // Mostra i membri iscritti al corso
    if ($row['nome_membro']) {
        echo "- {$row['nome_membro']} {$row['cognome_membro']}<br>";
    }
}
?>
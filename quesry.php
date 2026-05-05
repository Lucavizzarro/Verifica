<?php
$conn = new mysqli("localhost", "root", "", "vizzarro_gym");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Visualizzare il corso con più iscritti
$query = "
    SELECT i.nome, i.cognome, c.nome_corso, COUNT(*) as num_iscritti
    FROM Iscrizioni_Corsi AS iscr
    JOIN Corsi AS c ON iscr.id_corso = c.id_corso
    JOIN Istruttori AS i ON c.id_istruttore = i.id_istruttore
    GROUP BY c.id_corso
    HAVING num_iscritti >= 5
    ORDER BY num_iscritti DESC
";

$result = $conn->query($query);

// Controlla se ci sono risultati
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "{$row['nome']} {$row['cognome']} - Corso: {$row['nome_corso']} ({$row['num_iscritti']} iscritti)<br>";
    }
} else {
    echo "Nessun corso con almeno 5 iscritti trovato.";
}
?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

if (!isset($_SESSION['utente_id'])) {
    header("Location: /void23/pages/login.php");
    exit;
}

if (!isset($_SESSION['carrello']) || empty($_SESSION['carrello'])) {
    echo "<main class='basic-page'><h1>Carrello vuoto</h1><p>Aggiungi prodotti prima di procedere.</p></main>";
    include("../includes/footer.php");
    exit;
}

$id_utente = $_SESSION['utente_id'];
$totale = 0;

foreach ($_SESSION['carrello'] as $item) {
    $totale += $item['prezzo'] * $item['quantita'];
}

$spedizione = ($totale >= 100) ? 0 : 5;
$totale_finale = $totale + $spedizione;

$sql_ordine = "INSERT INTO ordini (id_utente, totale) VALUES (?, ?)";
$stmt = $conn->prepare($sql_ordine);
$stmt->bind_param("id", $id_utente, $totale_finale);
$stmt->execute();

$id_ordine = $stmt->insert_id;

$sql_dettaglio = "INSERT INTO dettagli_ordini (id_ordine, id_prodotto, quantita, prezzo_unitario) VALUES (?, ?, ?, ?)";
$stmt_dettaglio = $conn->prepare($sql_dettaglio);

foreach ($_SESSION['carrello'] as $item) {
    $id_prodotto = $item['id'];
    $quantita = $item['quantita'];
    $prezzo_unitario = $item['prezzo'];

    $stmt_dettaglio->bind_param("iiid", $id_ordine, $id_prodotto, $quantita, $prezzo_unitario);
    $stmt_dettaglio->execute();
}

$_SESSION['carrello'] = [];
?>

<main class="basic-page">
    <h1>Ordine completato</h1>
    <p>Grazie per il tuo acquisto, <?php echo $_SESSION['utente_nome']; ?>.</p>
    <p>Il tuo ordine è stato salvato correttamente.</p>

    <a href="/void23/pages/profile.php" class="btn-main">Vai al profilo</a>
</main>

<?php include("../includes/footer.php"); ?>
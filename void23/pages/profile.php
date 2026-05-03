<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

if (!isset($_SESSION['utente_id'])) {
    header("Location: /void23/pages/login.php");
    exit;
}

$id_utente = $_SESSION['utente_id'];

$sql_ordini = "SELECT * FROM ordini WHERE id_utente = ? ORDER BY data_ordine DESC";
$stmt_ordini = $conn->prepare($sql_ordini);
$stmt_ordini->bind_param("i", $id_utente);
$stmt_ordini->execute();
$ordini = $stmt_ordini->get_result();
?>

<main class="profile-page">

    <section class="profile-hero" data-aos="fade-up">
        <h1>Profilo</h1>
        <p>Benvenuto, <?php echo $_SESSION['utente_nome']; ?>.</p>
    </section>

    <section class="profile-container">

        <div class="profile-box" data-aos="fade-up">
            <h2>Dati account</h2>
            <p><strong>Nome:</strong> <?php echo $_SESSION['utente_nome']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['utente_email']; ?></p>

            <a href="/void23/pages/logout.php" class="btn-main profile-logout">Logout</a>
        </div>

        <div class="orders-box" data-aos="fade-up" data-aos-delay="150">
            <h2>Storico ordini</h2>

            <?php if ($ordini->num_rows > 0) { ?>

                <?php while ($ordine = $ordini->fetch_assoc()) { ?>

                    <div class="order-card">
                        <div class="order-header">
                            <h3>Ordine #<?php echo $ordine['id']; ?></h3>
                            <p><?php echo $ordine['data_ordine']; ?></p>
                        </div>

                        <p class="order-total">
                            Totale: <?php echo number_format($ordine['totale'], 2); ?>€
                        </p>

                        <div class="order-products">

                            <?php
                            $id_ordine = $ordine['id'];

                            $sql_dettagli = "SELECT dettagli_ordini.*, prodotti.nome 
                                             FROM dettagli_ordini
                                             INNER JOIN prodotti ON dettagli_ordini.id_prodotto = prodotti.id
                                             WHERE dettagli_ordini.id_ordine = ?";

                            $stmt_dettagli = $conn->prepare($sql_dettagli);
                            $stmt_dettagli->bind_param("i", $id_ordine);
                            $stmt_dettagli->execute();
                            $dettagli = $stmt_dettagli->get_result();
                            ?>

                            <?php while ($dettaglio = $dettagli->fetch_assoc()) { ?>
                                <div class="order-product-row">
                                    <span><?php echo $dettaglio['nome']; ?></span>
                                    <span>Quantità: <?php echo $dettaglio['quantita']; ?></span>
                                    <span><?php echo number_format($dettaglio['prezzo_unitario'], 2); ?>€</span>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="no-orders">
                    <p>Non hai ancora effettuato ordini.</p>
                    <a href="/void23/pages/shop.php" class="btn-main">Vai allo shop</a>
                </div>

            <?php } ?>

        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>
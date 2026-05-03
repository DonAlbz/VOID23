<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}

/* AGGIORNA QUANTITÀ */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantita'])) {
    foreach ($_POST['quantita'] as $index => $quantita) {
        $quantita = intval($quantita);

        if ($quantita < 1) {
            $quantita = 1;
        }

        if (isset($_SESSION['carrello'][$index])) {
            $_SESSION['carrello'][$index]['quantita'] = $quantita;
        }
    }
}

/* AGGIUNTA PRODOTTO AL CARRELLO */
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $taglia = isset($_GET['taglia']) ? $_GET['taglia'] : "";
    $quantita = isset($_GET['quantita']) ? intval($_GET['quantita']) : 1;

    if ($quantita < 1) {
        $quantita = 1;
    }

    $sql = "SELECT * FROM prodotti WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();

        $prezzo = $product['prezzo'];
        $sconto = $product['sconto_percentuale'];
        $prezzo_finale = $prezzo;

        if ($sconto > 0) {
            $prezzo_finale = $prezzo - ($prezzo * $sconto / 100);
        }

        $item = [
            "id" => $product['id'],
            "nome" => $product['nome'],
            "immagine" => $product['immagine'],
            "prezzo" => $prezzo_finale,
            "taglia" => $taglia,
            "quantita" => $quantita
        ];

        $_SESSION['carrello'][] = $item;
    }
}

/* RIMOZIONE PRODOTTO */
if (isset($_GET['remove'])) {
    $remove_index = intval($_GET['remove']);

    if (isset($_SESSION['carrello'][$remove_index])) {
        unset($_SESSION['carrello'][$remove_index]);
        $_SESSION['carrello'] = array_values($_SESSION['carrello']);
    }
}

/* SVUOTA CARRELLO */
if (isset($_GET['clear'])) {
    $_SESSION['carrello'] = [];
}
?>

<main class="cart-page">

    <section class="cart-hero">
        <h1 data-aos="fade-up">Carrello</h1>
        <p data-aos="fade-up" data-aos-delay="100">Controlla i prodotti selezionati.</p>
    </section>

    <section class="cart-container" data-aos="fade-up">

        <?php if (empty($_SESSION['carrello'])) { ?>

            <div class="empty-cart">
                <h2>Il carrello è vuoto</h2>
                <p>Aggiungi qualche prodotto dalla collezione VOID23.</p>
                <a href="/void23/pages/shop.php" class="btn-main">Vai allo shop</a>
            </div>

        <?php } else { ?>

        <div class="cart-container">
<form method="POST" action="/void23/pages/cart.php" class="cart-items">
                <?php
                $totale = 0;

                foreach ($_SESSION['carrello'] as $index => $item) {
                    $subtotale = $item['prezzo'] * $item['quantita'];
                    $totale += $subtotale;
                ?>

                    <div class="cart-item">
                        <div class="cart-item-image">
                            <img src="/void23/images/<?php echo $item['immagine']; ?>" alt="<?php echo $item['nome']; ?>">
                        </div>

                        <div class="cart-item-info">
                            <h3><?php echo $item['nome']; ?></h3>
                            <p>Taglia: <?php echo $item['taglia']; ?></p>
<label>Quantità:</label>

<div class="quantity-control">
    <button type="button" class="qty-btn" onclick="changeQty(this, -1)">−</button>

    <input 
        type="text" 
        name="quantita[<?php echo $index; ?>]" 
        value="<?php echo $item['quantita']; ?>" 
        class="cart-quantity-input"
        readonly
    >

    <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
</div>                            <p>Prezzo: <?php echo number_format($item['prezzo'], 2); ?>€</p>
                            <p>Subtotale: <?php echo number_format($subtotale, 2); ?>€</p>

                            <a href="/void23/pages/cart.php?remove=<?php echo $index; ?>" class="remove-link">Rimuovi</a>
                        </div>
                    </div>

                <?php } ?>

            </div>

            <?php
            $spedizione = 5.00;

            if ($totale >= 100) {
                $spedizione = 0;
            }

            $totale_finale = $totale + $spedizione;
            ?>

            <div class="cart-summary">
    <h2>Riepilogo</h2>

    <div class="summary-row">
        <span>Totale prodotti</span>
        <span><?php echo number_format($totale, 2); ?>€</span>
    </div>

    <div class="summary-row">
        <span>Spedizione</span>
        <span>
            <?php
            if ($spedizione == 0) {
                echo "Gratis";
            } else {
                echo number_format($spedizione, 2) . "€";
            }
            ?>
        </span>
    </div>

    <?php if ($totale >= 100) { ?>
        <p class="free-shipping">Spedizione gratuita applicata automaticamente.</p>
    <?php } else { ?>
        <p class="free-shipping">Spedizione gratis sopra i 100€.</p>
    <?php } ?>

    <div class="summary-row total-row">
        <span>Totale finale</span>
        <span><?php echo number_format($totale_finale, 2); ?>€</span>
    </div>

    <a href="/void23/pages/checkout.php" class="checkout-btn">Procedi all’ordine</a>
    <a href="/void23/pages/cart.php?clear=1" class="clear-cart">Svuota carrello</a>
</div>

        <?php } ?>
        </form>

    </section>

</main>

<script>
function changeQty(button, amount) {
    const control = button.closest(".quantity-control");
    const input = control.querySelector(".cart-quantity-input");

    let value = parseInt(input.value);

    if (isNaN(value)) {
        value = 1;
    }

    value = value + amount;

    if (value < 1) {
        value = 1;
    }

    input.value = value;

    const form = button.closest("form");
    form.submit();
}
</script>

<?php include("../includes/footer.php"); ?>
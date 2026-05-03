<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

if (!isset($_GET['id'])) {
    echo "<main class='basic-page'><h1>Prodotto non trovato</h1></main>";
    include("../includes/footer.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT prodotti.*, categorie.nome_categoria 
        FROM prodotti
        INNER JOIN categorie ON prodotti.id_categoria = categorie.id
        WHERE prodotti.id = $id";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<main class='basic-page'><h1>Prodotto non trovato</h1></main>";
    include("../includes/footer.php");
    exit;
}

$product = $result->fetch_assoc();

$prezzo = $product['prezzo'];
$sconto = $product['sconto_percentuale'];
$prezzo_finale = $prezzo;

if ($sconto > 0) {
    $prezzo_finale = $prezzo - ($prezzo * $sconto / 100);
}
?>

<main class="product-page">

    <section class="product-detail" data-aos="fade-up">

        <div class="product-detail-image">
            <?php if (!empty($product['badge'])) { ?>
                <span class="product-badge"><?php echo $product['badge']; ?></span>
            <?php } ?>

            <img src="/void23/images/<?php echo $product['immagine']; ?>" alt="<?php echo $product['nome']; ?>">
        </div>

        <div class="product-detail-info">
            <p class="product-category"><?php echo $product['nome_categoria']; ?></p>
            <h1><?php echo $product['nome']; ?></h1>

            <?php if ($sconto > 0) { ?>
                <p class="price product-detail-price">
                    <span class="old-price"><?php echo number_format($prezzo, 2); ?>€</span>
                    <span class="new-price"><?php echo number_format($prezzo_finale, 2); ?>€</span>
                </p>
                <p class="discount-text">Sconto automatico del <?php echo $sconto; ?>%</p>
            <?php } else { ?>
                <p class="price product-detail-price">
                    <span class="new-price"><?php echo number_format($prezzo, 2); ?>€</span>
                </p>
            <?php } ?>

            <p class="product-description">
                <?php echo $product['descrizione']; ?>
            </p>

            <form action="/void23/pages/cart.php" method="GET" class="product-form">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                <label>Taglia</label>
                <select name="taglia" required>
    <option value="">Seleziona taglia</option>

    <?php if ($product['nome_categoria'] == "Shoes") { ?>
        <option value="38">38</option>
        <option value="39">39</option>
        <option value="40">40</option>
        <option value="41">41</option>
        <option value="42">42</option>
        <option value="43">43</option>
        <option value="44">44</option>
        <option value="45">45</option>
    <?php } else { ?>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
    <?php } ?>
</select>

                <label>Quantità</label>
                <input type="number" name="quantita" value="1" min="1" max="10">

                <button type="submit">Aggiungi al carrello</button>
            </form>
        </div>

    </section>

</main>

<?php include("../includes/footer.php"); ?>
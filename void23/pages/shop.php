<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : "";

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : "";
$ricerca = isset($_GET['ricerca']) ? $_GET['ricerca'] : "";

$prezzo_min = isset($_GET['prezzo_min']) ? $_GET['prezzo_min'] : "";
$prezzo_max = isset($_GET['prezzo_max']) ? $_GET['prezzo_max'] : "";

$sql = "SELECT prodotti.*, categorie.nome_categoria 
        FROM prodotti
        INNER JOIN categorie ON prodotti.id_categoria = categorie.id
        WHERE 1";

if ($categoria != "") {
    $sql .= " AND categorie.nome_categoria = '" . $conn->real_escape_string($categoria) . "'";
}

if ($ricerca != "") {
    $ricerca_sicura = $conn->real_escape_string($ricerca);
    $sql .= " AND prodotti.nome LIKE '%$ricerca_sicura%'";
}

if ($prezzo_min != "") {
    $prezzo_min_sicuro = floatval($prezzo_min);
    $sql .= " AND prodotti.prezzo >= $prezzo_min_sicuro";
}

if ($prezzo_max != "") {
    $prezzo_max_sicuro = floatval($prezzo_max);
    $sql .= " AND prodotti.prezzo <= $prezzo_max_sicuro";
}

$result = $conn->query($sql);
?>

<main class="shop-page">

    <section class="shop-hero">
        <h1 data-aos="fade-up">Shop</h1>
        <p data-aos="fade-up" data-aos-delay="100">Explore the VOID23 collection.</p>
    </section>

<section class="search-section" data-aos="fade-up">
    <form method="GET" action="/void23/pages/shop.php" class="search-form">
        <input 
            type="text" 
            name="ricerca" 
            placeholder="Cerca prodotto..." 
            value="<?php echo htmlspecialchars($ricerca); ?>"
        >

        <input 
            type="number" 
            name="prezzo_min" 
            placeholder="Prezzo min" 
            value="<?php echo htmlspecialchars($prezzo_min); ?>"
            min="0"
        >

        <input 
            type="number" 
            name="prezzo_max" 
            placeholder="Prezzo max" 
            value="<?php echo htmlspecialchars($prezzo_max); ?>"
            min="0"
        >

        <button type="submit">Filtra</button>
    </form>
</section>
    <section class="shop-filters" data-aos="fade-up">
        <a href="/void23/pages/shop.php">All</a>
        <a href="/void23/pages/shop.php?categoria=Shoes">Shoes</a>
        <a href="/void23/pages/shop.php?categoria=T-Shirt">T-Shirt</a>
        <a href="/void23/pages/shop.php?categoria=Hoodie">Hoodie</a>
        <a href="/void23/pages/shop.php?categoria=Cap">Cap</a>
        <a href="/void23/pages/shop.php?categoria=Pants">Pants</a>
    </section>

    <section class="products-grid">

        <?php if ($result->num_rows > 0) { ?>

            <?php while($row = $result->fetch_assoc()) { ?>

                <?php
                $prezzo = $row['prezzo'];
                $sconto = $row['sconto_percentuale'];
                $prezzo_finale = $prezzo;

                if ($sconto > 0) {
                    $prezzo_finale = $prezzo - ($prezzo * $sconto / 100);
                }
                ?>

                <div class="product-card" data-aos="fade-up">
                    
                    <?php if (!empty($row['badge'])) { ?>
                        <span class="product-badge"><?php echo $row['badge']; ?></span>
                    <?php } ?>

                    <div class="product-image">
                        <img src="/void23/images/<?php echo $row['immagine']; ?>" alt="<?php echo $row['nome']; ?>">
                    </div>

                    <div class="product-info">
                        <p class="product-category"><?php echo $row['nome_categoria']; ?></p>
                        <h3><?php echo $row['nome']; ?></h3>

                        <?php if ($sconto > 0) { ?>
                            <p class="price">
                                <span class="old-price"><?php echo number_format($prezzo, 2); ?>€</span>
                                <span class="new-price"><?php echo number_format($prezzo_finale, 2); ?>€</span>
                            </p>
                        <?php } else { ?>
                            <p class="price">
                                <span class="new-price"><?php echo number_format($prezzo, 2); ?>€</span>
                            </p>
                        <?php } ?>

                        <a href="/void23/pages/product.php?id=<?php echo $row['id']; ?>" class="btn-product">Vedi prodotto</a>
                    </div>
                </div>

            <?php } ?>

        <?php } else { ?>

            <p class="no-products">Nessun prodotto trovato.</p>

        <?php } ?>

    </section>

</main>

<?php include("../includes/footer.php"); ?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($nome == "" || $email == "" || $password == "") {
        $messaggio = "Compila tutti i campi.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utenti (nome, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $password_hash);

        if ($stmt->execute()) {
            $messaggio = "Registrazione completata. Ora puoi accedere.";
        } else {
            if ($conn->errno == 1062) {
                $messaggio = "Email già registrata.";
            } else {
                $messaggio = "Errore durante la registrazione.";
            }
        }
    }
}
?>

<main class="basic-page">
    <h1>Registrazione</h1>
    <p>Crea il tuo account VOID23.</p>

    <?php if ($messaggio != "") { ?>
        <p class="message-box"><?php echo $messaggio; ?></p>
    <?php } ?>

    <form class="login-form" method="POST" action="">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Registrati</button>
    </form>

    <p class="form-link">
        Hai già un account? <a href="/void23/pages/login.php">Accedi</a>
    </p>
</main>

<?php include("../includes/footer.php"); ?>
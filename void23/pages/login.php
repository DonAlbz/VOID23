<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../config/database.php");
include("../includes/header.php");

$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email == "" || $password == "") {
        $messaggio = "Compila tutti i campi.";
    } else {
        $sql = "SELECT * FROM utenti WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $utente = $result->fetch_assoc();

            if (password_verify($password, $utente['password'])) {
                $_SESSION['utente_id'] = $utente['id'];
                $_SESSION['utente_nome'] = $utente['nome'];
                $_SESSION['utente_email'] = $utente['email'];

                header("Location: /void23/pages/profile.php");
                exit;
            } else {
                $messaggio = "Password non corretta.";
            }
        } else {
            $messaggio = "Email non trovata.";
        }
    }
}
?>

<main class="basic-page">
    <h1>Login</h1>
    <p>Accedi al tuo account VOID23.</p>

    <?php if ($messaggio != "") { ?>
        <p class="message-box"><?php echo $messaggio; ?></p>
    <?php } ?>

    <form class="login-form" method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Accedi</button>
    </form>

    <p class="form-link">
        Non hai un account? <a href="/void23/pages/register.php">Registrati</a>
    </p>
</main>

<?php include("../includes/footer.php"); ?>
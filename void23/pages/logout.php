<?php
session_start();
session_unset();
session_destroy();

header("Location: /void23/index.php");
exit;
?>
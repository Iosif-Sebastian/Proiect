<?php
// Configurare DB
$host = 'mysql';
$port = 3306;
$db = 'studenti';
$user = 'user';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    die("Eroare conectare DB: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['termeni'])) {
        die("Trebuie să accepți termenii și condițiile.");
    }

    $nume = $_POST['nume'] ?? '';
    $prenume = $_POST['prenume'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmapassword = $_POST['confirmapassword'] ?? '';

    if (!$nume || !$prenume || !$email || !$password || !$confirmapassword) {
        die("Toate câmpurile sunt obligatorii.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalid.");
    }

    if ($password !== $confirmapassword) {
        die("Parolele nu coincid.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, prenume, email, password) VALUES (:nume, :prenume, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nume' => $nume,
        ':prenume' => $prenume,
        ':email' => $email,
        ':password' => $hashed_password
    ]);

    echo "Cont creat cu succes!";
}
?>

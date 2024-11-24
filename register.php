<?php
// Povezivanje s bazom podataka
$host = "localhost";
$username = "root"; // Promijenite ako koristite drugo korisničko ime
$password = ""; // Promijenite ako koristite lozinku
$database = "vjezba16";

// Spajanje na bazu
$conn = new mysqli($host, $username, $password, $database);

// Provjera povezanosti
if ($conn->connect_error) {
    die("Pogreška pri povezivanju s bazom: " . $conn->connect_error);
}

$poruka = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // SQL upit za unos podataka
    $sql = "INSERT INTO users (name, lastname, email, username, password)
            VALUES ('$name', '$lastname', '$email', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        $poruka = "Registracija uspješna!";
    } else {
        $poruka = "Pogreška pri registraciji: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija korisnika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input, button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registracija korisnika</h1>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Ime" required>
            <input type="text" name="lastname" placeholder="Prezime" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Korisničko ime" required>
            <input type="password" name="password" placeholder="Lozinka" required>
            <button type="submit">Registriraj se</button>
        </form>
        <?php if ($poruka): ?>
            <div class="message <?php echo strpos($poruka, 'uspješna') !== false ? 'success' : 'error'; ?>">
                <?php echo $poruka; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

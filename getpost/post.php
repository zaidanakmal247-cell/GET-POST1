<!DOCTYPE html>
<html>
<head>
    <title>Form Sederhana</title>
</head>
<body>

    <h2>Form Input</h2>
    <form method="post" action="">
        Nama: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        <input type="submit" value="Kirim">
    </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);

    echo "<h3>Data yang Dikirim:</h3>";
    echo "Nama: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
}
?>

</body>
</html>
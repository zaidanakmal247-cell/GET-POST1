<!DOCTYPE html>
<html>
<head>
<title>Form dengan Validasi</title>
</head>
<body>

<h2>Form Input</h2>

<form method="post" action="">

Nama:
<input type="text" name="name" value="<?php echo $name; ?>">
<span style="color:red;">* <?php echo $nameErr; ?></span>
<br><br>

Email:
<input type="text" name="email" value="<?php echo $email; ?>">
<span style="color:red;">* <?php echo $emailErr; ?></span>
<br><br>

Password:
<input type="password" name="password">
<span style="color:red;">* <?php echo $passwordErr; ?></span>
<br><br>

<input type="submit" value="submit">

</form>

</body>
</html>
<?php
require 'koneksi.php';
session_start();

if (!isset($_SESSION['nama']) || $_SESSION['nama'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_GET['id'];
$stmt_get = $conn->prepare("SELECT nama FROM auth WHERE id = ?");
$stmt_get->bind_param("i", $user_id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['update'])) {
        $nama_baru = $_POST['nama'];
        $password_baru = $_POST['password'];

        $password_hashed = password_hash($password_baru, PASSWORD_DEFAULT);

        $stmt_update = $conn->prepare("UPDATE auth SET nama = ?, pw = ? WHERE id = ?");
        $stmt_update->bind_param("ssi", $nama_baru, $password_hashed, $user_id);
        $stmt_update->execute();
        $stmt_update->close();
        header("Location: dashboard.php");
        exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
</head>
<body>
    <h1>Edit Data Pengguna</h1>
    <hr>
    
    <form method="POST" action="">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required><br><br>
        
        <label for="password">Password Baru:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit" name="update" onclick="return confirm('Yakin nih mau diubah?')">Update</button>
        <button type="button" onclick="window.location.href='dashboard.php'">Batal</button>
    </form>
</body>
</html>
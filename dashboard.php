<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<?php
require 'koneksi.php';
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: Pert12.php");
    exit();
}

if (isset($_POST['delete'])) {
    $user_id = $_POST['id'];
    $stmt_delete = $conn->prepare("DELETE FROM auth WHERE id = ?");
    $stmt_delete->bind_param("i", $user_id);
    $stmt_delete->execute();
    $stmt_delete->close();
}

if (isset($_POST['edit'])) {
    $user_id = $_POST['id'];
    header("Location: edit.php?id=". $user_id);
    exit();
}
?>
<body>
    <h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h1>
    <form method="POST" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
    <hr><?php 
    if ($_SESSION['nama'] === 'admin') : 
    ?>
        <h3>Menu Admin: Kelola Pengguna</h3>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            <?php
            $query = mysqli_query($conn, "SELECT id, nama FROM auth");
            while ($data = mysqli_fetch_array($query)) :
            ?>
            <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <button type="submit" name="edit">Edit</button>
                        <button type="submit" name="delete">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Yahahaha gada apa apa disini</p>
    <?php endif; ?>
</body>
</html>
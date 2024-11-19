<<<<<<< HEAD
<?php
$password = 'admin'; // Ganti dengan password sebenarnya
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Password Ter-hash: " . $hashedPassword;
?>

semua passwordnya adalah admin
=======
<?php
$password = 'admin'; // Ganti dengan password sebenarnya
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Password Ter-hash: " . $hashedPassword;
?>

semua passwordnya adalah admin


// Jika session 'success' ada, tampilkan pesan SweetAlert
if (isset($_SESSION['success']) && $_SESSION['success']) {
  echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil diperbarui! 🎉',
                    icon: 'success',
                    confirmButtonText: 'Oke'
                });
            });
          </script>";
  // Hapus session 'success' agar tidak tampil lagi setelah refresh
  unset($_SESSION['success']);
}
>>>>>>> 8794dfa5ca3bdc204900f670156ef4a33b0cc6d6

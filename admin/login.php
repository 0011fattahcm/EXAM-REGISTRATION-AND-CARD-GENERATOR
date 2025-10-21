<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'kartu_peserta');

$error_message = ""; // Variable untuk menyimpan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = "Username atau Password salah!"; // Set pesan kesalahan
        }
    } else {
        $error_message = "Username atau Password salah!"; // Set pesan kesalahan
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
        // Function to hide the error message after 5 seconds
        function hideErrorMessage() {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
        }
    </script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen" onload="hideErrorMessage()">
    <div id="date-time" class="fixed top-10 right-0 text-gray-800 text-lg pr-4"></div>

    <div class="text-center">

        <!-- Display error message if it exists -->
        <?php if (!empty($error_message)): ?>
            <div id="error-message" class="mb-4 text-red-500 text-center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-gray-800 text-white rounded-lg p-8 w-80 mx-auto shadow-lg">
            <h2 class="text-2xl font-bold mb-6">LOGIN</h2>
            <h2 class="text-2xl font-bold mb-6">JECA CARD GENERATOR</h2>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-left text-gray-300 mb-2">Username</label>
                    <div class="relative">
                        <input type="text" name="username" id="username" class="w-full px-4 py-2 bg-gray-700 border-b border-gray-600 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="username" required>
                        <i class="fas fa-user absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-left text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-gray-700 border-b border-gray-600 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="password" required>
                        <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-200">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
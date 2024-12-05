<?php
session_start();
include 'connection.php';

// Check if user is logged in and retrieve the current user ID from session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query to get the number of items in the cart for the current user
    $query = "SELECT COUNT(*) as cart_count 
          FROM tbl_cart_products cp
          JOIN tbl_cart c ON cp.cart_id = c.cart_id
          WHERE cp.user_id = ? AND (c.status < 2 OR c.status IS NULL)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($cart_count);
    $stmt->fetch();
    $stmt->close();
} else {
    // If user is not logged in, set cart count to 0
    $cart_count = 0;
}
?>

<!-- Header Start -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="assets/Arsenal_FC.svg.png" alt="Logo" class="d-inline-block align-top" style="width: 80px;">
            </a>
            <!-- Navbar Toggle for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="d-flex justify-content-center w-100">
                    <?php if (basename($_SERVER['PHP_SELF']) == 'carousel.php'): ?>
                        <?php foreach ($categories as $category): ?>
                            <?php if (!empty($category['img_path'])): ?>
                                <a href="#category-<?php echo $category['cat_id']; ?>" class="btn btn-category navbar-btn mx-2">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carousel.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="cart.php" title="cart">
                            <i class="bi bi-cart me-2"></i>
                            <span class="badge bg-primary"><?php echo $cart_count; ?></span> <!-- Display cart count -->
                        </a>
                    </li>

                    <!-- Login Button -->
                    <li class="nav-item">
                        <?php if (isset($_SESSION['username1'])): ?>
                            <!-- If logged in, display the profile or logout link -->
                            <a class="nav-link text-white" href="Users/logout_User.php">Logout</a>
                        <?php else: ?>
                            <!-- If not logged in, display the login button -->
                            <a class="nav-link text-white" href="Users/login_User.php">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- Header End -->

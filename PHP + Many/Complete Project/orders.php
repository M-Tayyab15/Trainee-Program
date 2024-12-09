<?php
session_start();
if (isset($_SESSION['username1'])) {
    header('Location: Users/index_User.php');
    exit;
}

if (!isset($_SESSION['username'])) {
    header('Location: login2.php');
    exit;
}

include 'connection.php';
include 'layout/header.php';
include 'layout/sidebar.php';

$link = 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'; // Bootstrap CDN
?>

<link rel="stylesheet" href="<?php echo $link; ?>">

<style>
    body {
        background-color: #f8f9fa;
    }

    .table-container {
        transition: margin-left 0.3s;
        margin-top: 6%;
        margin-left: 20px;
        margin-right: 20px;
    }

    .table {
        margin: 20px 0;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table th {
        background-color: #007bff;
        color: white;
        text-align: center;
    }

    .table td {
        background-color: white;
        text-align: center;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-footer .btn {
        margin: 0 5px;
    }

    .modal-body {
        border: 1px solid #007bff;
        border-radius: 0.5rem;
    }

    .row {
        padding: 10px;
    }

    .border-bottom {
        border-bottom: 1px solid #007bff;
    }

    .border-right {
        border-right: 1px solid #007bff;
    }

    strong {
        color: #007bff;
    }

    .table td {
        background-color: white;
        text-align: center;
    }

    .choti-width {
        width: 50px;
    }
</style>

<?php
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$idQuery = isset($_GET['id']) ? trim($_GET['id']) : '';
$emailQuery = isset($_GET['email']) ? trim($_GET['email']) : '';

$sql = "SELECT 
            COUNT(*) OVER() AS total_records,
            c.cart_id,
            c.user_id,
            c.payment_mode,
            c.status,
            c.total_amount,
            c.created_on,
            u.email
        FROM 
            tbl_cart c
        LEFT JOIN 
            tbl_user_info u ON c.user_id = u.user_id
        WHERE 
            (c.cart_id LIKE '%$idQuery%' AND u.email LIKE '%$emailQuery%')
        ORDER BY 
            c.cart_id
        LIMIT $limit OFFSET $offset;";

$result = $conn->query($sql);

// Get total records from the first row
$totalRecords = $result->num_rows > 0 ? $result->fetch_assoc()['total_records'] : 0;
$totalPages = ceil($totalRecords / $limit);
$result->data_seek(0);
?>

<div class="w3-main">
    <div class="table-container">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div id='message' class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        } elseif (isset($_SESSION['error'])) {
            echo "<div id='message' class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="d-flex">
                            <input type="text" name="id" value="<?php echo htmlspecialchars($idQuery); ?>" placeholder="Order ID" class="form-control me-2">
                            <input type="text" name="email" value="<?php echo htmlspecialchars($emailQuery); ?>" placeholder="Email" class="form-control me-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button class="btn btn-outline-secondary ms-2" style="margin-left: 5px;">
                                <a href="orders.php" class="text-decoration-none text-reset">Reset</a>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

       <!-- Orders Table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Email</th>
            <th>Status</th>
            <th>Total Amount</th>
            <th>Payment Mode</th> <!-- Add Payment Mode column here -->
            <th>Created On</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['cart_id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <?php 
                        if ($row['status'] == 1 || $row['status'] == 'NULL') {
                            // Handle the case where status is 1 or null
                            $status = '1_or_null';
                        }
                        switch ($row['status']) {
                            case '1_or_null':
                                echo "<span class='badge badge-warning'>Pending</span>";
                                break;
                            case '2':
                                echo "<span class='badge badge-primary'>In progress</span>";
                                break;
                            case '3':
                                echo "<span class='badge badge-success'>Completed</span>";
                                break;
                            default:
                                echo "<span class='badge badge-warning'>Pending</span>";
                                break;
                        }
                        ?>
                    </td>
                    <td><?php echo number_format($row['total_amount'], 2); ?></td>
                    <td>
                        <?php 
                        // Directly display the payment mode (either "PayPal" or "COD")
                        echo htmlspecialchars($row['payment_mode']);
                        ?>
                    </td>
                    <td><?php echo date("d-m-Y", strtotime($row['created_on'])); ?></td>
                    <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?php echo $row['cart_id']; ?>" onclick="loadOrderDetails(<?php echo $row['cart_id']; ?>)">Details</button></td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="detailsModal<?php echo $row['cart_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel<?php echo $row['cart_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalLabel<?php echo $row['cart_id']; ?>">Order Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modalContent<?php echo $row['cart_id']; ?>">
                                <!-- Details will be loaded via AJAX -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No Orders Found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


        <!-- Pagination -->
       <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>&id=<?php echo urlencode($idQuery); ?>&email=<?php echo urlencode($emailQuery); ?>" aria-label="Previous">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&id=<?php echo urlencode($idQuery); ?>&email=<?php echo urlencode($emailQuery); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo min($totalPages, $page + 1); ?>&id=<?php echo urlencode($idQuery); ?>&email=<?php echo urlencode($emailQuery); ?>" aria-label="Next">Next</a>
        </li>
    </ul>
</nav>
    </div>
</div>

<script>
// Function to load order details into the modal using AJAX
function loadOrderDetails(cart_id) {
    let modalContent = document.getElementById('modalContent' + cart_id);
    
    // Make an AJAX request to fetch the order details
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'order_details.php?cart_id=' + cart_id, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            modalContent.innerHTML = xhr.responseText;
        } else {
            modalContent.innerHTML = '<p>Error loading details.</p>';
        }
    };
    xhr.send();
}
</script>

<?php
include 'layout/footer.php';
?>

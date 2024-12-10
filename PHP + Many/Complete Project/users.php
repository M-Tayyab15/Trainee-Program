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
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
    .choti-width
    {
        width: 50px;
    }
</style>

<?php
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 5;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

$firstNameQuery = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$lastNameQuery = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$emailQuery = isset($_POST['email']) ? trim($_POST['email']) : '';



$sql = "SELECT 
    COUNT(*) OVER() AS total_records,
    p.profile_id,
    p.firstname,
    p.lastname,
    p.phone_number,
    p.address,
    p.country,
    p.state,
    p.city,
    p.age,
    p.gender,
    p.profession,
    p.qualification,
    p.institute,
    p.comments,
    u.user_id,
    u.email,
    u.password,
    u.created_on,
    p.picture,
    f.filename AS attachment_name,
    f.folder AS attachment_folder
FROM 
    tbl_profile p
RIGHT JOIN 
    tbl_user_info u ON p.user_id = u.user_id
LEFT JOIN 
    tbl_file f ON u.user_id = f.user_id AND f.status = 1
WHERE 
    u.status = 1 AND (
        p.firstname LIKE '%$firstNameQuery%' AND 
        p.lastname LIKE '%$lastNameQuery%' AND 
        u.email LIKE '%$emailQuery%'
    )
ORDER BY u.user_id
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
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($firstNameQuery); ?>" placeholder="First Name" class="form-control me-2">
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars(($lastNameQuery)); ?>" placeholder="Last Name" class="form-control me-2">
                            <input type="text" name="email" value="<?php echo htmlspecialchars($emailQuery); ?>" placeholder="Email" class="form-control me-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button class="btn btn-outline-secondary ms-2" style="margin-left: 5px;">
                                <a href="users.php" class="text-decoration-none text-reset">Reset</a>
                            </button>
                        </form>
                    </div>
                    <div>
                        <a href="forms.php" class="btn btn-primary">Add User</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Created On</th>
                    <th>Details</th>
                    <th>Action</th>
                    <th>Attachments</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo ($row['user_id']); ?></td>
                            <td class="choti-width"><?php echo ($row['firstname']) . ' ' . ($row['lastname']); ?></td>
                            <td class="choti-width"><?php echo ($row['email']); ?></td>
                            <td><?php echo sha1($row['password']); ?></td>
                            <td><?php echo ($row['created_on']); ?></td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailsModal<?php echo $row['user_id']; ?>">Details</button>
                            </td>
                            <td>
                                <a href="edit_user_form.php?id=<?php echo $row['user_id']; ?>" class="btn btn-warning">Edit</a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $row['user_id']; ?>)">Delete</button>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#uploadModal<?php echo $row['user_id']; ?>">Upload</button>
                            </td>

                            <td>
                                <?php if (!empty($row['attachment_folder'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['attachment_folder'].$row['attachment_name']); ?>" class="btn btn-warning" download>Download</a>
                                <?php else: ?>
                                    <span>No file exists</span>
                                <?php endif; ?>
                            </td>
                           
                        </tr>

                        <!-- Details Modal -->
                        <div class="modal fade" id="detailsModal<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">User Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row border-bottom">
                                            <div class="col-md-6 border-right">
                                                <p><strong>Name:</strong> <?php echo ($row['firstname']) . ' ' . ($row['lastname']); ?></p>
                                                <p><strong>Email:</strong> <?php echo ($row['email']); ?></p>
                                                <p><strong>Phone Number:</strong> <?php echo ($row['phone_number']); ?></p>
                                                <p><strong>Address:</strong> <?php echo ($row['address']); ?></p>
                                                <p><strong>Country:</strong> <?php echo ($row['country']); ?></p>
                                                <p><strong>State:</strong> <?php echo ($row['state']); ?></p>
                                                <p><strong>City:</strong> <?php echo ($row['city']); ?></p>
                                                <p><strong>Age:</strong> <?php echo ($row['age']); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Gender:</strong> <?php echo ($row['gender']); ?></p>
                                                <p><strong>Profession:</strong> <?php echo ($row['profession']); ?></p>
                                                <p><strong>Qualification:</strong> <?php echo ($row['qualification']); ?></p>
                                                <p><strong>Institute:</strong> <?php echo ($row['institute']); ?></p>
                                                <p><strong>User ID:</strong> <?php echo ($row['user_id']); ?></p>
                                                <p><strong>Password:</strong> <?php echo ($row['password']); ?></p>
                                                <p><strong>Picture:</strong> <?php echo ($row['picture']); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="comments">Comments:</label>
                                            <textarea class="form-control" id="comments" rows="3" readonly><?php echo ($row['comments']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Modal -->
                        <div class="modal fade" id="uploadModal<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Upload File for <?php echo $row['firstname'] . ' ' . $row['lastname']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="upload_user_file.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                            <div class="form-group">
                                                <label for="filename">File Name</label>
                                                <input type="text" name="filename" class="form-control" placeholder="Enter file name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="file">Choose File</label>
                                                <input type="file" name="file" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="d-flex">
                <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($firstNameQuery); ?>">
                <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($lastNameQuery); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($emailQuery); ?>">
                <nav aria-label="...">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <button type="submit" name="page" value="<?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </button>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        var messageDiv = document.getElementById('message');
        if (messageDiv) {
            messageDiv.style.transition = 'opacity 0.5s';
            messageDiv.style.opacity = '0';
            setTimeout(function() {
                messageDiv.style.display = 'none';
            }, 500);
        }
    }, 3000);

    function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "delete_user.php?id=" + userId;
        }
    }
</script>

<script src="./assets/plugins/chartjs/Chart.min.js"></script>
<script src="./assets/plugins/chartjs/dashboard.js"></script>
<?php include 'layout/footer.php'; ?>
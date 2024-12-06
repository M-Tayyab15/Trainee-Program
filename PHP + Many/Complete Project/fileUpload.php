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
?>
<!DOCTYPE html>
<html>

<head>
    <title>File Upload Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            width: 50%;
            margin: 130px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            height: 40px;
            margin-bottom: 10px; /* Adjusted margin */
            padding: 10px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #008cff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: blue;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <?php include 'layout/header.php'; ?>
    <?php include 'layout/sidebar.php'; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data">
    <?php if (isset($_SESSION['errorMsg'])) { ?>
            <p style="color: red;"><?php echo $_SESSION['errorMsg']; ?></p>
            <?php unset($_SESSION['errorMsg']); ?>
        <?php } ?>
        <label for="filename">File Name:</label>
        <input type="text" id="filename" name="filename">
        <?php if (isset($_SESSION['errorMsgFilename'])) { ?>
            <p class="error"><?php echo $_SESSION['errorMsgFilename']; ?></p>
            <?php unset($_SESSION['errorMsgFilename']); ?>
        <?php } ?>

        <label for="fileupload">File Upload:</label>
        <input type="file" id="fileupload" name="fileupload">
        <?php if (isset($_SESSION['errorMsgFile'])) { ?>
            <p class="error"><?php echo $_SESSION['errorMsgFile']; ?></p>
            <?php unset($_SESSION['errorMsgFile']); ?>
        <?php } ?>

        <input type="submit" value="Upload File">
    </form>

    <script src="./assets/plugins/chartjs/Chart.min.js"></script>
    <script src="./assets/plugins/chartjs/dashboard.js"></script>
    <?php include 'layout/footer.php'; ?>
</body>

</html>
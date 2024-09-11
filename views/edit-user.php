<?php
    session_start();

    require "../classes/User.php";

    # Create an object
    $user_obj = new User;
    $user = $user_obj->getUser($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <!-- Bootstrap CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--CSS Link-->
     <link rel="stylesheet" href="..assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
                <form action="../actions/logout-action.php" class="d-flex ms-2">
                    <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="row justify-content-center gx-0">
        <div class="col-4">
            <h2 class="text-center mb-4">EDIT USER</h2>

            <form action="../actions/update-action.php" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center mb-3">
                    <div class="col-6">
                        <?php
                        
                            if ($user['photo']) {
                        ?>
                            <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto edit-photo" style="width: 7em; height: 7em; object-fit: cover;">
                        <?php
                            }else {
                        ?>
                            <i class="fa-solid fa-user text-secondary d-block text-center edit-icon" style="font-size: 7em"></i>

                        <?php
                            }
                        ?>

                        <input type="file" name="photo" class="form-control mt-2" accept="image/*">

                    </div>
                </div>
                <div class="mb-3">
                    <label for="first-name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first-name" class="form-control" value="<?= $user['first_name'] ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="last-name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last-name" class="form-control" value="<?= $user['last_name'] ?>" required>
                </div>
                <div class="mb-4">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" name="username" id="username" class="form-control fw-bold" maxlength="15" value="<?= $user['username'] ?>" required>
                </div>
                <div class="text-end">
                    <a href="dashboard.php" class="btn btn-secondary btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-warning btn-sm px-5">Save</button>
                </div>
            </form>
        </div>
    </main>


</body>
</html>




















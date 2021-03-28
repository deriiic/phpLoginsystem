<?php
include ("includes/header.php");
?>
<body class="bg-light">

<a href="admin/register.php" class="position-absolute">
    <i class="fas fa-user-plus fa-2x btn btn-primary m-2 shadow rounded"></i>
</a>

<div class="container d-flex justify-content-center vertical-center">
    <div class="row col-12">
        <div class="col-12 col-md-6 mx-auto">

                <form class="bg-white p-5 shadow rounded" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

                    <?php
                    if ($login->errorMsg == '') {

                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" . $login->errorMsg .
                            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                    }
                    ?>

                    <h1 class="mb-3">Login with PHP</h1>

                    <div class="mb-3">
                        <label for="username" class="form-label">Email address or username</label>
                        <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div id="passwordReminder" class="form-text">Never share your password with anyone.</div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember-me">
                        <label class="form-check-label" for="exampleCheck1">Keep me logged in</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" name="login">Submit</button>

                </form>

        </div>
    </div>
</div>

<?php

include ("includes/footer.php");

?>
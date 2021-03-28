<?php
include ("includes/header.php");
?>
<body class="bg-light">

<?php
include ("includes/nav.php");
?>

<a href="./../index.php" class="position-absolute">
    <i class="fas fa-sign-in-alt fa-2x btn btn-primary shadow m-2"></i>
</a>

<div class="container d-flex justify-content-center vertical-center">
    <div class="row col-12">
        <div class="col-12 col-md-6 mx-auto">

            <form class="bg-white p-5 shadow rounded" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

                <?php
                if ($register->errorMsg == '') {

                } else {
                    echo "<div class='alert alert-danger'>" . $register->errorMsg . "</div>";
                }

                if ($register->registerMsg == '') {

                } else {
                    echo "<div class='alert alert-success'>" . $register->registerMsg . "</div>";
                }
                ?>

                <h1 class="mb-3">Register new account</h1>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="registerEmail" name="registerEmail">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Choose username</label>
                    <input type="text" class="form-control" id="registerUsername" name="registerUsername">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="registerPassword" name="registerPassword">
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm your password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="passwordConfirm">
                    <div id="passwordReminder" class="form-text">Never share your password with anyone.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100" name="registerAccount">Sign up</button>

            </form>
        </div>
    </div>
</div>

<script>
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>
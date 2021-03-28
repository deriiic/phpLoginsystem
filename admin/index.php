<?php
include ("includes/header.php");
?>
<body class="bg-light">

<?php
include ("includes/nav.php");
?>

<div class="container">
    <h1>Welcome to the admin page, <?php echo $_SESSION['username'];?></h1>
    <form method="POST">
        <button type="submit" class="btn btn-danger" name="logout">Logout</button>
    </form>
</div>

<?php

include("includes/footer.php");

?>
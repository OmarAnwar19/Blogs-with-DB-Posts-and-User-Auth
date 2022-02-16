<?php 

    session_start();
    require("./config/db.php");

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>

    <?php if (isset($_SESSION["message"])) { ?>
        <h6 class="center light-green-text"><?php echo $_SESSION["message"];?></h6>
        <?php unset($_SESSION['message']);?>
    <?php } ?>
    
    <?php include('templates/footer.php'); ?>
</html>
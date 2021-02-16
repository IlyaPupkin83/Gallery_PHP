<?php
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-danger'>".$_SESSION['message']."</div>";
    unset($_SESSION['message']);
}

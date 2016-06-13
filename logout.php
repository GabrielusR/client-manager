<?php
    // Start session
    session_start();
    
    // Unset cookies
    if(isset($_COOKIE[session_name()])) {
        setcookie($_COOKIE[session_name()], '', time()-84600, '/');
    }
    
    // Unset $_SESSION variables
    session_unset();

    // Finish session
    session_destroy();

    include("includes/header.php");
?>

<div class="container-fluid jumbotron">
    <div class="col-sm-12 text-center">
        <h1>Você saiu.</h1>
        <p class="lead">Tchau, tchau! Nós vemos outra hora :)</p>
    </div>

<?php
    include('includes/footer.php');
?>
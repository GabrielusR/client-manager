<?php
// Include header
include('includes/header.php');

// Include helper functions 'library'
include("includes/functions.php");

// If Login form was submitted
if(isset($_POST["login"])) {
    // Grab form input data
    $email = validateFormData($_POST["email"]);
    $password = validateFormData($_POST["password"]);

    // Connect to database
    include("includes/connection.php");

    // Create SQL query
    $sql = "SELECT name, password FROM users WHERE email='$email'";

    // Execute the SQL query and save the result
    $result = mysqli_query($conn, $sql);

    // Check for SQL query result
    if(mysqli_num_rows($result) != 0) {
        // Store user data
        while($row = mysqli_fetch_assoc($result)) {
            $dbName = $row["name"];
            $dbPass = $row["password"];
        }
        // Verify hashed password
        if($password == $dbPass) {
            // Set $_SESSION variables to //authenticated user data
            $_SESSION["loggedInUser"] = $dbName;

            // Redirect user to client page
            header("Location: clients.php");
        } else {
            echo "<div class='alert alert-danger'>Combinação errada de email/senha. Por favor tente novamente.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    } else {
         echo "<div class='alert alert-danger'>Usuário não encontrado. Por favor tente novamente.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    // Close database connection
    mysqli_close($conn);
}
?>
<div class="jumbotron container-fluid">
    <div class="col-sm-12 text-center">
        <h1>Agenda de clientes</h1>
        <p class="lead">Acesse a sua conta.</p>    
    </div>
</div>
<div class="container">
    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="row text-center">
           <div class="form-group">
                <label for="login-email" class="sr-only">Email</label>
                <input type="email" class="form-control" id="login-email" placeholder="Digite seu email" name="email">
            </div>
            <div class="form-group">
                <label for="login-password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="login-password" placeholder="Digite sua senha" name="password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="login" value="Login">
            </div>
        </div><!-- end row -->
    </form>
</div><!-- end container -->

<?php
include('includes/footer.php');
?>
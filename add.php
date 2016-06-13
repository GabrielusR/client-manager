<?php
include('includes/header.php');

if(!isset($_SESSION["loggedInUser"])) {
    // Send them to the login page
    header("Location: index.php");
}

// Connect to database
include("includes/connection.php");

include("includes/functions.php");

if (isset($_POST["add"])) {
    // Set all form input data to empty
    $clientName = $clientEmail = $clientPhone = $clientAddress = $clientCompany = $clientNotes = "";
    // Validating data for the required fields
    if(!$_POST["clientName"]) {
        $nameError = "Please enter a name<br>";
    } else {
        $clientName = $_POST["clientName"];
    }
    if(!$_POST["clientEmail"]) {
        $emailError = "Please enter an email<br>";
    } else {
        $clientEmail = $_POST["clientEmail"];
    }

    // Set the non required fields
    $clientPhone    = validateFormData($_POST["clientPhone"]);
    $clientAddress    = validateFormData($_POST["clientAddress"]);
    $clientCompany   = validateFormData($_POST["clientCompany"]);
    $clientNotes    = validateFormData($_POST["clientNotes"]);

    if($clientName && $clientEmail) {
        // Create SQL query
        $sql = "INSERT INTO clients(id, name, email, phone, address, company, notes, date_added) VALUES(NULL, '$clientName', '$clientEmail', '$clientPhone', '$clientAddress', '$clientCompany', '$clientNotes', CURRENT_TIMESTAMP)";
        $result = mysqli_query($conn, $sql);

        if($result) {
            header("Location: clients.php?alert=success");
        } else {
            echo "Error:".$sql."<br>".mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<div class="container">
<h1>Adicionar cliente</h1>

<form action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] );?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Nome *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Telefone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Endereço</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Empresa</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notas</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes" value=""></textarea>
    </div>
    <div class="col-sm-12">
        <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancelar</a>
        <input type="submit" class="btn btn-lg btn-success pull-right" name="add" value="Adicionar cliente">
    </div>
</form>

<?php
include('includes/footer.php');
?>
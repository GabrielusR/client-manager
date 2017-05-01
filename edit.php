<?php
    include('includes/header.php');

    if(!isset($_SESSION["loggedInUser"])) {
        // Send them to the login page
        header("Location: index.php");
    }
    
    // get ID sent by GET collection
    $clientID = $_GET["id"];

    include("includes/connection.php");

    include("includes/functions.php");

    $sql = "SELECT * FROM clients WHERE id='$clientID'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) != 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $clientName     = $row["name"];
            $clientEmail    = $row["email"];
            $clientPhone = $row["phone"];
            $clientAddress = $row["address"];
            $clientCompany  = $row["company"];
            $clientNotes    = $row["notes"];
        }
    } else {
        echo "<div>Nenhum resultado retornado.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    if(isset($_POST["update"])) {
        $clientName     = validateFormData($_POST["clientName"]);
        $clientEmail    = validateFormData($_POST["clientEmail"]);
        $clientPhone    = validateFormData($_POST["clientPhone"]);
        $clientAddress  = validateFormData($_POST["clientAddress"]);
        $clientCompany  = validateFormData($_POST["clientCompany"]);
        $clientNotes    = validateFormData($_POST["clientNotes"]);
        
        // Create SQL query
        $sql = "UPDATE clients
                SET name='$clientName',
                email='$clientEmail',
                phone='$clientPhone',
                address='$clientAddress',
                company='$clientCompany',
                notes='$clientNotes'
                WHERE id='$clientID'";
        // Execute SQL query and save result
        $result = mysqli_query($conn, $sql);
        
        if($result) {
            header("Location: clients.php?alert=updatesuccess");
        } else {
            echo "Error updating record: ".mysqli_error($conn);
        }
    }
    
    $alertMessage = "";

    if(isset($_POST["delete"])) {
        $alertMessage = "<div class='alert alert-danger'>
            <p>Tem certeza que deseja que deletar esse cliente?</p><br>
            <form action='".htmlspecialchars($_SERVER["PHP_SELF"])."?id=$clientID' method='post'>
                <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Sim, deletar!'>
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Ops, não obrigado!</a>
            </form>
        </div>";
    }

    if(isset($_POST["confirm-delete"])) {
        $sql = "DELETE FROM clients WHERE id='$clientID'";
        $result = mysqli_query($conn, $sql);
        if($result) {
            header("Location: clients.php?alert=deleted");
        } else {
            echo "Error updating record: ".mysqli_error($conn);
        }
    }
    
    mysqli_close($conn);
?>    

<div class="container">
<h1>Editar cliente</h1>
<?php echo $alertMessage;?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $clientID;?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Nome</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Telefone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Endereço</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $clientAddress;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Empresa</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notas</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $clientNotes;?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Deletar</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancelar</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Atualizar</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>
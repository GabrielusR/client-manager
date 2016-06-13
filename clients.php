<?php
    include("includes/header.php");

    // Prevent user from going inside client page after //logged out
    if(!isset($_SESSION["loggedInUser"])) {
        // Send them to the login page
        header("Location: index.php");
    }

    // Connect to database
    include("includes/connection.php");

    // Create SQL query
    $sql = "SELECT * FROM clients";

    // Execute SQL query and save result
    $result = mysqli_query($conn, $sql);

    if(isset($_GET["alert"])) {
        // New client added
        if($_GET["alert"] == "success") {
            echo "<div class='alert alert-success'>Novo cliente adicionado!<a class='close' data-dismiss='alert'>&times;</a></div>";
        } elseif($_GET["alert"] == "updatesuccess") {
            echo "<div class='alert alert-success'>Cliente atualizado!<a class='close' data-dismiss='alert'>&times;</a></div>";   
        } elseif($_GET["alert"] == "deleted") {
            echo "<div class='alert alert-success'>Cliente deletado!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }

    // Close database connection
    mysqli_close($conn);
?>

<div class="container">
<h1>Agenda de clientes</h1>

<table class="table table-striped table-bordered">
    <tr>
      <th>Nome</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>Endereço</th>
      <th>Empresa</th>
      <th>Notas</th>
      <th>Editar</th>
    </tr> 
   <?php
        if(mysqli_num_rows($result) != 0) {
            while($row = mysqli_fetch_assoc($result)) {
            $clientID = $row["id"];
    ?>   
        <tr>
            <td><?php echo $row["name"]?></td>
            <td><?php echo $row["email"]?></td>
            <td><?php echo $row["phone"]?></td>
            <td><?php echo $row["address"]?></td>
            <td><?php echo $row["company"]?></td>
            <td><?php echo $row["notes"]?></td>
            <td><a <?php echo "href='edit.php?id=$clientID'";?> class="btn btn-default btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>
        </tr>
    <?php
            }
    ?>
        <tr>
            <td colspan="7"><div class="text-center"><a href="add.php" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
        </tr>
    <?php
        } else {
            echo "<div class='alert alert-warning'>Você não possui clientes.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    ?>
</table>

<?php
include('includes/footer.php');
?>
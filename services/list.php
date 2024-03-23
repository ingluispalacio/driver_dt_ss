<?php
include '../connection.php';

$query = '';
$output = array();
$query .= "SELECT * FROM drivers ";
if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE identification LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR description LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR state LIKE "%'.$_POST["search"]["value"].'%" ';
} 

if(isset($_POST["order"]))
{
    $columnIndex = $_POST['order']['0']['column'];
    $columnName = $_POST['columns'][$columnIndex]['data'];
    $columnDirection = $_POST['order']['0']['dir'];
    
    $query .= 'ORDER BY '.$columnName.' '.$columnDirection.' ';
}
else
{
    $query .= 'ORDER BY id ASC ';
}
 
if($_POST["length"] != -1)
{
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
} 
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
    $sub_array = array();
    $sub_array[] = "";
    $sub_array[] = $row["identification"];
    $sub_array[] = $row["description"];
    $sub_array[] = $row["email"];
    $value=$row["state"];
    if ($value =="Activo" ) {
        $sub_array[] = "<h5><span class='badge badge-success'>$value</span></h5>";
    }else{
        $sub_array[] = "<h5><span class='badge badge-danger'>$value</span></h5>";
    }
    $sub_array[] = '<div class="d-sm-flex align-items-center">'.
    '<button type="button" class="btn btn-outline-danger size-button-options m-1" title="Eliminar" onclick="deleteDriver(\' '.$row["id"].' \')"><i class="fa fa-trash" aria-hidden="true"></i></button>'.
    '<button type="button" class="btn btn-outline-info size-button-options m-1" title="Modificar" data-toggle="modal" data-target="#driverModal" onclick="fillModalDriver(\' '.$row["id"].' \')"><i class="fa fa-edit" aria-hidden="true"></i></button>'.
    '</div>';
    $data[] = $sub_array;
}

$output = array(
    "draw"              =>   intval($_POST["draw"]),
    "recordsTotal"      =>   $filtered_rows,
    "recordsFiltered"   =>   get_total_all_records(),
    "data"              =>   $data
);

function get_total_all_records()
{
    include '../connection.php';
    $statement = $connection->prepare("SELECT * FROM drivers");
    $statement->execute();
    $result = $statement->fetchAll();
    return $statement->rowCount();
}
echo json_encode($output);


?>
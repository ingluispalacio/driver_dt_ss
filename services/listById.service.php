<?php
include '../connection.php';
$id = trim($_GET["driver_id"]);
$response = array(
    'success' => false,
    'message' => '',
    'data' => null
);
$statement = $connection->prepare("SELECT * FROM drivers WHERE id = :id");

    


$statement->execute(array(':id' => $id));


$result = $statement->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $response['success'] = true;
    $response['message'] = 'Muestra exitosa';
    $response['data'] = $result;
} else {
    $response['message'] = 'Error al mostrar registro en el modal';
}

echo json_encode($response);

<?php
include '../connection.php';
$id = trim($_GET["driver_id"]);
$response = array(
    'success' => false,
    'message' => '',
    'data' => null
);
$statement = $connection->prepare("DELETE FROM drivers WHERE id = :id");
$result = $statement->execute(
    array(
        ':id' =>   $id
    )
);
if ($result) {
    $response['success'] = true;
    $response['message'] = 'Registro eliminado con exito';
} else {
    $response['message'] = 'Error al eliminar registro';
}
echo json_encode($response);
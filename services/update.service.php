<?php
include '../connection.php';
$id = trim($_POST["id"]);
$response = array(
    'success' => false,
    'message' => '',
    'data' => null
);
$identification = isset($_POST["identification"]) ? $_POST["identification"] : null;
$description = isset($_POST["description"]) ? $_POST["description"] : null;
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$phone = isset($_POST["phone"]) ? $_POST["phone"] : 0;
$state = isset($_POST["state"]) ? $_POST["state"] : null;
$statement = $connection->prepare("UPDATE drivers SET identification = :identification, description = :description, email = :email, phone = :phone, state = :state WHERE id = :id");
$result = $statement->execute(
    array(
        ':identification' => $identification,
        ':description' => $description,
        ':email' => $email,
        ':phone' => $phone,
        ':state' => $state,
        ':id' =>   $id
    )
);
if ($result) {
    $response['success'] = true;
    $response['message'] = 'Registro modificado con exito';
} else {
    $response['message'] = 'Error al modificar registro';
}
echo json_encode($response);
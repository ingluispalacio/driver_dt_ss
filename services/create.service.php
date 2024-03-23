<?php
include '../connection.php';

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

$statement = $connection->prepare("INSERT INTO drivers (id, identification, description, phone, email, state) VALUES (UUID(), :identification, :description,  :phone, :email, :state)");
$result = $statement->execute(
    array(
        ':identification' => $identification,
        ':description' => $description,
        ':email' => $email,
        ':phone' => $phone,
        ':state' => $state
    )
);
if ($result) {
    $response['success'] = true;
    $response['message'] = 'Registro agregado con exito';
} else {
    $response['message'] = 'Error al agregar registro'; 
}
echo json_encode($response);
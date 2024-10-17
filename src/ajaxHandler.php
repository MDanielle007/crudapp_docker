<?php
require_once 'controllers/PetController.php';

$pet = new PetController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'getAll':
            $data = $pet->getAllPets();
            echo json_encode($data);
            break;
        case 'get':
            $data = $pet->getPetById($_POST['id']);
            echo json_encode($data);
            break;
        case 'insert':
            $result = $pet->insertPet($_POST['name'], $_POST['type'], $_POST['age']);
            echo json_encode($result);
            break;
        case 'update':
            $result = $pet->updatePet($_POST['id'], $_POST['name'], $_POST['type'], $_POST['age']);
            echo json_encode($result);
            break;
        case 'delete':
            $result = $pet->deletePet($_POST['id']);
            echo json_encode($result);
            break;
    }
}
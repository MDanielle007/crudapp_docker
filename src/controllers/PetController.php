<?php
require_once __DIR__ . '/../models/PetModel.php'; 

class PetController
{
    private $petModel;

    public function __construct()
    {
        $this->petModel = new PetModel();
    }

    public function getAllPets()
    {
        $pets = $this->petModel->getAllPets();
        return $pets;
    }

    public function getPetById($id)
    {
        $pet = $this->petModel->getPetById($id);
        return $pet;
    }

    public function insertPet($name, $type, $age)
    {
        $response = [];
        if ($this->petModel->insertPet($name, $type, $age)) {
            $response['status'] = 'success';
            $response['message'] = 'pet successfully inserted';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to insert pet';
        }

        return $response;
    }

    public function updatePet($id, $name, $type, $age)
    {
        $response = [];
        if ($this->petModel->updatePet($id, $name, $type, $age)) {
            $response['status'] = 'success';
            $response['message'] = 'pet successfully updated';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to update pet';
        }

        return $response;
    }

    public function deletePet($id)
    {
        $response = [];

        if ($this->petModel->deletePet($id)) {
            $response['status'] = 'success';
            $response['message'] = 'pet successfully deleted';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to delete pet';
        }

        return $response;
    }
}

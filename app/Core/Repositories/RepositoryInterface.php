<?php
namespace App\Core\Repositories;

interface RepositoryInterface{

    public function getAll();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id, $trash = true);

    public function saveMany(array $data , $condition = null);

    public function insert(array $data);
}

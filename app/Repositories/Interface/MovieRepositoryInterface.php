<?php
    namespace App\Repositories\Interface;

    interface MovieRepositoryInterface{
        public function getAllWithSearch($search);
        public function getById($id);
        public function getAllPaginated();
        public function getCategories();
        public function create($data);
        public function update($movie, $data);
        public function delete($movie);
    }
?>
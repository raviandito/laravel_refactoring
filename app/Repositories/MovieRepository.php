<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Models\Category;
use App\Repositories\Interface\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface{

    protected $movie;
    protected $category;


    public function __construct(Movie $movie, Category $category) {
        $this->movie = $movie;
        $this->category = $category;
    }

    public function getAllWithSearch($search){

        $query = $this->movie->latest();

        if ($search) {
            $query->where('judul', 'like', "%$search%")
                ->orWhere('sinopsis', 'like', "%$search%");
        }
        return $query->paginate(6)->withQueryString();
    }

    public function getById($id){
        return $this->movie->FindOrFail($id);
    }

    public function getAllPaginated(){
        return $this->movie->latest()->paginate(10);
    }

    public function getCategories(){
        return $this->category->all();
    }

    public function create($data){
        return $this->movie->create($data);
    }

    public function update($movie, $data){
        return $this->movie->update($data);

    }

    public function delete($movie){
        return $this->movie->delete($movie);
    }
}
?>
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use App\Models\Movie;
use App\Models\Category;
use App\Repositories\Interface\MovieRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }
    
    public function index()
    {
        $movies = $this->movieService->getMovie(request('search'));
        return view('homepage', compact('movies'));
    }
    
    public function detail($id)
    {
        $movie = $this->movieService->getMovieById($id);
        return view('detail', compact('movie'));
    }
    
    public function data()
    {
        $movies = $this->movieService->getAllMovies();
        return view('data-movies', compact('movies'));
    }

    public function create()
    {
        $categories = $this->movieService->getMovieCategories();
        return view('input', compact('categories'));
    }

    public function store(StoreMovieRequest $request)
{
    $this->movieService->CreateMovie(
        $request->validated(),
        $request->file('foto_sampul')
    );

    return redirect('/')->with('success', 'Film berhasil ditambahkan.');
}

 public function update(Request $request, $id)
    {
        $this->movieService->updateMovie(
            $id,
            $request->all(),
            $request->file('foto_sampul')
        );

        return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
    }

    public function form_edit($id)
    {
        $movie = Movie::find($id);
        $categories = Category::all();
        return view('form-edit', compact('movie', 'categories'));
    }

    public function delete($id)
    {
        $this->movieService->deleteMovie($id);
        return redirect('/movies/data')->with('success', 'Data berhasil dihapus');
    }
}
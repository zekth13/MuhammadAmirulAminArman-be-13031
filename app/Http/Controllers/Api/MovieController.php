<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Theatre;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        if ($movies->count() > 0) {
            return response()->json([
                'status' => 200,
                'movies' => $movies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => 'No records here'
            ], 404);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'release' => 'required|date_format:Y-m-d',
            'length' => 'required|max:191',
            'description' => 'required|max:1000',
            'mpaa_rating' => 'required',
            'genre_1' => 'required',
            'genre_2' => 'required',
            'genre_3' => 'required',
            'director' => 'required|max:191',
            'actor_1' => 'required',
            'actor_2' => 'required',
            'actor_3' => 'required',
            'language' => 'required|max:191'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'movies' => $validator->messages()
            ], 422);
        } else {
            $movies = Movie::create([
                'title' => $request->title,
                'release' => $request->release,
                'length' => $request->length,
                'description' => $request->description,
                'mpaa_rating' => $request->mpaa_rating,
                'genre_1' => $request->genre_1,
                'genre_2' => $request->genre_2,
                'genre_3' => $request->genre_3,
                'director' => $request->director,
                'actor_1' => $request->actor_1,
                'actor_2' => $request->actor_2,
                'actor_3' => $request->actor_3,
                'language' => $request->language,
            ]);
            if ($movies) {
                return response()->json([
                    'status' => 200,
                    'movies' => "Movie successfully created"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'movies' => "Something must be wrong"
                ], 500);
            }
        }
    }
    public function show(Request $request)
    {
        $id = $request->query('id');

        $request->validate([
            'id' => 'required|integer'
        ]);
        $movies = Movie::find($id);
        if ($movies) {
            return response()->json([
                'status' => 200,
                'movies' => $movies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => "Does not exist"
            ], 404);
        }
    }
    public function edit($id)
    {
        $movies = Movie::find($id);
        if ($movies) {
            return response()->json([
                'status' => 200,
                'movies' => $movies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => "Does not exist"
            ], 404);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'title' => 'required|max:191',
            'release' => 'required|date_format:Y-m-d',
            'length' => 'required|max:191',
            'description' => 'required|max:1000',
            'mpaa_rating' => 'required',
            'genre_1' => 'required',
            'genre_2' => 'required',
            'genre_3' => 'required',
            'director' => 'required|max:191',
            'actor_1' => 'required',
            'actor_2' => 'required',
            'actor_3' => 'required',
            'language' => 'required|max:191'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'movies' => $validator->messages()
            ], 422);
        } else {
            $id = $request->id;
            $movies = Movie::find($id);
            if ($movies) {
                $movies->update([
                    'title' => $request->title,
                    'release' => $request->release,
                    'length' => $request->length,
                    'description' => $request->description,
                    'mpaa_rating' => $request->mpaa_rating,
                    'genre_1' => $request->genre_1,
                    'genre_2' => $request->genre_2,
                    'genre_3' => $request->genre_3,
                    'director' => $request->director,
                    'actor_1' => $request->actor_1,
                    'actor_2' => $request->actor_2,
                    'actor_3' => $request->actor_3,
                    'language' => $request->language,
                ]);
                return response()->json([
                    'status' => 200,
                    'movies' => "Movie updated successfully "
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'movies' => "Does not exist"
                ], 404);
            }
        }
    }
    public function delete(Request $request)
    {
        $id = $request->query('id');

        $request->validate([
            'id' => 'required|integer'
        ]);
        $movies = Movie::find($id);
        if ($movies) {
            $movies->delete();
            return response()->json([
                'status' => 200,
                'movies' => "Movie delete successfully "
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => "Does not exist"
            ], 404);
        }
    }
    public function findgenre(Request $request)
    {
        $genre = $request->query('genre');

        $request->validate([
            'genre' => 'required'
        ]);

        $movies = DB::table('movies')
            ->where('genre_1', 'like', $genre)
            ->orWhere('genre_2', 'like', $genre)
            ->orWhere('genre_3', 'like', $genre)
            ->get();
        if ($movies && !(empty($array))) {
            return response()->json([
                'status' => 200,
                'movies' => $movies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => "Does not exist"
            ], 404);
        }
    }
    public function searchactor(Request $request)
    {
        $actor = $request->query('actor_name');

        $request->validate([
            'actor_name' => 'required'
        ]);
        $movies = DB::table('movies')
            ->where('actor_1', 'like', $actor)
            ->orWhere('actor_2', 'like', $actor)
            ->orWhere('actor_3', 'like', $actor)
            ->get();
        if ($movies && !(empty($array))) {
            return response()->json([
                'status' => 200,
                'movies' => $movies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => "Does not exist"
            ], 404);
        }
    }
    public function newmovies(Request $request)
    {
        $r_date = $request->query('r_date');

        $request->validate([
            'r_date' => 'required|date_format:Y-m-d'
        ]);

        $year = substr($r_date, 0, 4);

        $movies = DB::table('movies')
            ->whereDate('release', '<=', $r_date)
            ->whereYear('release', '=', $year)
            ->orderBy('release', 'asc')
            ->get();

        if ($movies && !(empty($array))) {
            return response()->json([
                'status' => 200,
                'movies' => $movies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => "Does not exist"
            ], 404);
        }
    }
}

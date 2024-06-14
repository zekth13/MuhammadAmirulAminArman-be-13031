<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function index()
    {
        $rating = Rating::all();
        if ($rating->count() > 0) {
            return response()->json([
                'status' => 200,
                'movies' => $rating
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'movies' => 'No records here'
            ], 404);
        }
    }
    public function giverating(Request $request)
    {
        $movie_title = $request->query('movie_title');
        $rating = $request->query('rating');
        $r_description = $request->query('r_description');

        $validator = Validator::make($request->all(), [
            'movie_title' => 'required|max:191',
            'rating' => 'required|integer',
            'r_description' => 'required|max:1000'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'movies' => $validator->messages()
            ], 422);
        } else {
            $movies = Movie::where('title', $movie_title);
            if ($movies) {
                $id = DB::table('movies')->where('title', $movie_title)->value('id');
                $rating = Rating::create([
                    'rating' =>  $rating,
                    'r_description' => $r_description,
                    'movie_id' => $id
                ]);
                return response()->json([
                    'status' => 200,
                    'movies' => "Rating successfully created"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'movies' => "Something must be wrong"
                ], 500);
            }
        }
    }
    public function delete(Request $request)
    {
        $id = $request->query('id');

        $request->validate([
            'id' => 'required|integer'
        ]);
        $rating = Rating::find($id);
        if ($rating) {
            $rating->delete();
            return response()->json([
                'status' => 200,
                'rating' => "Rating delete successfully "
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'theatre' => "Does not exist"
            ], 404);
        }
    }
}

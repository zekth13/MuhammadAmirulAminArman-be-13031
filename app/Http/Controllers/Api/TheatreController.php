<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theatre;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TheatreController extends Controller
{
    public function index()
    {
        $theatre = Theatre::all();
        if ($theatre->count() > 0) {
            return response()->json([
                'status' => 200,
                'movies' => $theatre
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
            'theatre_name' => 'required|max:191',
            'date' => 'required|date_format:Y-m-d',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'movie_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'movies' => $validator->messages()
            ], 422);
        } else {
            $movies = Theatre::create([
                'theatre_name' => $request->theatre_name,
                'date' => $request->date,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'movie_id' => $request->movie_id
            ]);
            if ($movies) {
                return response()->json([
                    'status' => 200,
                    'movies' => "Theatre successfully created"
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
        $theatre = Theatre::find($id);
        if ($theatre) {
            return response()->json([
                'status' => 200,
                'theatre' => $theatre
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'theatre' => "Does not exist"
            ], 404);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required|integer',
            'theatre_name' => 'required|max:191',
            'date' => 'required|date_format:Y-m-d',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'movie_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'movies' => $validator->messages()
            ], 422);
        } else {
            $id = $request->id;
            $theatre = Theatre::find($id);
            if ($theatre) {
                $theatre->update([
                    'theatre_name' => $request->theatre_name,
                    'date' => $request->date,
                    'time_start' => $request->time_start,
                    'time_end' => $request->time_end,
                    'movie_id' => $request->movie_id
                ]);
                return response()->json([
                    'status' => 200,
                    'theatre' => "Theatre updated successfully "
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'theatre' => "Does not exist"
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
        $theatre = Theatre::find($id);
        if ($theatre) {
            $theatre->delete();
            return response()->json([
                'status' => 200,
                'theatre' => "Theatre delete successfully "
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'theatre' => "Does not exist"
            ], 404);
        }
    }
    public function gettimeslot(Request $request)
    {

        $theatre_name = $request->query('theatre_name');
        $time_start = $request->query('time_start');
        $time_end = $request->query('time_end');
        $date_start = $request->query('date_start');
        $date_end = $request->query('date_end');

        $validator = Validator::make($request->all(), [
            'theatre_name' => 'required',
            'time_start' => 'required|date_format:H:i:s',
            'time_end' => 'required|date_format:H:i:s',
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'required|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'movies' => $validator->messages()
            ], 422);
        } else {
            $theatre = DB::table('theatres')
                ->where('theatre_name', $theatre_name)
                ->whereBetween('time_start', [$time_start, $time_end])
                ->whereBetween('date', [$date_start, $date_end])
                ->orderBy('date', 'asc')
                ->get();

            $id = DB::table('theatres')
                ->where('theatre_name', $theatre_name)
                ->whereBetween('time_start', [$time_start, $time_end])
                ->whereBetween('date', [$date_start, $date_end])
                ->orderBy('date', 'asc')
                ->value('movie_id');

            $movie_title = DB::table('movies')->where('id', $id)->value('title');
            if ($theatre) {
                if ($theatre) {
                    return response()->json([
                        'status' => 200,
                        'theatre' => $theatre,
                        'movie' => $movie_title
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'theatre' => "Does not exist"
                    ], 404);
                }
            }
        }
    }
}

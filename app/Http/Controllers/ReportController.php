<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = \Auth::user()->reports()->paginate();

        return ReportResource::collection($reports);
    }

    public function store(ReportRequest $request)
    {
        try{
            $report = \Auth::user()->reports()->create([
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ]);
            return new ReportResource($report);
        }catch (\Exception $e){
            return response()->json(['error'=> 'handle fail'], 400);
        }
    }
}

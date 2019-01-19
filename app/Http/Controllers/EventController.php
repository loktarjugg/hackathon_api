<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function update(Request $request, $id)
    {
        $tag = $request->input('tag');

        $event = Event::query()->findOrFail($id);

        $event->tag = $tag;
        $event->save();

        return response()->json([]);
    }
}

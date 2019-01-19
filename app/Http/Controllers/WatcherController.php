<?php

namespace App\Http\Controllers;

use App\Http\Requests\WatcherRequest;
use App\Http\Resources\WatcherResource;
use App\Jobs\SyncTransaction;
use App\Watcher;

class WatcherController extends Controller
{
    public function index()
    {
        $watchers = Watcher::query()
            ->with('events')
            ->where('user_id', \Auth::id())
            ->paginate();

        return WatcherResource::collection($watchers);
    }

    public function store(WatcherRequest $request)
    {
        try{
            $watcher = \Auth::user()->watchers()->create([
                'address' => strtolower($request->input('address'))
            ]);
            SyncTransaction::dispatch($watcher);
            return new WatcherResource($watcher);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'handle error'
            ], 400);
        }
    }

    public function watcherAgain($id)
    {
        $watcher = Watcher::query()->findOrFail($id);

        SyncTransaction::dispatch($watcher);

        return response()->json([]);
    }

    public function destroy($id)
    {
        $watcher = Watcher::query()->where('user_id', \Auth::id())->findOrFail($id);

        try{
            $watcher->delete();
            return response()->json([]);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'delete fail'
            ], 400);
        }

    }
}

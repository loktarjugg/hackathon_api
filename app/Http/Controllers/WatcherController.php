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
        $watchers = Watcher::query()->where('user_id', \Auth::id())
            ->paginate();

        return WatcherResource::collection($watchers);
    }

    public function store(WatcherRequest $request)
    {
        try{
            $watcher = \Auth::user()->watchers()->create([
                'address' => $request->input('address')
            ]);
            $this->dispatch(new SyncTransaction($watcher));
            return new WatcherResource($watcher);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'handle error'
            ], 400);
        }
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

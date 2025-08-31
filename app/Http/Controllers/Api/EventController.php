<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::query()->latest('event_id')->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:2048',
            'status' => 'nullable|in:registered,attended,cancelled',
        ]);

        $event = Event::create($data);
        return response()->json($event, Response::HTTP_CREATED);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
            'image_url' => 'nullable|url|max:2048',
            'status' => 'nullable|in:registered,attended,cancelled',
        ]);

        $event->update($data);
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

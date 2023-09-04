<?php

namespace App\Http\Controllers;

use App\Helpers\DateTimeHelper;
use App\Http\Requests\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return EventResource::collection(Event::all());
    }

    public function store(StoreEventRequest $request): EventResource
    {
        $event = Event::create([
            'start_time' => DateTimeHelper::getDateTimeString($request->input('time_range.start')),
            'end_time' => DateTimeHelper::getDateTimeString($request->input('time_range.end')),
            'title' => $request->input('title'),
        ]);

        return new EventResource($event);
    }
}

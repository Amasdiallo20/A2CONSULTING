<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::active()->latest('event_date')->paginate(12);

        return view('pages.events', compact('events'));
    }

    public function show($id)
    {
        $event = Event::active()->findOrFail($id);

        return view('pages.events-single', compact('event'));
    }
}

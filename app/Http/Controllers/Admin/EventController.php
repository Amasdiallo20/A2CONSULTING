<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use StoresImages;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest('event_date')->paginate(15);
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'event_date' => 'required|date',
            'start_time' => 'nullable|string|max:32',
            'end_time' => 'nullable|string|max:32',
            'location' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['price'] = integer_price($validated['price'] ?? 0);
        $validated['registered_count'] = 0;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['image'] = $this->storeImage($request, 'image', 'events');
        $validated = $this->normalizeEventTimes($validated);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Événement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'event_date' => 'required|date',
            'start_time' => 'nullable|string|max:32',
            'end_time' => 'nullable|string|max:32',
            'location' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = $event->title === $validated['title']
            ? $event->slug
            : Str::slug($validated['title']);
        $validated['price'] = integer_price($validated['price'] ?? 0);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['image'] = $this->storeImage($request, 'image', 'events', $event->image, true);
        $validated = $this->normalizeEventTimes($validated);

        $event->fill($validated);
        $event->save();
        $event->refresh();

        return redirect()->route('admin.events.edit', $event)
            ->with('success', 'Événement enregistré. Les changements sont visibles sur le site.');
    }

    private function normalizeEventTimes(array $validated): array
    {
        foreach (['start_time', 'end_time'] as $field) {
            $value = $validated[$field] ?? null;
            if ($value === null || $value === '') {
                $validated[$field] = null;
                continue;
            }

            try {
                $validated[$field] = \Carbon\Carbon::parse($value)->format('H:i:s');
            } catch (\Throwable) {
                $validated[$field] = null;
            }
        }

        return $validated;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Événement supprimé avec succès.');
    }
}

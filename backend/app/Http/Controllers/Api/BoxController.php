<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\BoxItem;
use App\Models\BoxPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->user()->boxes()
            ->with(['currentRoom', 'targetRoom', 'parentBox', 'photos', 'items']);

        // Filter by current room
        if ($request->has('current_room_id')) {
            $query->where('current_room_id', $request->current_room_id);
        }

        // Filter by target room
        if ($request->has('target_room_id')) {
            $query->where('target_room_id', $request->target_room_id);
        }

        // Search by name, number, or type
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $boxes = $query->paginate(20);

        return response()->json($boxes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'current_room_id' => 'nullable|exists:rooms,id',
            'current_location' => 'nullable|string|max:255',
            'target_room_id' => 'nullable|exists:rooms,id',
            'target_location' => 'nullable|string|max:255',
            'parent_box_id' => 'nullable|exists:boxes,id',
            'description' => 'nullable|string',
            'custom_fields' => 'nullable|array',
        ]);

        $box = $request->user()->boxes()->create($validated);

        return response()->json($box->load(['currentRoom', 'targetRoom', 'parentBox']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Box $box)
    {
        $this->authorize('view', $box);

        return response()->json($box->load([
            'currentRoom',
            'targetRoom',
            'parentBox',
            'childBoxes',
            'photos',
            'items',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Box $box)
    {
        $this->authorize('update', $box);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'current_room_id' => 'nullable|exists:rooms,id',
            'current_location' => 'nullable|string|max:255',
            'target_room_id' => 'nullable|exists:rooms,id',
            'target_location' => 'nullable|string|max:255',
            'parent_box_id' => 'nullable|exists:boxes,id',
            'description' => 'nullable|string',
            'custom_fields' => 'nullable|array',
        ]);

        $box->update($validated);

        return response()->json($box->load(['currentRoom', 'targetRoom', 'parentBox']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Box $box)
    {
        $this->authorize('delete', $box);

        // Delete all photos
        foreach ($box->photos as $photo) {
            Storage::delete($photo->path);
        }

        $box->delete();

        return response()->json(['message' => 'Box deleted successfully.']);
    }

    /**
     * Upload photo to box
     */
    public function uploadPhoto(Request $request, Box $box)
    {
        $this->authorize('update', $box);

        $request->validate([
            'photo' => 'required|image|max:10240', // 10MB max
        ]);

        $image = $request->file('photo');
        $filename = time() . '_' . $image->getClientOriginalName();
        $path = $image->storeAs('box-photos', $filename, 'public');

        $photo = $box->photos()->create([
            'path' => $path,
            'filename' => $filename,
            'order' => $box->photos()->max('order') + 1,
        ]);

        return response()->json($photo, 201);
    }

    /**
     * Delete photo from box
     */
    public function deletePhoto(Box $box, BoxPhoto $photo)
    {
        $this->authorize('update', $box);

        Storage::delete($photo->path);
        $photo->delete();

        return response()->json(['message' => 'Photo deleted successfully.']);
    }

    /**
     * Add item to box
     */
    public function addItem(Request $request, Box $box)
    {
        $this->authorize('update', $box);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $item = $box->items()->create($validated);

        return response()->json($item, 201);
    }

    /**
     * Update box item
     */
    public function updateItem(Request $request, Box $box, BoxItem $item)
    {
        $this->authorize('update', $box);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $item->update($validated);

        return response()->json($item);
    }

    /**
     * Delete box item
     */
    public function deleteItem(Box $box, BoxItem $item)
    {
        $this->authorize('update', $box);

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully.']);
    }
}


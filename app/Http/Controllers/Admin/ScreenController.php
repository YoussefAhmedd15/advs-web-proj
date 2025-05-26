<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScreenController extends Controller
{
    public function index()
    {
        $screens = Screen::withCount('showtimes')
            ->orderBy('name')
            ->paginate(10);
            
        return view('admin.screens.index', compact('screens'));
    }

    public function create()
    {
        return view('admin.screens.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:screens'],
                'capacity' => ['required', 'integer', 'min:1'],
                'description' => ['nullable', 'string'],
                'is_active' => ['boolean'],
            ]);

            $screen = Screen::create($validated);

            return redirect()->route('admin.screens.index')
                ->with('success', 'Screen created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating screen', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create screen. ' . $e->getMessage()]);
        }
    }

    public function edit(Screen $screen)
    {
        return view('admin.screens.edit', compact('screen'));
    }

    public function update(Request $request, Screen $screen)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:screens,name,' . $screen->id],
                'capacity' => ['required', 'integer', 'min:1'],
                'description' => ['nullable', 'string'],
                'is_active' => ['boolean'],
            ]);

            $screen->update($validated);

            return redirect()->route('admin.screens.index')
                ->with('success', 'Screen updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating screen', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update screen. ' . $e->getMessage()]);
        }
    }

    public function destroy(Screen $screen)
    {
        try {
            // Check if screen has any showtimes
            if ($screen->showtimes()->exists()) {
                return redirect()->route('admin.screens.index')
                    ->with('error', 'Cannot delete screen that has associated showtimes.');
            }

            $screen->delete();

            return redirect()->route('admin.screens.index')
                ->with('success', 'Screen deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting screen', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.screens.index')
                ->with('error', 'Failed to delete screen. ' . $e->getMessage());
        }
    }
} 
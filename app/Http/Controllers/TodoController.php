<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return Todo::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'in:low,medium,high',
        ]);

        return Todo::create($validatedData);
    }

    public function update(Request $request, Todo $todo)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'nullable',
            'completed' => 'sometimes|boolean',
            'priority' => 'sometimes|in:low,medium,high',
        ]);

        $todo->update($validatedData);
        return $todo;
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(['message' => 'Tâche supprimée']);
    }
}

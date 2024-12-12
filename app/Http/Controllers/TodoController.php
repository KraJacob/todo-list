<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TodoRepository;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function __construct(protected TodoRepository $todoRepository) {}
    public function index()
    {
        return response()->json($this->todoRepository->getAll());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'in:low,medium,high',
        ]);

        return response()->json(
            $this->todoRepository->create($validatedData),
            201
        );
    }

    public function update(Request $request, Todo $todo)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'nullable',
            'completed' => 'sometimes|boolean',
            'priority' => 'sometimes|in:low,medium,high',
        ]);

        return response()->json(
            $this->todoRepository->update($todo, $validatedData)
        );
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(['message' => 'Tâche supprimée']);
    }
}

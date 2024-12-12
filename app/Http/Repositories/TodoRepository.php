<?php

namespace App\Http\Repositories;

use App\Models\Todo;

class TodoRepository
{
    public function getAll()
    {
        return Todo::all();
    }

    public function create($data)
    {
        return Todo::create($data);
    }

    public function update($todo, $data)
    {
        $todo->update($data);
        return $todo;
    }

    public function delete($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        return $todo;
    }
}

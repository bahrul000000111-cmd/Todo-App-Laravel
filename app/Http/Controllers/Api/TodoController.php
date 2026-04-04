<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = $request->user()->todos();
        
        if ($request->status == 'completed') {
            $todos = $todos->completed();
        } elseif ($request->status == 'pending') {
            $todos = $todos->pending();
        }

        return response()->json([
            'success' => true,
            'data' => $todos->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $todo = $request->user()->todos()->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $todo = $request->user()->todos()->find($id);
        
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Todo not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function update(Request $request, $id)
    {
        $todo = $request->user()->todos()->find($id);
        
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Todo not found'
            ], 404);
        }

        $todo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Todo updated successfully',
            'data' => $todo
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $todo = $request->user()->todos()->find($id);
        
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Todo not found'
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Todo deleted successfully'
        ]);
    }

    public function toggle(Request $request, $id)
    {
        $todo = $request->user()->todos()->find($id);
        
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Todo not found'
            ], 404);
        }

        $todo->update([
            'is_completed' => !$todo->is_completed
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $todo
        ]);
    }
}
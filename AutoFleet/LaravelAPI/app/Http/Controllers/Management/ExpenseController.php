<?php

namespace App\Http\Controllers\Management;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpenseController
{











    
    public function index()
    {
        // Get all expenses from the database
        $expenses = Expenses::all();

        return response()->json($expenses, 200);
    }




















    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        // Create a new expense
        $expense = Expenses::create($validatedData);

        return response()->json([
            'message' => 'Expense added successfully!',
            'expense' => $expense,
        ], 201);
    }






























    public function show($id)
    {
        // Find expense by ID
        $expense = Expenses::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        return response()->json($expense, 200);
    }























    public function update(Request $request, $id)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        // Find expense by ID
        $expense = Expenses::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        // Update the expense
        $expense->update($validatedData);

        return response()->json([
            'message' => 'Expense updated successfully!',
            'expense' => $expense,
        ], 200);
    }





















    public function destroy($id)
    {
        // Find expense by ID
        $expense = Expenses::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        // Delete the expense
        $expense->delete();

        return response()->json([
            'message' => 'Expense deleted successfully!',
        ], 200);
    }















    
}

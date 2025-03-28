<?php

namespace App\Services;

use App\Models\Expenses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExpenseService
{





    public function createExpense( $data)
    {
        // Validate and process data if necessary before creating the expense
        $expense = Expenses::create($data);

        return $expense;
    }









    public function updateExpense($id, array $data)
    {
        $expense = Expenses::find($id);

        if (!$expense) {
            throw new ModelNotFoundException('Expense not found');
        }

        $expense->update($data);

        return $expense;
    }













    public function deleteExpense($id)
    {
        $expense = Expenses::find($id);

        if (!$expense) {
            throw new ModelNotFoundException('Expense not found');
        }

        return $expense->delete();
    }















    public function getAllExpenses()
    {
        return Expenses::all();
    }









    public function getExpenseById($id)
    {
        $expense = Expenses::find($id);

        if (!$expense) {
            throw new ModelNotFoundException('Expense not found');
        }

        return $expense;
    }












    public function getExpensesByReason($reason)
    {
        return Expenses::where('reason', 'like', '%' . $reason . '%')->get();
    }













    public function getExpensesByAmountRange($minAmount, $maxAmount)
    {
        return Expenses::whereBetween('amount', [$minAmount, $maxAmount])->get();
    }








    public function getTotalExpenses()
    {
        return Expenses::sum('amount');
    }












    public function getTotalExpensesForCurrentYear()
    {
        return Expenses::whereYear('created_at', now()->year) // Filter by current year
            ->sum('amount');
    }















    public function getTotalExpensesForCurrentMonth()
    {
        return Expenses::whereMonth('created_at', now()->month) // Filter by current month
            ->whereYear('created_at', now()->year) // Filter by current year
            ->sum('amount');
    }












    public function getTotalExpensesForCurrentDay()
{
    return Expenses::whereDate('created_at', now()->toDateString()) // Filter by today's date
        ->sum('amount');
}











public function getTotalExpensesForCurrentWeek()
{
    return Expenses::whereBetween('created_at', [
        now()->startOfWeek(), // Start of the current week (Monday)
        now()->endOfWeek()    // End of the current week (Sunday)
    ])->sum('amount');
}



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        // Fetch all expenses with pagination
        $expenses = DB::table('expenses')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'retailer_name' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'expense_date' => 'required|date',
        ]);

        // Insert into database
        DB::table('expenses')->insert([
            'retailer_name' => $validatedData['retailer_name'],
            'amount' => $validatedData['amount'],
            'payment_method' => $validatedData['payment_method'],
            'expense_date' => $validatedData['expense_date'],
            'created_at' => now(),
        ]);

        // Get the updated table HTML
        $expenses = DB::table('expenses')->paginate(10);
        $expensesHtml = view('expenses.table', compact('expenses'))->render();

        // Return the table HTML to update the page dynamically
        return response()->json(['expensesHtml' => $expensesHtml]);
    }

    public function destroy($id)
    {
        // Delete expense by ID
        DB::table('expenses')->where('id', $id)->delete();

        // Redirect back to the index page
        return redirect()->route('expenses.index');
    }

    public function edit($id)
    {
        // Fetch the expense using the provided ID (without using the model)
        $expense = DB::table('expenses')->where('id', $id)->first();

        // Check if expense exists
        if (!$expense) {
            return redirect()->route('expenses.index')->with('error', 'Expense not found!');
        }

        // Return a view to edit the expense (passing the $expense to the view)
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validatedData = $request->validate([
            'retailer_name' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'expense_date' => 'required|date',
        ]);

        // Update the expense in the database
        $updated = DB::table('expenses')
            ->where('id', $id)
            ->update([
                'retailer_name' => $validatedData['retailer_name'],
                'amount' => $validatedData['amount'],
                'payment_method' => $validatedData['payment_method'],
                'expense_date' => $validatedData['expense_date'],
                'updated_at' => now(),
            ]);

        // Check if the update was successful
        if ($updated) {
            return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
        } else {
            return redirect()->route('expenses.index')->with('error', 'Failed to update expense.');
}
}
}

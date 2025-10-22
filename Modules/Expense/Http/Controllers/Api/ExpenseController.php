<?php

namespace Modules\Expense\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Expense\Services\ExpenseService;
use Modules\Expense\Transformers\ExpenseResource;
use Modules\Expense\Http\Requests\ExpenseFormRequest;

class ExpenseController extends Controller
{
    protected ExpenseService $expense;

    public function __construct(ExpenseService $ExpenseService)
    {
        $this->expense = $ExpenseService;
    }

    public function index()
    {
        $filters = ['category' =>request()->category];

        $expenses = $this->expense->getAllExpenses($filters);

        return new ExpenseResource($expenses);
    }

    public function store(ExpenseFormRequest $request)
    {
        $expense = $this->expense->createExpense($request->validated());

        return new ExpenseResource($expense);
    }

    public function show($id)
    {
        $expense = $this->expense->getExpense($id);

        return new ExpenseResource($expense);
    }

    public function update(ExpenseFormRequest $request, $id)
    {
        $expense = $this->expense->updateExpense($id, $request->validated());

        return new ExpenseResource($expense);
    }

    public function destroy($id)
    {
        $expense = $this->expense->deleteExpense($id);

        return new ExpenseResource($expense);
    }
}

<?php

namespace Modules\Expense\Repositories;

use Modules\Expense\Contracts\ExpenseRepositoryInterface;
use Modules\Expense\Models\Expense;
use Modules\Expense\Events\ExpenseCreated;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function all(array $filters = []): mixed
    {
        try
        {
            $query = Expense::query();

            if (!empty($filters['category']))
            {
                $query->where('category', $filters['category']);
            }

            $expenses = $query->get();
            $categoryConfig = config('expense.categories', []);
            $expenses = $expenses->map(function ($expense) use ($categoryConfig) {
                $expense->category_detail = $categoryConfig[$expense->category] ?? 'Unknown';
                return $expense;
            });

            return (object)[
                'status' => Response::HTTP_OK,
                'message' => trans('messages.resource_fetched_successfully'),
                'data' => $expenses
            ];
        }
        catch (Exception $e)
        {
            Log::channel('data_logging')->info($e->getMessage());

            return (object)[
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => trans('messages.un_expected_error')
            ];
        }
    }

    public function find(string $id): mixed
    {
        try
        {
            $expense = $this->findExpenseOrFail($id);
            if (is_object($expense) && isset($expense->error)) return $expense;

            $categoryConfig = config('expense.categories', []);

            $expense->category_detail = $categoryConfig[$expense->category] ?? 'Unknown';

            return (object)[
                'message' => trans('messages.resource_fetched_successfully'),
                'data' => $expense,
                'status' => Response::HTTP_OK,
            ];
        }
        catch (Exception $e)
        {
            Log::channel('data_logging')->info($e->getMessage());

            return (object)[
                'error' => trans('messages.un_expected_error'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function create(array $requestData): mixed
    {
        try
        {
            $requestData = (object) $requestData;

            $data = [
                'title' => $requestData->title,
                'amount' => $requestData->amount,
                'expense_date' => $requestData->expense_date,
                'category' => $requestData->category ?? 1,
                'notes' => $requestData->notes ?? null
            ];

            $expense = Expense::create($data);

            event(new ExpenseCreated($expense));

            return (object)[
                'message' => trans('messages.resource_created_successfully'),
                'status' => Response::HTTP_OK,
            ];
        }
        catch (Exception $e)
        {
            Log::channel('data_logging')->info($e->getMessage());

            return (object)[
                'error' => trans('messages.un_expected_error'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function update($id, array $requestData): mixed
    {
        try
        {
            $expense = $this->findExpenseOrFail($id);
            if (is_object($expense) && isset($expense->error)) return $expense;

            $requestData = (object) $requestData;
            $expense->title        = $requestData->title;
            $expense->amount       = $requestData->amount;
            $expense->expense_date = $requestData->expense_date;
            $expense->category     = $requestData->category ?? 1;
            $expense->notes        = $requestData->notes ?? null;

            $expense->save();

            return (object)[
                'id' => $expense->id,
                'message' => trans('messages.resource_updated_successfully'),
                'status' => Response::HTTP_OK,
            ];
        }
        catch (Exception $e)
        {
            Log::channel('data_logging')->info($e->getMessage());

            return (object)[
                'error' => trans('messages.un_expected_error'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function delete($id): mixed
    {
        try
        {
            $expense = $this->findExpenseOrFail($id);
            if (is_object($expense) && isset($expense->error)) return $expense;

            $expense->delete();

            return (object) [
                'id' => $id,
                'status' => Response::HTTP_OK,
                'message' => trans('messages.resource_deleted_successfully'),
            ];
        }

        catch (Exception $e)
        {
            Log::channel('data_logging')->info($e->getMessage());

            return (object)[
                'error' => trans('messages.un_expected_error'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    private function findExpenseOrFail($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return (object)[
                'error' => trans('messages.resource_not_found'),
                'status' => Response::HTTP_NOT_FOUND
            ];
        }

        return $expense;
    }
}

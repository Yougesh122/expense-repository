<?php

namespace Modules\Expense\Services;

use Modules\Expense\Contracts\ExpenseRepositoryInterface;

class ExpenseService
{
    protected ExpenseRepositoryInterface $repository;

    public function __construct(ExpenseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllExpenses(array $filters): mixed
    {
        return $this->repository->all($filters);
    }

    public function getExpense(string $id): mixed
    {
        return $this->repository->find($id);
    }

    public function createExpense(array $data): mixed
    {
        return $this->repository->create($data);
    }

    public function updateExpense(string $id, array $data): mixed
    {
        return $this->repository->update($id, $data);
    }

    public function deleteExpense(string $id): mixed
    {
        return $this->repository->delete($id);
    }
}

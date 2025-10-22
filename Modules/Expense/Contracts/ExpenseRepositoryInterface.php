<?php

namespace Modules\Expense\Contracts;

use Modules\Expense\Models\Expense;

interface ExpenseRepositoryInterface
{
    /**
     * Get all expenses
     *
     * @return mixed
     */
    public function all(): mixed;

    /**
     * Find a single expense by ID
     *
     * @param string $id
     * @return mixed
     */
    public function find(string $id): mixed;

    /**
     * Create a new expense
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update an existing expense
     *
     * @param Expense $expense
     * @param array $data
     * @return mixed
     */
    public function update(string $id, array $data): mixed;

    /**
     * Delete an expense
     *
     * @param Expense $expense
     * @return mixed
     */
    public function delete(string $id): mixed;
}

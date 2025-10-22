<?php

namespace Modules\Expense\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Expense\Models\Expense;

class ExpenseCreated
{
    use Dispatchable, SerializesModels;

    public $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }
}

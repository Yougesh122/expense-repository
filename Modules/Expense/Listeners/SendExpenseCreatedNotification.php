<?php

namespace Modules\Expense\Listeners;

use Modules\Expense\Events\ExpenseCreated;
use Illuminate\Support\Facades\Log;

class SendExpenseCreatedNotification
{
    public function handle(ExpenseCreated $event): void
    {
        Log::info('Expense created: ' . $event->expense->title);
    }
}

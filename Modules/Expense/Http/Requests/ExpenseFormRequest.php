<?php

namespace Modules\Expense\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ExpenseFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categories = config('expense.categories',[]);
        $categoryValues = array_keys($categories);

        $rules = [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date_format:' . config('app.default_date_format_php'),
            'notes' => 'nullable|string',
            'category' => 'nullable|in:' . implode(',',  $categoryValues),
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['title'] = 'sometimes|string|max:255';
            $rules['amount'] = 'sometimes|numeric|min:0';
            $rules['expense_date'] = 'sometimes|date_format:' . config('app.default_date_format_php');
            $rules['notes'] = 'sometimes|string';
            $rules['category'] = 'nullable|in:' . implode(',', $categoryValues);
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'data' => [
                'error' => $validator->errors()->toArray(),
            ],
        ];

        $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

        $response += [
            'status' => $statusCode,
        ];

        if ($this->expectsJson())
        {
            throw new HttpResponseException(
                response()->json($response, $statusCode)
            );
        }

        throw (new ValidationException($validator));
    }


    public function messages()
    {
        $categories = config('expense.categories',[]);
        $categoryValues = array_keys($categories);
        return [
            'title.required' => 'Please provide title.',
            'amount.required' => 'Please provide amount.',
            'amount.numeric' => 'Amount must be a number.',
            'expense_date.required' => 'Please provide date.',
            'expense_date.date' => 'Date must be a valid date.',
            'category.in' => 'The selected category is invalid. Please choose one of defined in config: ' . implode(',', $categoryValues).' respectively:  '. implode(',', $categories),
        ];
    }
}

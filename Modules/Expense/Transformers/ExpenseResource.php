<?php

namespace Modules\Expense\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class ExpenseResource extends JsonResource
{
    /**
     * @var int
     */
    protected int $statusCode;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            isset($this->error) ? 'error' : 'message' => $this->error ?? $this->message
        ];

        if (isset($this->data))
        {
            $data += ['body' => $this->data];
        }

        $this->statusCode = $this->status;

        return $data;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|object
     */

    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode($this->statusCode);
    }

    /**
     * @param $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => $this->statusCode
        ];

        return parent::with($request);
    }
}

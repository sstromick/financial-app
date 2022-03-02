<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'has_password' => $this->has_password,
            'has_email' => $this->has_email,
            'submission' => new SubmissionResource($this->submission),
            'payment' => new PaymentResource($this->payment),
            'expenses' => ExpenseResource::collection($this->expenses),
            'files' => FileResource::collection($this->files),
            'creditAccounts' => CreditAccountResource::collection($this->creditAccounts->sortBy("debt_type")),
        ];
    }
}

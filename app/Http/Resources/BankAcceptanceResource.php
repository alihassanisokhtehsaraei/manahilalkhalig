<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAcceptanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'letNo' => $this->letNo,
            'letDate' => $this->letDate,
            'letText' => $this->letText,
            'signee' => $this->signee,
            'secLevel' => $this->secLevel,
            'sender' => $this->sender,
            'from' => $this->from,
            'recipientDept' => $this->recipientDept,
            'recipient' => $this->recipient,
            'letRef' => $this->letRef,
            'regNo' => $this->regNo,
            'regDate' => $this->regDate,
            'type' => $this->type,
            'branch' => $this->branch,
            'ip' => $this->ip,
            'user' => $this->user
        ];
    }
}

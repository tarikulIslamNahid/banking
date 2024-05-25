<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected $token = null;
    protected $success;
    protected $message;
    public function token($value)
    {
        $this->token = $value;
        return $this;
    }
    public function success($value)
    {
        $this->success = $value;
        return $this;
    }
    public function message($value)
    {
        $this->message = $value;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'account_type' => $this->account_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'token'         =>  $this->token,
            'token_type'    => 'Bearer',
            'success'       =>  $this->success,
            'message'       =>  $this->message
        ];
    }
}

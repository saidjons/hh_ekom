<?php

namespace App\DTOs;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UserUpdateRequest;

class UserDTO
{

    public function __construct(
        public string|null $name,
        public string|null $email,
        public string|null $password,

    ) {
    }

    static public function fromApiRequest(UserRequest $r)
    {
        return new self(
            name: $r->validated("name"),
            email: $r->validated("email"),
            password: Hash::make($r->validated("password")),
        );
    }
    static public function fromApiRequestUpdate(UserUpdateRequest $r)
    {
        return new self(
            name: $r->validated("name"),
            email: $r->validated("email"),
            password: bcrypt($r->validated("password")),
        );
    }
}

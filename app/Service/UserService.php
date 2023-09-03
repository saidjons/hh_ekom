<?php

namespace App\Service;

use App\Models\User;
use App\DTOs\UserDTO;
use App\Models\Product;
use Illuminate\Http\Request;

class UserService
{

    public function all()
    {
        return User::all();
    }

    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }
    public function find($email)
    {
        return User::where("email", $email)->first();
    }

    public function getToken(User $user){
        $tokenText = $user->createToken("auth")->plainTextToken;
        $token = explode("|",$tokenText);
        return $token[1];
    }
   

    public function store(
        UserDTO $dto
    ) {
        return User::create([
            "name" => $dto->name,
            "email" => $dto->email,
            "password" => $dto->password,

        ]);
    }
    public function update(
        User $user,
        UserDTO $dto
    ) {
        return tap($user)->update([
            "name" => $dto->name ?? $user->name,
            "email" => $dto->email ?? $user->email,
        ]);
    }

    public function delete($id)
    {
        $user = $this->findOrFail($id);
        if ($user) {

            $user->delete();
        }
    }
}

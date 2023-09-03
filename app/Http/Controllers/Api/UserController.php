<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\DTOs\UserDTO;
use App\Service\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service,
    ) {
    }

    public function index(){

        $users = $this->service->all();

        return UserResource::collection($users);
    }
    public function login(LoginRequest $r){

        $email = $r->get("email");
        $password = $r->get("password");


        $user = $this->service->find($email);
        if (!$user) {
            return response()->json([
                "error" => "user not exists",
            ],422);
        }

        if (Hash::check($password,$user->password)) {
            $token = $this->service->getToken($user);
            return response()->json([
                "token" => $token,
            ],200);
        }

        return    response()->json([
            "error" => "incorrect password",
        ],422);

    }
    public function show($id){

        $user = $this->service->findOrFail($id);
        return UserResource::make($user);
    }
    
    public function register(UserRequest $r)
    {

        $user = $this->service->store(
            UserDTO::fromApiRequest($r)
        );

        return response()->json([
            "token"=>$this->service->getToken($user),
        ]);
    }
    public function store(UserRequest $r)
    {

        $product = $this->service->store(
            UserDTO::fromApiRequest($r)
        );

        return UserResource::make($product);
    }
    public function update(UserUpdateRequest $r, User $user)
    {

        $user = $this->service->update(
            $user,
            UserDTO::fromApiRequestUpdate($r), 

        );

        return UserResource::make($user);
    }

    public function delete($id){
        $users = $this->service->delete($id);

        return response()->json([],200);
    }
}

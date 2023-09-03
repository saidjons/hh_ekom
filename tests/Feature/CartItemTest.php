<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

use App\Models\Product;
use App\Service\UserService;
use Illuminate\Http\Response;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartItemTest extends TestCase
{
    use RefreshDatabase;
    private $token;

    function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = (new UserService)->getToken($user);
    }

    public function test_add_to_cart_without_auth_fails(): void
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/api/admin/cart/add', [
            "product_id" => $product->id,
        ],);

        $response->assertStatus(401);
    }

    public function test_add_to_cart_requires_quantity(): void
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/api/admin/cart/add', [
            "product_id" => $product->id,
        ], [
            "Authorization" => "Bearer " . $this->token
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('quantity');
    }
    public function test_add_to_cart_requires_product_id(): void
    {
        

        $response = $this->postJson('/api/admin/cart/add', [
            "quantity" => 2,
        ], [
            "Authorization" => "Bearer " . $this->token
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('product_id');
    }

    public function test_add_to_cart(): void
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/api/admin/cart/add', [
            "product_id" => $product->id,
            "quantity" => 2,

        ],["Authorization" => "Bearer " . $this->token]);
        $data = $response->json();

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonMissingValidationErrors('quantity');
        $response->assertJsonMissingValidationErrors('product_id');
    }


    public function test_adding_nonexisted_product_fails(): void
    {
        $number = rand(1000,1000000);

        $response = $this->postJson("/api/admin/cart/add", [
            "product_id" => $number,
            "quantity" =>3,
            

        ],["Authorization" => "Bearer " . $this->token]);
      
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('product_id');

    }


    public function test_add_product_to_cart(): void
    {
        $product =Product::factory()->create();

       
        $response = $this->postJson("/api/admin/cart/add", [
             
            "product_id" => $product->id,
            "quantity" => 2,

        ],["Authorization"=>"Bearer ".$this->token]);

 
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data.items.0',
                    fn (AssertableJson $json) =>
                    $json->where('product_id', $product->id)
                        ->etc()
                )
            );


        $response->assertStatus(201);
    }


    public function test_remove_product_from_cart(): void
    {
        $product = Product::factory()->create();


          $del_response = $this->delete('/api/admin/cart/'.$product->id,headers:["Authorization"=>"Bearer ".$this->token]);  

        //   dd($del_response->json());
          $del_response->assertStatus(200);


    }


    public function test_deleting_nonexistennce_product_from_cart_fails(): void
    {
        $number = rand(1000,1000000);
          $del_response = $this->delete('/api/admin/product/'.$number,headers:["Authorization"=>"Bearer ".$this->token]);  
          $del_response->assertStatus(404);


    }
}

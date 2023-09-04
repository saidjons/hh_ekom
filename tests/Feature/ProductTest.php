<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

use App\Models\Product;
use App\Service\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    private $token;

    function setUp():void
    {
        parent::setUp();
        $user = User::factory()->create();
        $service = new UserService;
        $this->token = $service->getToken($user);
        $role = $service->createAdminRole();
        $user->assignRole($role);
    }

    public function test_creating_product_requires_price_field(): void
    {
        $response = $this->postJson('/api/admin/product', [
            "title" => "shoes",
            "description" => "new shoes",
            "in_stock" => true,
            "image" =>  UploadedFile::fake()->image('shoes.jpg')
        ],[
            "Authorization"=>"Bearer ".$this->token
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('price');
    }
    public function test_creating_product_requires_title_field(): void
    {
        $response = $this->postJson('/api/admin/product', [

            "description" => "new shoes",
            "in_stock" => true,
            "image" => UploadedFile::fake()->image('shoes.jpg')
        ],[
            "Authorization"=>"Bearer ".$this->token
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }
    public function test_creating_product_requires_description_field(): void
    {
        $response = $this->postJson('/api/admin/product', [
            "in_stock" => true,
            "image" => UploadedFile::fake()->image('shoes.jpg')
        ],[
            "Authorization"=>"Bearer ".$this->token
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('description');
    }
    public function test_create_product(): void
    {
        $response = $this->postJson('/api/admin/product', [
            "in_stock" => true,
            "image" => UploadedFile::fake()->image('shoes.jpg'),
            "title" => "shoes black",
            "price" => 200,
            "description" => "shoes.image",

        ],[
            "Authorization"=>"Bearer ".$this->token
        ]);
        $data = $response->json();
       
        // assert image exists
        Storage::assertExists($data['data']['image']);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonMissingValidationErrors('title');
        $response->assertJsonMissingValidationErrors('price');
        $response->assertJsonMissingValidationErrors('image');
        $response->assertJsonMissingValidationErrors('description');
    }
    public function test_updating_nonexisted_product_fails(): void
    {
        $number = rand(1000, 1000000);

        $response = $this->putJson("/api/admin/product/" . $number, [
            "in_stock" => true,
            "image" => UploadedFile::fake()->image('shoes.jpg'),
            "title" => "shoes black updated",
            "price" => 200,
            "description" => "shoes.image",

        ],[
            "Authorization"=>"Bearer ".$this->token
        ]);


        $response->assertStatus(404);
    }
    public function test_update_product(): void
    {
        $product = Product::factory()->create();

        $title = "shoes black updated";
        $response = $this->putJson("/api/admin/product/" . $product->id, [
            "in_stock" => true,
            "image" => UploadedFile::fake()->image('shoes.jpg'),
            "title" => $title,
            "price" => 200,
            "description" => "shoes.image",

        ],[ "Authorization"=>"Bearer ".$this->token]);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data',
                    fn (AssertableJson $json) =>
                    $json->where('id', $product->id)
                        ->where('title', $title)
                        ->etc()
                )
            );


        $response->assertStatus(200);
    }
    public function test_delete_product(): void
    {
        $product = Product::factory()->create();


        $del_response = $this->delete('/api/admin/product/' . $product->id,headers:[ "Authorization"=>"Bearer ".$this->token]);

        //   dd($del_response->json());
        $del_response->assertStatus(200);
    }
    public function test_deleting_nonexistennce_product_fails(): void
    {
        $number = rand(1000, 1000000);
        $del_response = $this->delete('/api/admin/product/' . $number,headers:[ "Authorization"=>"Bearer ".$this->token]);
        $del_response->assertStatus(404);
    }
}

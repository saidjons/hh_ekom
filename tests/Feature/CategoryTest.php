<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

use App\Models\Product;
use App\Models\Category;
use App\Service\UserService;
use Illuminate\Http\Response;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
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
    
    public function test_creating_category_requires_title_field(): void
    {
        $response = $this->postJson('/api/admin/category', [
           
            "description" => "new shoes",
            
        ],[ "Authorization"=>"Bearer ".$this->token]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }
  
   


    public function test_create_category(): void
    {
        $response = $this->postJson('/api/admin/category', [
            
            "title" => "Shoes",
        ],[ "Authorization"=>"Bearer ".$this->token]);
        $data = $response->json();

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonMissingValidationErrors('title');
    
    }
    public function test_updating_nonexisted_category_fails(): void
    {
        $number = rand(1000,1000000);

        $response = $this->putJson("/api/admin/category/".$number, [
            "title" => "shoes black updated",
        ],[ "Authorization"=>"Bearer ".$this->token]);


        $response->assertStatus(404);
    }
    public function test_update_category(): void
    {
        $category =Category::factory()->create();

        $title = "shoes black updated";
        $response = $this->putJson("/api/admin/category/" . $category->id, [
            
            "title" => $title,
             

        ],[ "Authorization"=>"Bearer ".$this->token]);
        $response->assertStatus(200);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data',
                    fn (AssertableJson $json) =>
                    $json->where('id', $category->id)
                        ->where('title', $title)
                        ->etc()
                )
            );


    }


    public function test_delete_category(): void
    {
        $category = Category::factory()->create();


          $del_response = $this->delete('/api/admin/category/'.$category->id,headers:[ "Authorization"=>"Bearer ".$this->token]);  
        
        //   dd($del_response->json());
          $del_response->assertStatus(200);

         
    }


    public function test_deleting_nonexistennce_category_fails(): void
    {
        $number = rand(1000,1000000);
          $del_response = $this->delete('/api/admin/category/'.$number,headers:[ "Authorization"=>"Bearer ".$this->token]);  
          $del_response->assertStatus(404);

         
    }
}

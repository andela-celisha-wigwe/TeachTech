<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCategoryIndex()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);

    	$this->actingAs($user)
    			->visit('categories')
    			->see('MsDotNet')
    			;
    	$this->countElements('.add-category', 0);
    }

    public function testCategoryIndexToCategoryShow()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);

    	$this->actingAs($user)
    			->visit('categories')
    			->see('MsDotNet')
    			->click('MsDotNet')
    			->seePageIs('categories/1')
    			;
    }

    public function testCategoryIndexToAddNew()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$this->actingAs($user)
    			->visit('categories')
    			->see('MsDotNet')
    			;

    	$this->countElements('.add-category', 1);
    }

    public function testCreateCategory()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->actingAs($user)->call('POST', 'category/add', ['_token' => csrf_token(), 'name' => 'PHP', 'brief' => 'HyperText PreProcessor']);
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(2, $count);

	    // $page = $this->actingAs($user)
	    // 			->visit('categories')
	    // 			->click('New')
	    // 			->seePageIs('category/add')
	    // 			// ->type('PHP', 'name')
	    // 			// ->type('HyperText PreProcessor', 'brief')
	    // 			->press('Add')
	    // 			;
	    // // dd($page);
    }

    public function testCategoryAddPageNoUser()
    {
    	$this->call('GET', 'category/add');

    	$this->assertResponseStatus(302);
    	$this->assertSessionHas('error', 'Please Login.');
    }

    public function testCategoryAddPageNoAdmin()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);

    	$this->actingAs($user)->call('GET', 'category/add');
    	$this->assertResponseStatus(302);
    	$this->assertSessionHas('error', 'Not Allowed.');
    }

    public function testCategoryAddIsOk()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$this->actingAs($user)->call('GET', 'category/add');
    	$this->assertResponseStatus(200);
    }

    public function testEditCategoryPageNoAuth()
    {
    	$this->call('GET', 'category/1/edit');
    	$this->assertResponseStatus(302);
    	$this->assertSessionHas('error', 'Please Login');
    }

    public function testCategoryEditIsOk()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$this->actingAs($user)->call('GET', 'category/1/edit');
    	$this->assertResponseStatus(200);

    	$category = TeachTech\Category::find(1);

    	$this->assertViewHas('category', $category);
    }

    public function testEditCategoryPageNoAdmin()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);

    	$this->actingAs($user)->call('GET', 'category/1/edit');

    	$this->assertResponseStatus(302);
    	$this->assertSessionHas('error', 'Not Allowed.');
    }

    public function testEditCategoryPageWrongOnwer()
    {
    	$this->createTTModels();
    	$user = factory(TeachTech\User::class)->create([
    		'id'	=> 100,
    	]);

    	$this->actingAs($user)->call('GET', 'category/1/edit');

    	$this->assertResponseStatus(302);
    	$this->assertSessionHas('error', 'Not Allowed.');
    }

    public function testCreateCategoryFails()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->actingAs($user)->call('POST', 'category/add', ['_token' => csrf_token(), 'name' => 'PHPPHPPHPPHPPHPPHPPHP', 'brief' => '']);
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    }

    public function testCreateCategoryValidationFails()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->actingAs($user)->call('POST', 'category/add', ['_token' => csrf_token(), 'name' => 'PHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHP', 'brief' => 'PHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHPPHP']);
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    }

    public function testCreateCategoryNoAuth()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->call('POST', 'category/add', ['_token' => csrf_token(), 'name' => 'PHPPHPPHPPHPPHPPHPPHP', 'brief' => '']);
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    }

    public function testUpdateCategory()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->actingAs($user)->call('POST', 'category/1/update', ['_token' => csrf_token(), 'name' => 'JWT', 'brief' => 'JSON WEB TOKEN']);
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    	$category = TeachTech\Category::find(1);
    	$name = $category->name;
    	$brief = $category->brief;
    	$this->assertEquals('JWT', $name);
    	$this->assertEquals('JSON WEB TOKEN', $brief);
    }

    public function testUpdateCategoryFails()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->actingAs($user)->call('POST', 'category/1/update', ['_token' => csrf_token(), 'name' => 'PHPPHPPHPPHPPHPPHPPHP', 'brief' => '']);
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    }

    public function testUpdateCategoryFailsWrongUser()
    {
    	$this->createTTModels();
    	$user = factory(TeachTech\User::class)->create([
    		'id'		=> 100,
    		'is_admin'	=> 1,
    	]);

    	$response = $this->actingAs($user)->call('POST', 'category/1/update', ['_token' => csrf_token(), 'name' => 'PHPPHPPHPPHPPHPPHPPHP', 'brief' => '']);
    	$this->assertSessionHas('error', 'Not Allowed.');
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    }

    public function testUpdateCategoryNoAuth()
    {
    	$this->createTTModels();
    	$user = TeachTech\User::find(1);
    	$user->is_admin = 1;

    	$response = $this->call('POST', 'category/1/update', ['_token' => csrf_token(), 'name' => 'PHPPHPPHPPHPPHPPHPPHP', 'brief' => '']);
    	$this->assertSessionHas('error', 'Not Allowed.');
    	$this->assertEquals(302, $response->status());

    	$categories = TeachTech\Category::all();
    	$count = count($categories);
    	$this->assertEquals(1, $count);
    }

    
}

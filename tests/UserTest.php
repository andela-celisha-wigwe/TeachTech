<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use org\bovigo\vfs\vfsStream as vfsStream;
use Laravel\Socialite;

class UserTest extends TestCase
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

    public function testUserRegisteration()
    {	
    	$page = $this->visit('/register')
    					->type('Roy', 'name')
    					->type('royally@example.com', 'email')
    					->type('teacher', 'password')
    					->type('teacher', 'password_confirmation')
    					->press('Register')
    					->seePageIs('home')
    					->see('Your Favored Videos')
    					;
    }

    public function testGuest()
    {
        $this->createTTModels();
        $user = TeachTech\User::find(1);

        $this/*->actingAs($user)*/->call('GET', 'guest');
    }

    public function testUserRegisterationFails()
    {	
    	$page = $this->visit('/register')
    					->type('Roy', 'name')
    					->type('royally@example.com', 'email')
    					->type('teacher', 'password')
    					->type('teachering', 'password_confirmation')
    					->press('Register')
    					->seePageIs('register')
    					->see('The password confirmation does not match.')
    					;
    }

    public function testUserLogin()
    {
    	$user = $this->createUser();
    	$page = $this->visit('/login')
    					->type('royally@example.com', 'email')
    					->type('teacher', 'password')
    					->press('Login')
    					->seePageIs('home')
    					->see('royally@example.com')
    					;
    }

    public function testUserLogout()
    {
	    $page = $this->visit('/logout')
	    				->see('Login')
	    				;
    }

    public function testUserLoginFails()
    {
    	$page = $this->visit('/login')
    					->type('royally@example.com', 'email')
    					->type('teacher', 'password')
    					->press('Login')
    					->seePageIs('login')
    					->see('These credentials do not match our records.')
    					;
    }

    public function testUserDashboard()
    {
    	$user = $this->createUser();
    	$this->actingAs($user)
            ->visit('/videos')
    		->click('Home')
    		->seePageIs('home')
    		;
    }

    public function testUserUpdate()
    {
        $this->createTTModels();
        $user = TeachTech\User::find(1);

        $data = [
            'name' => 'DaddyBoy',
            'email' => 'daddyboy@example.com',
            'password'  => bcrypt('daddyman'),
        ];

        $this->actingAs($user)->call('POST', 'user/update', $data);

        $user = TeachTech\User::find(1);

        $name = $user->name;
        $email = $user->email;
        $state = Hash::check('daddyman', $user->password);

        $this->assertEquals('DaddyBoy', $name);
        $this->assertEquals('daddyboy@example.com', $email);
        $this->assertTrue($state);
    }
// string $path, string $originalName, string $mimeType = null, int $size = null, int $error = null, bool $test = false
    public function testUserChangeAvatar()
    {   
        $file = $this->getNewFile();

        $uploadedFile = new \Symfony\Component\HttpFoundation\File\UploadedFile($file, 'test.jpg');
        $uploadedFile = m::mock('\Symfony\Component\HttpFoundation\File\UploadedFile', [$file, 'test', 'image/jpg', 200]);
        
        $data = [
            '_token' => csrf_token(),
            'file' => $uploadedFile,
        ];

        $this->call('POST', 'user/upload/avatar', $data);
    }

    public function testUserSocialLogin()
    {
        $response = $this->call('GET', 'auth/facebook');
        $target = $response->headers->get('location');
        $expectedTarget = 'https://www.facebook.com/v2.5/dialog/oauth?client_id=';
        $this->assertEquals($expectedTarget, substr($target, 0, 53));
        $this->assertResponseStatus(302);
    }

    public function testUserSocialLoginCallback()
    {
        $userMock = m::mock('TeachTech\User');
        // $return = m::mock('Symfony\Component\HttpFoundation\RedirectResponse', ['https://www.facebook.com/v2.5/dialog/oauth?client_id=602752246555102&redirect_uri=http%3A%2F%2Flocalhost%3A8888%2Fauth%2Ffacebook%2Fcallback&scope=email&response_type=code&state=yREbxevMp4zehuFXagOO9eEdLrhw0EJTd9Dd1nDG']);
        // $return->shouldReceive('user')->once()->andReturn($userMock);
        $response = $this->call('GET', 'auth/facebook/callback');
        // $response = $this->visit('auth/facebook/callback');
        // $target = $response->headers->get('location');
        // dd($response->status());
        // $expectedTarget = 'https://www.facebook.com/v2.5/dialog/oauth?client_id=';
        // $this->assertEquals($expectedTarget, substr($target, 0, 53));
        // $this->assertResponseStatus(302);
    }

    public function getNewFile()
    {
        return __DIR__ . '/testprofile.jpg';
    }

    public function notestUserChangeAvatar()
    {
    	$cloudConfig = m::mock('\Cloudinary');
    	$cloudConfig->shouldReceive('config')->with([
    		'cloud_name'  => 'dax1lcajn',
	    	'api_key'     => '724974163436624',
	    	'api_secret'  => 'LEGPtwbA-YFzAbfRsbOSK4Dvodc',

    	]);
    	$uploader = m::mock('\Cloudinary\Uploader');
    	$uploader->shouldReceive('upload')->with([

    	]);
    	$user = $this->createUser();
    	$page = $this->actingAs($user)
	            ->visit('/home')
	    		->click('Change Avatar')
	    		->attach(__DIR__ . '/testprofile.jpg', 'file')
	    		->press('Upload')
	    		->seePageIs('home')
	    		;
        $this->assertResponseStatus(200);
        $location = $this->$page->headers->get('location');
        // dd($location);
	    // dd($page);
    }

    public function notestSocialLogin()
    {
    	// $redirectMock = m::mock('Illuminate\Http\RedirectResponse');
    	$redirectingTo = 'https://api.twitter.com/oauth/authenticate?oauth_token=Yt8VTgAAAAAAuwx4AAABVHOyzAU';
    	
    	$redirectMock = m::mock('\Symfony\Component\HttpFoundation\RedirectResponse');
    	$facebookMock = m::mock('Laravel\Socialite\One\TwitterProvider');
    	$socialiteMock = m::mock('Laravel\Socialite\SocialiteManager');
    	// $socialiteMock = m::mock('Laravel\Socialite\SocialiteServiceProvider');
    	$socialiteMock->shouldReceive('driver')->with('twitter')->andReturn($facebookMock);
    	$facebookMock->shouldReceive('redirect')->andReturn($redirectMock);
    	
    	$this->visit('auth/twitter')
			// ->see($redirectMock)    	
    		;

    	$this->assertRedirectedToRoute('auth/twitter/callback');
    }
}

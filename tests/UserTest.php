<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use org\bovigo\vfs\vfsStream as vfsStream;
use Laravel\Socialite;
use org\bovigo\vfs\content\LargeFileContent;

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
        $response = $this->call('GET', '/auth/github/callback?code=0a591670ba41f938a161&state=JTvXrZ1Qkpp70mIQVehXegNnw761GMKSeVhbq9t4');
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

    public function testUserChangeAvatar()
    {
        // $fileName = 'test.jpg';
        // $root = vfsStream::setup('home');
        // $path = vfsStream::url('home/');
        // $file = vfsStream::newFile($fileName)
        //                 ->withContent(LargeFileContent::withKilobytes(100))
        //                 ->at($root)
        //                 ->setContent($content = '');
        // $filePath = $path.'/'.$fileName;

        // $uploadedFile = m::mock('Illuminate\Http\UploadedFile', [$filePath, $fileName, 'image/jpg', 5000000]);
        
        $file = __DIR__ . '/testprofile.jpg';
        $uploadedFile = new Illuminate\Http\UploadedFile(__DIR__ . '/testprofile.jpg', 'test.jpg', 'image/jpeg', 200, null, true);
        $uploadedFile;
        $user = $this->createUser();
    	$page = $this->actingAs($user)
	            ->visit('/home')
	    		->click('Change Avatar')
	    		->attach($uploadedFile, 'file')
	    		->press('Upload')
	    		// ->seePageIs('home')
	    		;
        $page = $this->assertResponseStatus(200);
        // $location = $this->$page->headers->get('location');
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

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
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

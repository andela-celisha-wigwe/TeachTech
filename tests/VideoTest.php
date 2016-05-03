<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
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

    public function testVideoIndex()
    {
    	$category = $this->createCategory();
    	$this->visit('/videos')
    		->seePageIs('videos')
    		->see('All Categories')
    		->see('MsDotNet');
    }

    public function testAddVideo()
    {
    	$user = $this->createUser();
    	$category = $this->createCategory();
	    $page =	$this->actingAs($user)
		    		->visit('/videos')
					->type('A new title', 'title')
					->type('https://www.youtube.com/watch?v=3oT9PQcFZKc', 'url')
					->type('A new description', 'description')
					->select(1, 'category_id')
					->press('Add')
					->seePageIs('home')
					->see('A new title')
		    		;
    }

    public function testVideoShowWithoutAuthUser()
    {
    	$this->createVideo();
    	$this->visit('video/1')
                ->see('roy')
    			->see('A Introduction to MsDotNet')
    			;	
        $this->countElements('.video-user', 1);
    }

    public function testVideoShowWithAuthUser()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1')
                ->see('roy')
    			->see('A Introduction to MsDotNet')
    			->see('Very nice introduction to the MS-Dot-Net Framework.')
    			;
    }

    public function testVideoEditPage()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1/edit')
    			->see('A Introduction to MsDotNet')
    			->see('This is an introduction to the Microsoft DotNet Framework. It is very powerful.')
    			->see('Save')
    			;
    }

    public function testVideoUpdate()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1/edit')
	    		->type('An updated title for the video', 'title')
				->type('https://www.youtube.com/watch?v=3oT9PQcFZKc', 'url')
				->type('This is the updated description of the video.', 'description')
				->press('Save')
				->seePageIs('video/1/edit')
				->see('An updated title for the video')
    			->see('This is the updated description of the video.')
    			->see('Save')
    			;
    }

    public function notestVideoSearch()
    {
    	$this->createVideo();
    	$this->visit('/videos')
    			->type('Introdu', 'search')
    			->press("Search")
    			->seePageIs('/videos')
    			->see()
    			;
    }

    public function testVideoLike()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
    	$video = TeachTech\Video::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1')
	    		->see('Like')
	    		->press('Like')
	    		->seePageIs('video/1')
	    		->see('Unlike')
    			;
    	$status = $user->favors($video);
    	$this->assertEquals(1, $status);
    }

    public function testVideoUnLike()
    {
    	$video = $this->createVideo();
    	$favorite = $this->createFavoriteFor($video);

    	$user = TeachTech\User::find(1);
    	$video = TeachTech\Video::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1')
	    		->see('Unlike')
	    		->press('Unlike')
	    		->seePageIs('video/1')
	    		->see('Like')
    			;
    	$status = $user->favors($video);
    	$this->assertEquals(0, $status);
    }

    public function testVideoDelete()
    {
        $this->createTTModels();

        $user = TeachTech\User::find(1);
        $page = $this->actingAs($user)
                ->visit('home')
                ->see('Delete')
                ->click('Delete')
                ->seePageIs('home')
                ->see('Video Deleted')
                ;

        // $this->assertSessionHas('success', 'Video Deleted');
        $this->countElements('.delete_video', 0);
        $video = TeachTech\Video::find(1);
        $this->assertEquals(null, $video);
    }

    public function testVideoNotDeletedByWrongUser()
    {
        $this->createTTModels();

        factory(TeachTech\User::class)->create([
            'id' => 100,
        ]);

        $user = TeachTech\User::find(100);
        $page = $this->actingAs($user)
                ->visit('video/1/delete')
                ->seePageIs('videos')
                ->see('Not allowed')
                ;
    }

}

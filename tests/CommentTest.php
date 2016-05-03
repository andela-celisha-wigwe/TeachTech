<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
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

    public function testCommentsOnVideos()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
    	$page = $this->actingAs($user)
    			->visit('video/1')
    			;
    	$this->countElements('.comment_comment', 1);
    	$this->countElements('.like-model', 2);
    	$this->countElements('.like-comment', 1);
    }

    public function testCommentCreate()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
    	$page = $this->actingAs($user)
    			->visit('video/1')
    			->type('This is another comment', 'comment')
    			->press('POST')
    			->see('This is another comment')
    			;
    	$this->countElements('.comment_comment', 2);
    	$this->countElements('.like-model', 3);
    	$this->countElements('.like-comment', 2);
    }

    public function notestCommentLike()
    {

    	$this->createTTModels();
    	$favorite = $this->createFavoriteFor($video);

    	$user = TeachTech\User::find(1);
    	$comment = TeachTech\Comment::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1')
	    		// ->see('Like')
	    		// ->press('Like')
	    		// ->seePageIs('video/1')
	    		// ->see('Unlike')
    			;
    	$count = $this->crawler->filter($selector);
    	$status = $user->favors($video);
    	$this->assertEquals(1, $status);
    }

    public function notestCommentUnLike()
    {
    	$comment = $this->createComment();
    	$favorite = $this->createFavoriteFor($comment);

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
}

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteTest extends TestCase
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

    public function testFavorite()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
    	$video = TeachTech\Video::find(1);
    	$favorite = $this->createFavoriteFor($video);
    	$favVid = $favorite->favoritable;
    	$this->assertEquals($video, $favVid);
    }

    public function testFavoriter()
    {
    	$this->createTTModels();

    	$user = TeachTech\User::find(1);
    	$comment = TeachTech\Comment::find(1);
    	$favorite = $this->createFavoriteFor($comment);
    	$favOwner = $favorite->favoriter();
    	$this->assertEquals($user, $favOwner);
    }
}

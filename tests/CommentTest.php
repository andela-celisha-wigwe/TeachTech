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

    public function testCommentCreateFailsNoComment()
    {
        $this->createTTModels();

        $user = TeachTech\User::find(1);
        $page = $this->actingAs($user)
                ->visit('video/1')
                ->type('', 'comment')
                ->press('POST')
                ->seePageIs('video/1')
                ->see('The comment field is required.')
                ;
        $this->countElements('.comment_comment', 1);
        $this->countElements('.like-model', 2);
        $this->countElements('.like-comment', 1);
    }

    public function testCommentCreateFailsCommentTooLong()
    {
        $this->createTTModels();

        $user = TeachTech\User::find(1);
        $page = $this->actingAs($user)
                ->visit('video/1')
                ->type('sdlkfjbnslkdfjbnlks dnflkbjnlsdnfkblksndlkvbn lsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsksdlkfjbnslkdfjbnlksdnflkbjnlsdnfkblksndlkvbnlsk', 'comment')
                ->press('POST')
                ->seePageIs('video/1')
                ->see('The comment may not be greater than 255 characters')
                ;
    }

    public function testUserComments()
    {
        $this->createTTModels();
        $anotherComment = factory(TeachTech\Comment::class)->create([
            'user_id'       => 1,
        ]);

        $user = TeachTech\User::find(1);
        $comments = $user->comments()->get();
        $this->assertEquals(2, count($comments));
    }

    public function testUserVideos()
    {
        $this->createTTModels();
        $video1 = TeachTech\Video::find(1);
        $video2 =   factory(TeachTech\Video::class)->create([
                        'user_id'       => 1,
                    ]);

        $this->createFavoriteFor($video1);
        $this->createFavoriteFor($video2);
        
        $user = TeachTech\User::find(1);
        $favVidoes = $user->favoritedVideos();
        $this->assertEquals(2, count($favVidoes));
    }

    public function testCommentLike()
    {
    	$this->createTTModels();
        $comment = TeachTech\Comment::find(1);
        $video = TeachTech\Video::find(1);
    	$favorite = $this->createFavoriteFor($video);

    	$user = TeachTech\User::find(1);
    	$comment = TeachTech\Comment::find(1);
	    $page =	$this->actingAs($user)
	    		->visit('video/1')
                ->press('Like')
                ->seePageIs('video/1')
    			;

        $user = TeachTech\User::find(1);
        $status = $user->favors($comment);
        $this->assertEquals(1, $status);
    }

    public function testCommentUnLike()
    {
    	$this->createTTModels();
        $comment = TeachTech\Comment::find(1);
        $favorite = $this->createFavoriteFor($comment);

        $user = TeachTech\User::find(1);
        $comment = TeachTech\Comment::find(1);
        $page = $this->actingAs($user)
                ->visit('video/1')
                ->see('Unlike')
                ->press('Unlike')
                ->seePageIs('video/1')
                ;

        $user = TeachTech\User::find(1);
        $status = $user->favors($comment);
        $this->assertEquals(0, $status);
    }

    public function testCommentVideo()
    {
        $this->createTTModels();
        $comment = TeachTech\Comment::find(1);

        $video_id = $comment->video->id;
        $this->assertEquals(1, $video_id);
    }

    public function testCommentFavorites()
    {
        $this->createTTModels();
        $comment = TeachTech\Comment::find(1);
        $this->createFavoriteFor($comment);

        $favorites = $comment->favorites();
        $this->assertEquals(1, count($favorites));
    }

    public function testCommentDestroy()
    {
        $this->createTTModels();

        $response = $this->call('DELETE', '/comment/1/delete', ['_token' => csrf_token()])
                    ;
        $comment = TeachTech\Comment::find(1);
        $this->assertEquals(null, $comment);
    }

    public function testCommentEdit()
    {
        $this->createTTModels();

        $response = $this->call('PATCH', '/comment/1/update', ['_token' => csrf_token(), 'comment' => 'This is the updated comment.']);
        $comment = TeachTech\Comment::find(1);
        $text = $comment->comment;
        $this->assertEquals('This is the updated comment.', $text);

    }

    public function testCommentUpdateValidationFails()
    {
        $this->createTTModels();
        $data = [
            '_token'    => csrf_token(),
            'comment'   => '',
        ];

        $response = $this->call('PATCH', '/comment/1/update', ['_token' => csrf_token(), 'comment' => '']);
        $comment = TeachTech\Comment::find(1);
        $text = $comment->comment;
        $this->assertEquals('Very nice introduction to the MS-Dot-Net Framework.', $text);

    }
}

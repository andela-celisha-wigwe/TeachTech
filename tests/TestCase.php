<?php

use org\bovigo\vfs\vfsStream as vfsStream;
use Mockery as m;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    private $vfsRoot;
    private $vfsFile;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Default preparation for each test
     */
    public function setUp()
    {
        parent::setUp();
     
        $this->prepareForTests();
    }

    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     */
    private function prepareForTests()
    {
        Artisan::call('migrate');
    }

    protected function createUser()
    {
        $user = factory(TeachTech\User::class)->create([
            'name'      => 'roy',
            'email'     => 'royally@example.com',
            'password'  => bcrypt('teacher'),
        ]);
        return $user;
    }

    protected function createCategory()
    {
        $category = factory(TeachTech\Category::class)->create([
            'name'      => 'MsDotNet',
            'user_id'   => 1,
            'brief'     => 'This section deals with lessons on MsDotNet.'
        ]);
        return $category;
    }

    protected function createVideo()
    {
        $this->createCategory();
        $video = $this->createUser()->videos()->create([
            'title'         => 'A Introduction to MsDotNet',
            'url'           => 'https://www.youtube.com/watch?v=wCA6jCUbaFQ',
            'description'   => 'This is an introduction to the Microsoft DotNet Framework. It is very powerful.',
            'category_id'   => 1,
        ]);
        return $video;
    }

    public function createComment()
    {
        $comment = factory(TeachTech\Comment::class)->create([
            'comment'   => 'Very nice introduction to the MS-Dot-Net Framework.',
            'video_id'  => 1,
            'user_id'   => 1,
        ]);
        return $comment;
    }

    public function createTTModels()
    {
        $this->createVideo();
        $this->createComment();
    }

    public function createFavoriteFor($model)
    {
        $favorite = factory(TeachTech\Favorite::class)->create([
            'user_id' => 1,
            'favoritable_id'    => 1,
            'favoritable_type'  => get_class($model),
            'status'            => 1,
        ]);

        return $favorite;
    }

    /**
    * Verify the number of dom elements
    * @param  string   $selector the dom selector (jquery style)
    * @param  int      $number   how many elements should be present in the dom
    * 
    * @return $this
    */
    public function countElements($selector, $number)
    {
        $this->assertCount($number, $this->crawler->filter($selector));

        return $this;
    }

    public function createMockFile($name = null, $extention = null)
    {
        // $uploadedFile = new \Symfony\Component\HttpFoundation\File\UploadedFile(codecept_data_dir().'/attachments/temporary/' . 'test', 'test', 'image/jpg', 200);
        
        // $file = m::mock(\Symfony\Component\HttpFoundation\File\UploadedFile::class, [
        //     'getClientOriginalName'      => $name . $extention,
        //     'getClientOriginalExtension' => $extention,
        // ]);

        // $this->vfsRoot = vfsStream::setup('home');
        // // $path = vfsStream::url('home/' . $name . '.' . $extention);
        // $this->vfsFile = vfsStream::url('home/config.ini');

        $root = vfsStream::setup('home');
        $path = vfsStream::url('home/config.ini');

        // // $a = scandir($path);
        // // dd($a);
        // $file = fopen("vfs://home/config.ini", 'a');

        return $path;
    }
}

<?php

$parts=parse_url($_SERVER['REQUEST_URI']);

$path_parts=explode('/', $parts['path']);

$stub = $path_parts[1];

/*                  check if wordpress posts exists
|-------------------------------------------------------------------------- */

$isWordpress = false;
$username = 'username';
$password = 'password';

mysql_connect('localhost', $username, $password) or die('Could not connect: ' . mysql_error());


try {
    $conn = new PDO('mysql:host=localhost;dbname=whyPress', $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$id = 5;

try {
    $conn = new PDO('mysql:host=localhost;dbname=database', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('SELECT * FROM wp_posts WHERE post_name = :stub');
    $stmt->execute(array('stub' => $stub));

    while($row = $stmt->fetch()) {
        $isWordpress = true;
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

/*|--------------------------------------------------------------------------*/


if ($isWordpress == true AND $stub != "")
{
    /**
     * Front to the WordPress application. This file doesn't do anything, but loads
     * wp-blog-header.php which does and tells WordPress to load the theme.
     *
     * @package WordPress
     */

    /**
     * Tells WordPress to load the WordPress theme and output it.
     *
     * @var bool
     */
    define('WP_USE_THEMES', true);

    /** Loads the WordPress Environment and Template */
    require( dirname( __FILE__ ) . '/wp-blog-header.php' );
}
else
{

    /**
     * Laravel - A PHP Framework For Web Artisans
     *
     * @package  Laravel
     * @author   Taylor Otwell <taylorotwell@gmail.com>
     */

    /*
    |--------------------------------------------------------------------------
    | Register The Auto Loader
    |--------------------------------------------------------------------------
    |
    | Composer provides a convenient, automatically generated class loader for
    | our application. We just need to utilize it! We'll simply require it
    | into the script here so that we don't have to worry about manual
    | loading any of our classes later on. It feels nice to relax.
    |
    */


    require __DIR__.'/../bootstrap/autoload.php';

    /*
    |--------------------------------------------------------------------------
    | Turn On The Lights
    |--------------------------------------------------------------------------
    |
    | We need to illuminate PHP development, so let us turn on the lights.
    | This bootstraps the framework and gets it ready for use, then it
    | will load up this application so that we can run it and send
    | the responses back to the browser and delight our users.
    |
    */

    $app = require_once __DIR__.'/../bootstrap/app.php';


    /*
    |--------------------------------------------------------------------------
    | Run The Application
    |--------------------------------------------------------------------------
    |
    | Once we have the application, we can handle the incoming request
    | through the kernel, and send the associated response back to
    | the client's browser allowing them to enjoy the creative
    | and wonderful application we have prepared for them.
    |
    */

    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');

    $response = $kernel->handle(
	    $request = Illuminate\Http\Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);
}
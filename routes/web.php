<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Post;
use App\User;
use App\Role;
use App\Country;
use App\Photo;
use App\Tag;

Route::get('/', function () {
    return view('welcome');
});

//
//Route::get('/nesto', function () {
//    return 'nesto';
//});


use Illuminate\Support\Facades\DB;

Route::get('/insert', function (){

    DB::insert('insert into posts(title, content, is_admin) values(?,?,?)', ['php with laravel' , 'laravel si the best',1]);
});

Route::get('/read', function() {

    $rez = DB::select('select * from posts');

       foreach($rez as $rezults){
           echo "<div>". $rezults->title ."</div>";
        }

});


Route::get('/update', function(){

    $update = DB::update('update posts set title="update title" where id=?', [1]);

    return $update;

});


Route::get('/delete' , function() {

    $delete = DB::delete('delete from posts where id=?',[1]);

    return $delete;

});




/*
 * ELOQUEN ORM
 *
 *
 */

//Route::get('/find', function() {

 //   $posts = App\Post::all();
//    $posts = Post::all();
//
//    foreach($posts as $post){
//
//        return $post->title;
//    }
//

//    $posts = Post::find(2);
//
//    return $posts->title;
//
//
//});

Route::get('/findwhere', function(){

    $posts = Post::where('id', 2)->orderBy('id', 'desc')->take(1)->get();


    return $posts;


});


/*Route::get('/findmore', function (){

    // vraca exeption
   $posts = Post::findOrFail(1);
    return $posts;





 //   $posts = Post::where('user_count', '<', 50)->firstOrFail();

});*/

Route::get(/**
 *
 */
    '/basicinsert', function (){

    $post = new Post;
    $post->user_id = 1;
    $post->title = 'new tittle';
    $post->content = 'new content';
    $post->is_admin = 1;
  //  $post->created_at = date_create('now')->format('Y-m-d H:i:s');

    $post->save();

});




Route::get('/prema_id_update/{id}', function ($id){

    $post = Post::find($id);

    $post->title = 'new tittle update';
    $post->content = 'new content update';
    $post->is_admin = 1;
    //  $post->created_at = date_create('now')->format('Y-m-d H:i:s');

    $post->save();

});



Route::get('/create', function(){

    Post::create([
        'user_id'=> 1,
        'title' => 'the creat method',
        'content' => 'ovo je neki sadrzaj',
        'is_admin'=> 1
    ]);

});



Route::get('/update' , function(){

    Post::where('id', 15)->where('is_admin', 1)->update([

        'title'=>'updejtovan',
        'content'=>'update content'
    ] );

});


Route::get('/delete', function(){

    $post=Post::find(14);
    $post->delete();

});

Route::get('/delete2', function(){

    Post::destroy(10);


});

Route::get('/delete3', function(){

    Post::destroy(16, 15, 13);


});


Route::get('/delete4', function(){

    Post::where([

        'id'=>12,
        'is_admin'=>1
    ])->delete();


});


Route::get('/softdelete', function(){

     Post::find(17)->delete();

});



Route::get('/prikazi_obrisan_red_softdelete', function (){

/*    $post = Post::withTrashed()->where('id',9)->get();


     return $post;
*/


 /*  $post = Post::onlyTrashed()->where('id', 17)->get();

    return $post;
 */




  $post = Post::onlyTrashed()->get();

    return $post;





});

Route::get('/restore', function(){


    Post::withTrashed()->where('id',9)->restore();

});


// RELACIJE U ELOKVENTU

// 'one to one' relacija
// hasOne
// u modelu user se nalazi deo post metod koji iz tabele vraca sadrzaj

Route::get ('/user/{id}/post', function($id){

// return User::find($id)->post;
    return User::find($id)->post->title;

});

// invers pronadji korisnika posta "one to one ralation"

Route::get('/post/{id}/user' , 'PostController@showUserPost' );

Route::get('/post/{id}/user', function($id) {

    return Post::find($id)->user->name;
});



// ONE TO MENY RELACIJA

Route::get('/posts/{id}', function ($id) {  // prosladjuje se user id

    $posts = User::find($id)->posts; // posts je metod koji se nalazi u modelu User

   foreach($posts as $post) {

       echo $post->title;
   }
});



// MENY TO MENY  NA PRIMER USER ROLE


// vraca ceo objekat  iz role tabele pod $id - em
/*Route::get('/user/{id}/role', function($id){

    $user = User::find($id);

    foreach($user->roles as $role){
        echo $role;
    }

});
*/


// vraca ime odnosno  'name' kolonu iz 'roles' tabele
/*
Route::get('/user/{id}/role', function($id){

    $user = User::find($id);

    foreach($user->roles as $role){
       $ime = $role->name;
        echo $ime;

    }
    if ($ime == 'admin'){
        echo '  admin je smrad';
     }


});

*/

Route::get('/user/{id}/role' , function($id){

    $user = User::find($id)->roles()->orderBy('id', 'desc')->get();


   return $user;

});

// pristupanje pivot tabeli

Route::get('user/pivot/{id}', function($id){

    $user = User::find($id);

    foreach($user->roles as $role ){
        echo $role->pivot->created_at;
    }
});



// has meny through relation
// vrace sve postove svih usera  koji su i neke drzave 'country_id'

Route::get('/user/country/{id}', function($id){

    $country = Country::find($id);

    foreach($country->posts as $post){

        echo "naslov". $post->title."<br>";
    }
});


// polimorfna relacije

Route::get('user/photos/{id}', function($id) {

    $user = User::find($id);



    foreach($user->photos as $photo) {

        echo $photo->path . "<br>";
    }


});


Route::get('post/photos', function() {

    $post =  Post::find(1);



    foreach($post->photos as $photo) {

        echo $photo->path . "<br>";
    }


});




//--------------------------------------------


//return image

Route::get ('/image/{id}', function($id){

    $img = Photo::find($id);

    return $img->path;

    //return Photo::find($id)->post->title;

});


//return image verijanta 2

Route::get ('/imageVarijanta2/{id}', 'PhotoController@returnImgPath' );



//Polimorfna meny to meny relacija




Route::get ('/post/tag/{id}', function ($id) {

    $post = Post::find($id);

    foreach($post->tags as $tag) {
       echo $tag->name;
    }

});


Route::get('/tag/post/{id}' , function($id){

    $tag = Tag::find($id);

    try {

        foreach ($tag->posts as $post) {

            echo $post->title . '<br>';
        }

    } catch (Exception $e) {
        echo  '<h1>'. 'nesto je poslo pogresno'.'</h1>';
    }

});

//Polimorfna meny to meny relacija END




Route::get('/user/{id}/role', 'PostController@vratiHuligana');



Route::get('/contact', 'PostController@contact');

Route::get('/show' , 'PostController@show');

Route::get('/post/{id}/{ime}/{prezime}', 'PostController@Show_post');


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class PostController extends Controller
{

public function __construct()
{
        $this->middleware('auth');
}


public function store(Request $request)
{		
		//Data Validation
    	$validatedData = $request->validate([
        'title' => 'required|unique:posts|max:255',
        'description' => 'required',
        'tag' => 'required',
        'author' => 'required|min:4|max:40',
    ]);

    $post= new Post;
    $post->title = $request->title;
    $post->author = $request->author;
    $post->tag = $request->tag;
    $post->description = $request->description;

    $post->save();

    if ($post->save()) {
    	$notification = array(
    'message' => 'Post Added Successfully!',
    'alert-type' => 'success'
	);
		return Redirect()->back()->with($notification, 'Post Added Successfully!');
    }
    else{
    	return Redirect()->back;
    }
}


public function AllPost()
{
    	$post=Post::all();
    	return view('all_post')->with('post',$post);

    	// Post Preview
    	//echo "<pre>";
    	//print_r($post);
    	//exit();

    	// if order by dese 
    	// $post=Post::orderBy('id','DESC')->get();
}


public function Delete($id)
{

    $post = Post::find($id);
    $delete=$post->delete();

    if ($delete) {
    	$notification = array(
    'message' => 'Post Delete Successfully!',
    'alert-type' => 'error'
	);
		return Redirect()->back()->with($notification, 'Post Delete Successfully!');
    }
    else{
    	return redirect('/home');
    }

	//Preview
	//$post = Post::find($id);
	//return $post;
}


public function Edit($id)
{
	$post = Post::findorfail($id);
	return view('editpost',compact('post'));
}

public function Update(Request $request, $id)
{
	//Data Validation
    	$validatedData = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'tag' => 'required',
        'author' => 'required|min:4|max:40',
    ]);
    	$post = Post::findorfail($id);
    	$post->title = $request->title;
    	$post->author = $request->author;
    	$post->tag = $request->tag;
    	$post->description = $request->description;
    	$update=$post->save();

    if ($update) {
    	$notification = array(
    'message' => 'Post Update Successfully!',
    'alert-type' => 'info'
	);
		return Redirect()->route('home')->with($notification, 'Post Update Successfully!');
    }
    else{
    	return Redirect()->back;
    }
}

}

<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Image;
use Storage;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable to store all the blog posts in it from the database
        $posts = Post::orderBy('id', 'DESC')->paginate(5);

        // return a view and pass in the blog variable
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create')
            ->with('categories', $categories)
            ->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
            'title'             => 'required | max:255',
            'slug'              => 'required | alpha_dash | min:5 | max:255 | unique:posts,slug',
            'category_id'       => 'required | integer',
            'body'              => 'required',
            'featured_image'    => 'sometimes | image'
        ));

        //save the post to the database
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        if ($request->hasFile('featured_image'))
        {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $post->image = $filename;
        }

        $post->save();

        $post->tags()->sync($request->tags, false);

        //set flash message
        Session::flash('success', 'The Blog post was successfully saved');

        //redirect to show the view
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the post in the database and save as a var
        $post = Post::find($id);
        $categories = Category::all();
        $cats = [];
        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }

        // return the view and pass in the var we previously created
        return view('posts.edit')
            ->with('post', $post)
            ->with('categories', $categories)
            ->with('Categories', $cats)
            ->with('tags', $tags2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
        $post = Post::find($id);

        $this->validate($request, array(
            'title'         => 'required | max:255',
            'slug'          => "required|alpha_dash|min:5|max:255|unique:posts,slug,$id",
            'category_id'   => 'required | integer',
            'body'          => 'required',
            'featured_image' => 'image'
        ));

        // Save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        if ($request->hasFile('featured_image')) {
            // add new photo
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);
            $oldFilename = $post->image;

            //update the database
            $post->image = $filename;

            //delete the image
            Storage::delete($oldFilename);
        }

        $post->save();

        if(isset($request->tags)) {
            $post->tags()->sync($request->tags, false);
        } else {
            $post->tags()->sync(array());
        }

        // set flash data with success message
        Session::flash('success', 'This post was successfully updated');

        // redirect with flash data t posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        Storage::delete($post->image);

        $post->delete();

        Session::flash('success', 'The post was successfully deleted');

        return redirect()->route('posts.index');
    }
}

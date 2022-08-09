<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    //
    public function index(){
        
        //$posts = Post::get();

        /* $posts = Post::orderBy('id', 'DESC')->paginate(3); */
        $posts = Post::latest()->paginate(3);
        /* $posts = Post::all(); */

        //dd($posts);

        return view('admin.posts.index', compact('posts'));

        /* return view('admin.posts.index', 
            [
                'posts' => $posts,
            ]
        ); */
    }

    public function create(){
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request){


        $data = $request->all();
        
        if($request->image->isValid()){
        
            $imageFile = Str::of($request->title)->slug('-').'.'.$request->image->getClientOriginalExtension();
            $image = $request->image->storeAs("posts", $imageFile);
            $data['image'] = $image;

            Post::create($data);
        
        }


        
        /* $post = Post::create($request->all()); */
        /* return redirect('/posts'); */
        return redirect()->route('posts.index')
                         ->with('message', 'Post criado com sucesso!!!');

    }

    public function show($id){
        
        /* $post = Post::where('id', $id)->first(); */
        if(!$post = Post::find($id))
            return redirect()->route('posts.index');
        
        return view('admin.posts.show', compact('post'));
    }
    
    public function destroy($id){
        
        if(!$post = Post::find($id))
            return redirect()->route('posts.index');

            if(Storage::exists($post->image))
                Storage::delete($post->image);

        $post->delete();

        return redirect()->route('posts.index')->with('message', 'Post Deletado Com Sucesso!!!');
    }

    # /* return redirect()->route('posts.index'); */
    public function edit($id){
        if(!$post = Post::find($id)){
            return redirect()->back();
        }
        
        return view('admin.posts.edit', compact('post'));

    }

    public function update(StoreUpdatePost $request, $id){
             
        if(!$post = Post::find($id))
            return redirect()->route('posts.index');
        
        /* $data = $request->all();
         */

        $data = $request->except(['_token']);

        if($request->image && $request->image->isValid()){
            if(Storage::exists($post->image)){
                Storage::delete($post->image);
        
                $imageFile = Str::of($request->title)->slug('-').'.'.$request->image->getClientOriginalExtension();
                $image = $request->image->storeAs("posts", $imageFile);
                $data['image'] = $image;
    
               /*  Post::create($data); */
            
            }
    
            
            /*Apenas para mais informações:
            Post::update()->where();
            $post->update($request->all()); */
    
            /* $dados = $request->except(['_token']); */
            Post::where('id', $id)->update($data);
    
            return redirect()->route('posts.index')->with('message', 'Post Atualizado Com Sucesso!!!');
        }
        
            
    }

    public function search(Request $request){

        /* dd("Pesquisando por {$request->search}"); */

        $filters = $request->except('_token');


        /* $posts = Post::where('title', '=', $request->search) */
        $posts = Post::where('title',  'LIKE', "%{$request->search}%")
                                            ->orWhere('content', 'LIKE', "%{$request->search}%")
                                            ->paginate(3);
        /* toSql()
        get()
        paginate() */

        return view('admin.posts.index', compact('posts', 'filters'));
        
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Postmeta;
use App\Models\Term;
use App\Models\term_relationships;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    function __construct()
    {
        $allposts = Post::all();
        $allcategories = Term::where('type','category')->get();
        $status = Term::where('type','status')->get();
        $tags = Term::where('type','tag')->get();
        view()->share('allPosts',$allposts);
        view()->share('categories',$allcategories);
        view()->share('tags',$tags);
        view()->share('status',$status);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }
    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('posts.list_posts');
    }
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('posts.list_posts');
    }

    //status
    public function status(Request $request)
    {
        session(['status' => $request->status]);
        return redirect()->route('posts.list_posts');
    }
    //check
    public function checkValidate(Request $request)
    {

        $this->validate($request,
        [
            'title' =>'required|min:3|unique:posts,title,'.$request->id.',id',
            'img' =>'image',
            'content'=> 'required'
        ],
        [
            'title.required' =>'bạn không thể bỏ trống tiêu đề',
            'title.min' =>'ít nhất từ 3 đến 100 ký tự',
            'title.unique' =>'Tiêu đề đã tồn tại',
            'img.image' =>'Chọn đúng định dạng file ảnh',

        ]);
    }
    //list Posts
    public function listPosts()
    {
        if(session()->has('sort') && session()->has('status')){
            $posts = Post::where([["post_type","boards"],['status',session('status')]])->orderBy('title',session('sort'))->paginate(session('limit'));
        }elseif(session()->has('sort') && !session()->has('status')){
            $posts = Post::where("post_type","boards")->orderBy('title',session('sort'))->paginate(session('limit'));
        }elseif(!session()->has('sort') && session()->has('status')){
            $posts = Post::where([["post_type","boards"],['status',session('status')]])->paginate(session('limit'));
        }else{
            $posts = Post::where("post_type","boards")->paginate(session('limit'));
        }

        $count = Post::where("post_type","boards")->count();
        return view('admin.posts.listPosts',['posts'=>$posts,'count'=>$count]);
    }

    public function getAddPost()
    {
        return view('admin.posts.addPost');
    }

    public function postAddPost(Request $request)
    {

        $this->checkValidate($request);
        $this->validate($request,
        [
            'title' =>'required|min:3|unique:posts,title',
        ]);
        $post = new Post;
        $post->title= $request->title;
        $post->content= $request->content;
        $post->post_parent= $request->postParent;
        $post->post_type= "boards";
        $post->comment_count= 0;
        $post->status= $request->status;
        $post->author= Auth::user()->id;
        $post->save();

        if ($request->hasFile('img')) {
            $postmeta = new Postmeta;
            $postId = Post::max('id');
            $postmeta->post_id= $postId;
            $path='admin_asset/image/upload/'.Carbon::now()->year.'/'.Carbon::now()->month;
            if(!file_exists($path)){
                $result= mkdir($path,0777,true);
            }
            $file = $request->file('img');
            $name =$file->getClientOriginalName();
            while(!file_exists($path.'/'.$name)){
                $file->move($path.'/',$name);
            }
            $postmeta->meta_key ="meta_image";
            $postmeta->meta_value = Carbon::now()->year.'/'.Carbon::now()->month.'/'.$name;
            $postmeta->save();
        }

        //add boards
        $postId = Post::max('id');
        $term_relationships = new term_relationships;
        $term_relationships->post_id= $postId;
        $term_relationships->term_id= $request->category;
        $term_relationships->save();

        //add status

        $statusPost = new term_relationships;
        $statusPost->post_id= $postId;
        $statusPost->term_id= $request->statuses;
        $statusPost->save();
        if(isset($request->tags)){
            foreach($request->tags as $tag){
                $tags= Term::where('type','tag')->pluck('name')->toArray();
                if(!in_array($tag, $tags)){
                    $category = new Term;
                    $category->name= $tag;
                    $category->type= "tag";
                    $category->parent=0;
                    $category->slug = Str::slug($tag,'-');
                    $category->save();
                }
            }
            $postId = Post::max('id');
            $tagsArr= Term::whereIn('name',$request->tags)->pluck('id');
            foreach($tagsArr as $value){
                $categoryPost = new term_relationships;
                $categoryPost->post_id= $postId;
                $categoryPost->term_id= $value;
                $categoryPost->save();
            }
        }

        return redirect('admin/posts/add-post')->with('message','Thêm thành công');
    }
    public function getEditPost($id)
    {
        $post = Post::find($id);

        return view('admin.posts.editPost',['post'=>$post]);
    }

    public function postEditPost(Request $request)
    {
        $this->checkValidate($request);
        $post = Post::find($request->id);
        $post->title= $request->title;
        $post->post_type= "boards";
        $post->content= $request->content;
        $post->post_parent= $request->postParent;
        $post->status= $request->status;
        $post->save();
        $hasMetapost= Postmeta::where([['post_id',$request->id],['meta_key','meta_image']])->first();
        if(isset($hasMetapost)){
            if ($request->hasFile('img')) {
                $path='admin_asset/image/upload/'.Carbon::now()->year.'/'.Carbon::now()->month;
                if(!file_exists($path)){
                    $result= mkdir($path,0777,true);
                }
            $file = $request->file('img');
            $name =$file->getClientOriginalName();
            while(!file_exists($path.'/'.$name)){
                $file->move($path.'/',$name);
            }
            $meta_image = Carbon::now()->year.'/'.Carbon::now()->month.'/'.$name;
            $metapost= Postmeta::where([['post_id',$request->id],['meta_key','meta_image']])->update(['meta_value'=>$meta_image]);
            }
            else{
                if($request->getImg != ""){
                    $metapost= Postmeta::where([['post_id',$request->id],['meta_key','meta_image']])->update(['meta_value'=>$request->getImg]);
                }else{
                    Postmeta::where([['post_id',$request->id],['meta_key','meta_image']])->delete();
                }
            }
        }else{
            if ($request->hasFile('img')) {
                $postmeta = new Postmeta;
                $postmeta->post_id= $request->id;
                $path='admin_asset/image/upload/'.Carbon::now()->year.'/'.Carbon::now()->month;
                if(!file_exists($path)){
                    $result= mkdir($path,0777,true);
                }
                $file = $request->file('img');
                $name =$file->getClientOriginalName();
                while(!file_exists($path.'/'.$name)){
                    $file->move($path.'/',$name);
                }
                $postmeta->meta_key="meta_image";
                $postmeta->meta_value = Carbon::now()->year.'/'.Carbon::now()->month.'/'.$name;
                $postmeta->save();
            }
        }
        $deleteCategoryPost = term_relationships::where('post_id',$request->id)->delete();

        $categoryPost = new term_relationships;
        $categoryPost->post_id= $request->id;
        $categoryPost->term_id= $request->category;
        $categoryPost->save();

        //add status
        $statusPost = new term_relationships;
        $statusPost->post_id= $request->id;
        $statusPost->term_id= $request->statuses;
        $statusPost->save();

        if(isset($request->tags)){
            foreach($request->tags as $tag){
                $tags= Term::where('type','tag')->pluck('name')->toArray();
                if(!in_array($tag, $tags)){
                    $category = new term;
                    $category->name= $tag;
                    $category->type= "tag";
                    $category->parent=0;
                    $category->slug = Str::slug($tag,'-');
                    $category->save();
                }
            }
            $tagsArr= Term::whereIn('name',$request->tags)->pluck('id');
            foreach($tagsArr as $value){
                $categoryPost = new term_relationships;
                $categoryPost->post_id= $request->id;
                $categoryPost->term_id= $value;
                $categoryPost->save();
            }
        }
        return redirect('admin/posts/edit-post/'.$request->id)->with('message','Update thành công');
    }

    public function deletePost($id)
    {
        Comment::where('post_id',$id)->delete();
        $categoriesPosts= term_relationships::where('post_id',$id)->delete();
        Postmeta::where('post_id',$id)->delete();
        $postParent= Post::where('post_parent',$id)->update(['post_parent'=>0]);
        $post = Post::find($id);
        $post->delete();
        return redirect('admin/posts/list-posts')->with('message','Deleted successfully');
    }

    public function searchPosts(Request $request)
    {
        $posts = Post::where('title','like',"%$request->search%")->paginate(session('limit'));
        $count = Post::where('title','like',"%$request->search%")->count();
        return view('admin.posts.listPosts',['posts'=>$posts,'count'=>$count]);

    }

    public function bulkActionPosts(Request $request)
    {
        if($request->select=="public"){
            if(!empty($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>"public"]);
                return redirect()->route('posts.list_posts')->with('message',"$posts Changed successfully");
            }else{
                return redirect()->route('posts.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="verified"){
            if(isset($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>'verified']);
                return redirect()->route('posts.list_posts')->with('message',"$posts Changed successfully");
            }else{
                return redirect()->route('posts.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="private"){
            if(isset($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>'private']);
                return redirect()->route('posts.list_posts')->with('message',"$posts Changed successfully");
            }else{
                return redirect()->route('posts.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="delete"){
            if(isset($request->check)){
                Comment::whereIn('post_id',$request->check)->delete();
                $categoryPost = term_relationships::whereIn('post_id',$request->check)->delete();
                Postmeta::whereIn('post_id',$request->check)->delete();
                $postParent = Post::whereIn('post_parent',$request->check)->update(['post_parent'=>0]);

                $posts= Post::whereIn('id',$request->check)->delete();
                return redirect()->route('posts.list_posts')->with('message',"Deleted successfully");
            }else{
                return redirect()->route('posts.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else{
            return redirect()->route('posts.list_posts')->with('message','chọn một tùy chọn');
        }
    }

    public function test(Request $request)
    {
        echo Carbon::now()->year;
    }
}

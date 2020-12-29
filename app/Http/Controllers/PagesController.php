<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Postmeta;
use App\Models\Term;
use App\Models\term_relationships;
use App\Models\Usermeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    //
    public function __construct()
    {
        $allTerms = Term::all();
        $allPosts = Post::all();
        $userMeta = DB::table('usermeta')->get();
        $changelog = Term::find(130);
        //view()->share(['allCategories'=>$allCategories,'$allPosts'=>$allPosts]);
        view()->share('allPosts',$allPosts);
        view()->share('allTerms',$allTerms);
        view()->share('userMeta',$userMeta);
        view()->share('changelog',$changelog);
    }
    //filter categories
    public function filterCategories(Request $request)
    {
        session(['filterCategories' => $request->categories]);
        return redirect()->route('home.list_changelog');
    }
    //filter tag
    public function filterTags(Request $request)
    {
        session(['filterTags' => $request->tags]);
        return redirect()->route('home.list_changelog');
    }
    public function listCategories()
    {
        $categories = Term::where([['type','category'],['parent','!=',99]])->get();
        return view('pages.listCategories',['categories'=>$categories]);
    }
    public function home()
    {
        $categories = Term::where([['type','category'],['parent','!=',99]])->get();
        $allRoadmaps= Post::where('post_type','roadmaps')->get();
        return view('pages.home',['categories'=>$categories,'allRoadmaps'=>$allRoadmaps]);
    }

    public function listPosts(Request $request)
    {
        if(isset($request->search)){
            $posts = Post::where([['post_type','boards'],['title','like',"%$request->search%"]])->paginate(5);
        }else{
            $posts = Post::where([['post_type','boards']])->paginate(5);
        }
        return view('pages.listPosts',['posts'=>$posts]);
    }
    public function listChangelog()
    {
        $changelog = Term::find(130);
        if(Auth::check() && Auth::user()->role ==2 && Auth::user()->confirmed ==1){
            if(session()->has('filterCategories') && session()->has('filterTags')){
                $postIdCategories = term_relationships::whereIn('term_id',session('filterCategories'))->pluck('post_id')->toArray();
                $postIdTags = term_relationships::whereIn('term_id',session('filterTags'))->pluck('post_id')->toArray();
                $postId = array_intersect($postIdCategories,$postIdTags);
                $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
            }else if(session()->has('filterCategories') && !session()->has('filterTags')){
                $postId = term_relationships::whereIn('term_id',session('filterCategories'))->pluck('post_id');
                $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
            }else if(!session()->has('filterCategories') && session()->has('filterTags')){
                $postId = term_relationships::whereIn('term_id',session('filterTags'))->pluck('post_id');
                $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
            }else{
                $posts = Post::where([['post_type','changelog']])->paginate(5);
                $postId = Post::where([['post_type','changelog']])->pluck('id');
            }
            //get existing tags
            $termExis = DB::table('term_relationships')->whereIn('post_id',$postId)->pluck('term_id')->toArray();
            //count all posts by categories and tags
            $allPostId = Post::where([['post_type','changelog']])->pluck('id');
            $termRelationships = DB::table('term_relationships')->whereIn('post_id',$allPostId)->pluck('term_id')->toArray();
            $countPosts=array_count_values($termRelationships);
            return view('pages.changelog_list_posts',['posts'=>$posts,'termExis'=>$termExis,'countPosts'=>$countPosts]);
        }elseif(Auth::check() && Auth::user()->confirmed ==1){
            if($changelog->status != 'private'){
                if(session()->has('filterCategories') && session()->has('filterTags')){
                    $postIdCategories = term_relationships::whereIn('term_id',session('filterCategories'))->pluck('post_id')->toArray();
                    $postIdTags = term_relationships::whereIn('term_id',session('filterTags'))->pluck('post_id')->toArray();
                    $postId = array_intersect($postIdCategories,$postIdTags);
                    $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
                }else if(session()->has('filterCategories') && !session()->has('filterTags')){
                    $postId = term_relationships::whereIn('term_id',session('filterCategories'))->pluck('post_id');
                    $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
                }else if(!session()->has('filterCategories') && session()->has('filterTags')){
                    $postId = term_relationships::whereIn('term_id',session('filterTags'))->pluck('post_id');
                    $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
                }else{
                    $posts = Post::where([['post_type','changelog']])->paginate(5);
                    $postId = Post::where([['post_type','changelog']])->pluck('id');
                }
                //get existing tags
                $termExis = DB::table('term_relationships')->whereIn('post_id',$postId)->pluck('term_id')->toArray();
                //count all posts by categories and tags
                $allPostId = Post::where([['post_type','changelog']])->pluck('id');
                $termRelationships = DB::table('term_relationships')->whereIn('post_id',$allPostId)->pluck('term_id')->toArray();
                $countPosts=array_count_values($termRelationships);
                return view('pages.changelog_list_posts',['posts'=>$posts,'termExis'=>$termExis,'countPosts'=>$countPosts]);
            }else{
                return redirect()->route('listPosts');
            }
        }else{
            if($changelog->status == 'public'){
                if(session()->has('filterCategories') && session()->has('filterTags')){
                    $postIdCategories = term_relationships::whereIn('term_id',session('filterCategories'))->pluck('post_id')->toArray();
                    $postIdTags = term_relationships::whereIn('term_id',session('filterTags'))->pluck('post_id')->toArray();
                    $postId = array_intersect($postIdCategories,$postIdTags);
                    $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
                }else if(session()->has('filterCategories') && !session()->has('filterTags')){
                    $postId = term_relationships::whereIn('term_id',session('filterCategories'))->pluck('post_id');
                    $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
                }else if(!session()->has('filterCategories') && session()->has('filterTags')){
                    $postId = term_relationships::whereIn('term_id',session('filterTags'))->pluck('post_id');
                    $posts = Post::whereIn('id',$postId)->where('post_type','changelog')->paginate(5);
                }else{
                    $posts = Post::where([['post_type','changelog']])->paginate(5);
                    $postId = Post::where([['post_type','changelog']])->pluck('id');
                }
                //get existing tags
                $termExis = DB::table('term_relationships')->whereIn('post_id',$postId)->pluck('term_id')->toArray();
                //count all posts by categories and tags
                $allPostId = Post::where([['post_type','changelog']])->pluck('id');
                $termRelationships = DB::table('term_relationships')->whereIn('post_id',$allPostId)->pluck('term_id')->toArray();
                $countPosts=array_count_values($termRelationships);
                return view('pages.changelog_list_posts',['posts'=>$posts,'termExis'=>$termExis,'countPosts'=>$countPosts]);
            }else{
                return redirect()->route('listPosts');
            }
        }

    }
    public function search(Request $request)
    {
        $posts = Post::where('title','like',"%$request->search%")->orWhere('summary','like',"%$request->search%")->paginate(5);
        $popularPosts= Post::where('status',1)->inRandomOrder()->take(5)->get();
        return view('pages.searchPosts',['popularPosts'=>$popularPosts,'posts'=>$posts]);
    }

    public function categoryDetails($key,Request $request)
    {   if($key == 'none'){
            $key = $request->filterCategory;
        }
        $category = Term::where('slug',$key)->first();
        return view('pages.category_details',['category'=>$category]);
    }

    public function postDetails($id)
    {
        $popularPosts= Post::where([['status','!=','private'],['post_type','boards'],['id','!=',$id]])->inRandomOrder()->take(5)->get();
        $postDetail = Post::find($id);
        $commentsPost = Comment::where("post_id",$id)->get();
        if(Auth::check() && Auth::user()->role ==2 && Auth::user()->confirmed ==1){
            if($postDetail->status !='pending'){
                return view('pages.postDetail',['postDetail'=>$postDetail,'popularPosts'=>$popularPosts,'commentsPost'=>$commentsPost]);
            }else{
                return redirect()->route('listPosts');
            }
        }else{
            if($postDetail->status == 'public'){
                return view('pages.postDetail',['postDetail'=>$postDetail,'popularPosts'=>$popularPosts,'commentsPost'=>$commentsPost]);
            }else{
                return redirect()->route('listPosts');
            }
        }
    }

    public function changelogDetails($id)
    {
        $changelog = Term::find(130);
        $popularPosts= Post::where([['status','!=','private'],['post_type','boards'],['id','!=',$id]])->inRandomOrder()->take(5)->get();
        $postDetail = Post::find($id);
        $commentsPost = Comment::where("post_id",$id)->get();
        if(Auth::check() && Auth::user()->role ==2 && Auth::user()->confirmed ==1){
            if($postDetail->status !='pending'){
                return view('pages.postDetail',['postDetail'=>$postDetail,'popularPosts'=>$popularPosts,'commentsPost'=>$commentsPost]);
            }else{
                return redirect()->route('listPosts');
            }
        }elseif(Auth::check() && Auth::user()->role !=2 && Auth::user()->confirmed == 1){
            if($changelog->status != 'private' && $postDetail->status == 'public'){
                return view('pages.postDetail',['postDetail'=>$postDetail,'popularPosts'=>$popularPosts,'commentsPost'=>$commentsPost]);
            }else{
                return redirect()->route('listPosts');
            }
        }else{
            if($changelog->status == 'public' && $postDetail->status == 'public'){
                return view('pages.postDetail',['postDetail'=>$postDetail,'popularPosts'=>$popularPosts,'commentsPost'=>$commentsPost]);
            }else{
                return redirect()->route('listPosts');
            }
        }
    }

    public function allRoadmaps(){
        $allRoadmaps= Post::where('post_type','roadmaps')->get();
        return view('pages.all_roadmaps',['allRoadmaps'=>$allRoadmaps]);
    }

    //vote

    public function upvote(Request $request){
        if(Auth::check()){
            $metaUser = new Usermeta;
            $metaUser->user_id = Auth::user()->id;
            $metaUser->meta_key = 'vote_post';
            $metaUser->meta_value = $request->postId;
            $metaUser->save();
            $post = Post::find($request->postId);
            $post->vote_count = $post->vote_count + 1;
            $post->save();
            return redirect()->back();
        }else{
            return redirect()->route('login');
        }

    }
    public function unvote(Request $request){
        $userMeta=Usermeta::find($request->id);
        $userMeta->delete();
        $post = Post::find($request->postId);
        $post->vote_count = $post->vote_count - 1;
        $post->save();
        return redirect()->back();
    }

    public function createPost(Request $request){
        dd($request->img);
        $validation = Validator::make($request->all(), [
            'content' => 'required',
            'img' =>'image',
            'title' =>'required|min:3|unique:posts,title',
           ]);
           if($validation->fails()){
            return response()->json([
                'status' => 0,
                'errors' => $validation->errors()]);
           }else{
            $post = new Post;
            $post->title= $request->title;
            $post->content= $request->content;
            $post->post_parent= 0;
            $post->post_type= "boards";
            $post->comment_count= 0;
            $post->status= 'public';
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
            $statusPost->term_id= 1;
            $statusPost->save();
            return response()->json([
                'status' => 1,
                'url' => route('postDetail',['id'=>$postId])]);
           }
    }
}

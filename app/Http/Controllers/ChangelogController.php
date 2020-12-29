<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Postmeta;
use App\Models\Term;
use App\Models\term_relationships;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChangelogController extends Controller
{
    //
    function __construct()
    {
        $allcategories = Term::where('type','category')->get();
        $allposts = Post::all();
        $tags = Term::where('type','tag')->get();
        view()->share('allPosts',$allposts);
        view()->share('tags',$tags);
        view()->share('categories',$allcategories);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }
    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('changelog.list_posts');
    }
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('changelog.list_posts');
    }

    //status
    public function status(Request $request)
    {
        session(['status' => $request->status]);
        return redirect()->route('changelog.list_posts');
    }
    //check
    public function checkValidate(Request $request)
    {

        $this->validate($request,
        [
            'title' =>'required|min:3|unique:posts,title,'.$request->id.',id',
            'img' =>'image',
            'content' =>'required',
        ],
        [
            'title.required' =>'bạn không thể bỏ trống tiêu đề',
            'title.min' =>'ít nhất từ 3 đến 100 ký tự',
            'title.unique' =>'Tiêu đề đã tồn tại',
            'img.image' =>'Chọn đúng định dạng file ảnh',

        ]);
    }
    //list Posts
    public function index()
    {
        if(session()->has('sort') && session()->has('status')){
            $changelog = Post::where([["post_type","changelog"],['status',session('status')]])->orderBy('title',session('sort'))->paginate(session('limit'));
        }elseif(session()->has('sort') && !session()->has('status')){
            $changelog = Post::where("post_type","changelog")->orderBy('title',session('sort'))->paginate(session('limit'));
        }elseif(!session()->has('sort') && session()->has('status')){
            $changelog = Post::where([["post_type","changelog"],['status',session('status')]])->paginate(session('limit'));
        }else{
            $changelog = Post::where([["post_type","changelog"]])->paginate(session('limit'));
        }

        $count = Post::where("post_type","changelog")->count();
        return view('admin.changelog.list_changelog',['changelog'=>$changelog,'count'=>$count]);
    }

    public function create()
    {
        return view('admin.changelog.add_changelog');
    }

    public function store(Request $request)
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
        $post->post_type= "changelog";
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

        return redirect()->route("changelog.get_add_posts")->with('message','Thêm thành công');
    }
    public function edit($id)
    {
        $post = Post::find($id);

        return view('admin.changelog.edit_changelog',['post'=>$post]);
    }
    public function update(Request $request)
    {
        $this->checkValidate($request);
        $post = Post::find($request->id);
        $post->title= $request->title;
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
        return redirect()->route("changelog.get_edit_posts",['id'=>$request->id])->with('message','Update thành công');
    }

    public function destroy($id)
    {
        Comment::where('post_id',$id)->delete();
        $categoriesPosts= term_relationships::where('post_id',$id)->delete();
        Postmeta::where('post_id',$id)->delete();
        $postParent= Post::where('post_parent',$id)->update(['post_parent'=>0]);
        $post = Post::find($id);
        $post->delete();
        return redirect()->route("changelog.list_posts")->with('message','Deleted successfully');
    }

    public function searchPosts(Request $request)
    {
        $changelog  = Post::where([['post_type','changelog'],['title','like',"%$request->search%"]])->paginate(session('limit'));
        $count = Post::where([['post_type','changelog'],['title','like',"%$request->search%"]])->count();
        return view('admin.changelog.list_changelog',['changelog'=>$changelog,'count'=>$count]);

    }

    public function bulkActionPosts(Request $request)
    {
        if($request->select=="public"){
            if(!empty($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>"public"]);
                return redirect()->route('changelog.list_posts')->with('message',"$posts bài viết đã được public");
            }else{
                return redirect()->route('changelog.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="verified"){
            if(isset($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>"verified"]);
                return redirect()->route('changelog.list_posts')->with('message',"$posts bài viết đã được verified");
            }else{
                return redirect()->route('changelog.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="private"){
            if(isset($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>"private"]);
                return redirect()->route('changelog.list_posts')->with('message',"$posts bài viết đã được private");
            }else{
                return redirect()->route('changelog.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="delete"){
            if(isset($request->check)){
                Comment::whereIn('post_id',$request->check)->delete();
                $categoryPost = term_relationships::whereIn('post_id',$request->check)->delete();
                Postmeta::whereIn('post_id',$request->check)->delete();
                $postParent = Post::whereIn('post_parent',$request->check)->update(['post_parent'=>0]);

                $posts= Post::whereIn('id',$request->check)->delete();
                return redirect()->route('changelog.list_posts')->with('message',"Deleted successfully");
            }else{
                return redirect()->route('changelog.list_posts')->with('messageWarning',"Nothing selected");
            }

        }else{
            return redirect()->route('changelog.list_posts')->with('message','chọn một tùy chọn');
        }
    }

    public function settingChangelog()
    {
        $changelog = Term::find(130);
        return view('admin.changelog.setting_changelog',['changelog'=>$changelog]);
    }

    public function updateSettingChangelog(Request $request)
    {
        DB::table('terms')->where('id',130)->update(['status'=> $request->status]);
        return redirect()->route('setting_changelog')->with('message','Changelog setting saved');
    }
}

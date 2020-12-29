<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    function __construct()
    {
        $allComments = Comment::all();
        view()->share('allComments',$allComments);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }
    public function removeComment($id,$post_id)
    {
        Comment::where('comment_parent',$id)->delete();
        $comment = Comment::find($id);
        $comment->delete();
        $countCmt= Comment::where("post_id",$post_id)->count();
        Post::where("id",$post_id)->update(["comment_count"=>$countCmt]);
        return redirect()->route("postDetail",["id"=>$post_id]);
    }
    public function getComment(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        return json_encode($comment);
    }

    public function addComment(Request $request)
    {
        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->author = Auth::user()->id;
        $comment->comment_content = $request->content;
        if($request->parent_id){
            $comment->comment_parent=$request->parent_id;
        }else{
            $comment->comment_parent= 0;
        }
        $comment->comment_status= 1;

        $comment->save();
        $countCmt= Comment::where("post_id",$request->post_id)->count();
        Post::where("id",$request->post_id)->update(["comment_count"=>$countCmt]);
        return redirect()->route("postDetail",["id"=>$request->post_id]);
    }

    public function postUpdateComment(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'content' =>'required',
           ]);

           if($validation->fails()){
            return response()->json([
                'status' => 0,
                'errors' => $validation->errors()]);
           }else{
                $comment = Comment::find($request->id);
                $comment->comment_content= $request->content;
                $comment->save();
                return response()->json([
                    'status' => 1
                    ]);
           }
    }

    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('listComments');
    }
    //sort
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('listComments');
    }

    public function listComments()
    {
        if(session()->has('sort')){
            $comments = Comment::orderBy('comment_content',session('sort'))->paginate(session('limit'));
        }else{
            $comments = Comment::paginate(session('limit'));
        }
        $count = Comment::count();
        return view('admin.comments.listComments',['comments'=>$comments,'count'=>$count]);
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        $post_id=$comment->post_id;

        Comment::where('comment_parent',$id)->delete();
        Comment::where("id",$id)->delete();
        $countCmt= Comment::where("post_id",$post_id)->count();
        Post::where("id",$post_id)->update(["comment_count"=>$countCmt]);

        return redirect()->route('listComments')->with('message','Deleted successfully');
    }

    public function searchComments(Request $request)
    {
        $comments = Comment::where('comment_content','like',"%$request->search%")->paginate(session('limit'));
        $count = Comment::where('comment_content','like',"%$request->search%")->count();
        return view('admin.comments.listComments',['comments'=>$comments,'count'=>$count]);

    }

    public function bulkActionComments(Request $request)
    {
        if($request->select=="delete"){
            if(isset($request->check)){
                Comment::whereIn('comment_parent',$request->check)->delete();
                Comment::whereIn('id',$request->check)->delete();
                return redirect()->route('listComments')->with('message',"Delete successfully");
            }else{
                return redirect()->route('listComments')->with('messageWarning',"Nothing selected");
            }
        }else{
            return redirect()->route('listComments')->with('message','chọn một tùy chọn');
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Term;
use App\Models\term_relationships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoadmapsController extends Controller
{
    //
    function __construct()
    {
        $allcategories = Term::where('type','category')->get();
        $status = Term::where('type','status')->get();
        view()->share('status',$status);
        view()->share('categories',$allcategories);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }
    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('listRoadmaps');
    }
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('listRoadmaps');
    }

    //status
    public function status(Request $request)
    {
        session(['status' => $request->status]);
        return redirect()->route('listRoadmaps');
    }

    //list roadmap
    public function listRoadMaps()
    {
        if(session()->has('sort') && session()->has('status')){
            $roadMaps = Post::where([['post_type', "roadmaps"],['status',session('status')]])->orderBy('title',session('sort'))->paginate(session('limit'));
        }else if(session()->has('sort') && !session()->has('status')){
            $roadMaps = Post::where('post_type', "roadmaps")->orderBy('title',session('sort'))->paginate(session('limit'));
        }else if(!session()->has('sort') && session()->has('status')){
            $roadMaps = Post::where([['post_type', "roadmaps"],['status',session('status')]])->paginate(session('limit'));
        }else{
            $roadMaps = Post::where('post_type', "roadmaps")->paginate(session('limit'));
        }
        $count = Post::where('post_type', "roadmaps")->count();
        return view('admin.roadmaps.listRoadMaps',['roadmaps'=>$roadMaps,'count'=>$count]);
    }

    public function getAddRoadmaps()
    {
        return view('admin.roadmaps.addRoadMap');
    }

    public function postAddRoadmaps(Request $request)
    {

        $this->validate($request,
        [
            'title' =>'required|min:3|unique:posts,title',
            'statuses' =>'required|min:2|max:4',
        ],
        [
            'statuses.min' => 'Please select from 2 to 4 statuses for this roadmap.',
            'statuses.max' => 'Please select from 2 to 4 statuses for this roadmap.',
        ]);
        $roadmap = new Post;
        $roadmap->title= $request->title;
        $roadmap->summary= $request->summary;
        $roadmap->content= null;
        $roadmap->post_parent= 0;
        $roadmap->post_type= "roadmaps";
        $roadmap->comment_count= 0;
        $roadmap->status= $request->status;
        $roadmap->author= Auth::user()->id;
        if(isset($request->showon)){
            $roadmap->show = 1;
        }
        $roadmap->save();

        //add statuses
        $roadmapid = Post::where('title',$request->title)->first();

        if(isset($request->statuses)){
            foreach($request->statuses as $value){
                $relationships = new term_relationships;
                $relationships->post_id= $roadmapid->id;
                $relationships->term_id= $value;
                $relationships->save();
            }
        }
        //add category
        if(isset($request->boards)){
            foreach($request->boards as $value){
                $relationships = new term_relationships;
                $relationships->post_id= $roadmapid->id;
                $relationships->term_id= $value;
                $relationships->save();
            }
        }
        return redirect()->route("listRoadmaps")->with('message','Thêm thành công');
    }

    public function getEditRoadmaps($id)
    {
        $roadmaps = Post::find($id);

        return view('admin.roadmaps.editRoadMap',["roadmaps"=>$roadmaps]);
    }

    public function postEditRoadmaps(Request $request)
    {

        $this->validate($request,
        [
            'title' =>'required|min:3|unique:posts,title,'.$request->id.',id',
            'statuses' =>'required|min:2|max:4',
        ],
        [
            'statuses.min' => 'Please select from 2 to 4 statuses for this roadmap.',
            'statuses.max' => 'Please select from 2 to 4 statuses for this roadmap.',
        ]);
            $roadmap = Post::find($request->id);
            $roadmap->title = $request->title;
            $roadmap->summary = $request->summary;
            $roadmap->status = $request->status;
            if(isset($request->showon)){
                $roadmap->show = 1;
            }else{
                $roadmap->show = 0;
            }
            $roadmap->save();

        //add categories
        $deleteStatuses = Term_relationships::where('post_id',$request->id)->delete();
        if(isset($request->statuses)){
            foreach($request->statuses as $value){
                $relationships = new term_relationships;
                $relationships->post_id= $request->id;
                $relationships->term_id= $value;
                $relationships->save();
            }
        }
        if(isset($request->boards)){
            foreach($request->boards as $value){
                $relationships = new term_relationships;
                $relationships->post_id= $request->id;
                $relationships->term_id= $value;
                $relationships->save();
            }
        }

        return redirect()->route("getEditRoadmaps",['id'=>$request->id])->with('message','Updated successfully');
    }

    public function deleteRoadmaps($id)
    {
        $categoriesPosts= Term_relationships::where('post_id',$id)->delete();
        $post = Post::find($id);
        $post->delete();
        return redirect()->route("listRoadmaps")->with('message','Deleted successfully');

    }

    public function searchRoadmaps(Request $request)
    {
        $roadMaps = Post::where([['post_type', "roadmaps"],['title','like',"%$request->search%"]])->paginate(session('limit'));
        $count = Post::where([['post_type', "roadmaps"],['title','like',"%$request->search%"]])->count();
        return view('admin.roadmaps.listRoadMaps',['roadmaps'=>$roadMaps,'count'=>$count]);

    }

    public function bulkActionRoadmaps(Request $request)
    {
        if($request->select=="active"){
            if(!empty($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>1]);
                return redirect()->route('listRoadmaps')->with('message',"$posts Actived successfully");
            }else{
                return redirect()->route('listRoadmaps')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="deactive"){
            if(isset($request->check)){
                $posts= Post::whereIn('id',$request->check)->update(['status'=>0]);
                return redirect()->route('listRoadmaps')->with('message',"$posts bài viết đã được deactive");
            }else{
                return redirect()->route('listRoadmaps')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="delete"){
            if(isset($request->check)){
                $categoryPost = Term_relationships::whereIn('post_id',$request->check)->delete();
                $roadmaps= Post::whereIn('id',$request->check)->delete();
                return redirect()->route('listRoadmaps')->with('message',"Deleted successfully");
            }else{
                return redirect()->route('listRoadmaps')->with('messageWarning',"Nothing selected");
            }

        }else{
            return redirect()->route('listRoadmaps')->with('message','chọn một tùy chọn');
        }
    }
}

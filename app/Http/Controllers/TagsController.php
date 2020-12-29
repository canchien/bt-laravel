<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Term;
use App\Models\term_relationships;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    //
    function __construct(Request $request)
    {
        $categories = Term::all();
        view()->share('categories',$categories);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }

    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('listTags');
    }
    //sort
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('listTags');
    }

    public function listTags()
    {
        if(session()->has('sort')){
            $tags = Term::where('type','tag')->orderBy('name',session('sort'))->paginate(session('limit'));
        }else{
            $tags = Term::where('type','tag')->paginate(session('limit'));
        }
        $count = Term::where('type','tag')->count();
        return view('admin.tags.listTags',['tags'=>$tags,'count'=>$count]);
    }

    public function deleteTag($id)
    {
        $tagsPosts= Term_relationships::where("term_id",$id)->delete();
        $tag = Term::find($id);
        $tag->delete();
        return redirect()->route('listTags')->with('message','Deleted successfully');
    }

    public function searchTags(Request $request)
    {
        $tags = Term::where([['name','like',"%$request->search%"],['type','tag']])->paginate(session('limit'));
        $count = $tags->count();
        return view('admin.tags.listTags',['tags'=>$tags,'count'=>$count]);

    }

    public function bulkActionTags(Request $request)
    {
        if($request->select=="delete"){
            if(isset($request->check)){
                $tagsPosts= term_relationships::whereIn('term_id',$request->check)->delete();
                $result= Term::whereIn('id',$request->check)->delete();
                return redirect()->route('listTags')->with('message',"Delete successfully");
            }else{
                return redirect()->route('list-categories')->with('messageWarning',"Nothing selected");
            }
        }else{
            return redirect()->route('listTags')->with('message','chọn một tùy chọn');
        }
    }
}

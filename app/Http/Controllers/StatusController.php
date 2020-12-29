<?php

namespace App\Http\Controllers;
use App\Models\Term;
use App\Models\term_relationships;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatusController extends Controller
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
        return redirect()->route('listStatus');
    }
    //sort
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('listStatus');
    }

    public function checkValidate(Request $request)
    {

        $this->validate($request,
        [
            'name' =>'required|min:3|max:255|unique:terms,name',

        ],
        [
            'name.required' =>'bạn không thể bỏ trống tên status',
            'name.min' =>'tên status ít nhất ít nhất từ 3 đến 255 ký tự',
            'name.max' =>'tên status ít nhất ít nhất từ 3 đến 255 ký tự',
            'name.unique' =>'status đã tồn tại',
        ]);
    }

    public function listStatus()
    {
        if(session()->has('sort')){
            $status = Term::where('type','status')->orderBy('name',session('sort'))->paginate(session('limit'));
        }else{
            $status = Term::where('type','status')->paginate(session('limit'));
        }
        $count = Term::where('type', "status")->count();
        return view('admin.status.Liststatus',['status'=>$status,'count'=>$count]);
    }

    public function getAddStatus()
    {
        return view('admin.status.Addstatus');
    }
    public function postAddStatus(Request $request)
    {
        $this->checkValidate($request);
        $status = new Term;
        $status->name= mb_strtolower($request->name,"UTF-8");
        $status->term_description= $request->color;
        $status->parent= 0;
        $status->type= "status";
        $status->status= 'public';
        $status->slug = Str::slug($request->name,'-');
        $status->save();
        return redirect()->route('getAddStatus')->with('message','Thêm thành công');
    }
    public function aaa(){
        echo "écasa";
    }
    public function getEditStatus($id)
    {
        $status = Term::find($id);
        return view('admin.status.Editstatus',['status'=>$status]);
    }
    public function postEditStatus(Request $request)
    {

        $this->validate($request,
        [
            'name' =>'required|min:3|max:255|unique:terms,name,'.$request->id.',id',
        ],
        [
            'name.required' =>'bạn không thể bỏ trống tên status',
            'name.min' =>'tên status ít nhất ít nhất từ 3 đến 255 ký tự',
            'name.max' =>'tên status ít nhất ít nhất từ 3 đến 255 ký tự',
            'name.unique' =>'status đã tồn tại',
        ]);
        $status = Term::find($request->id);
        $status->name= mb_strtolower($request->name);
        $status->term_description= $request->color;
        $status->status= 'public';
        $status->slug = Str::slug($request->name, '-');

        $status->save();
        return redirect()->route("getEditStatus",["id"=>$request->id])->with('message','Updated successfully');
    }

    public function deleteStatus($id)
    {
        $categoriesPosts= term_relationships::where("term_id",$id)->delete();
        $status = Term::find($id);
        $status->delete();
        return redirect()->route("listStatus")->with('message','Deleted successfully');
    }

    public function searchCategories(Request $request)
    {
        $categories = Term::where([['name','like',"%$request->search%"],['type','category']])->paginate(session('limit'));

        return view('admin.categories.listCategories',['categories'=>$categories]);

    }

    public function bulkActionStatus(Request $request)
    {
        if($request->select=="delete"){
            if(isset($request->check)){
                $categoriesPosts= term_relationships::whereIn('term_id',$request->check)->delete();
                $categoriesParent = Term::whereIn('parent',$request->check)->update(['parent'=>0]);
                $result= Term::whereIn('id',$request->check)->delete();
                return redirect()->route('listStatus')->with('message',"Deleted successfully");
            }else{
                return redirect()->route('listStatus')->with('messageWarning',"Nothing selected");
            }
        }else{
            return redirect()->route('listStatus')->with('message','chọn một tùy chọn');
        }
    }
}

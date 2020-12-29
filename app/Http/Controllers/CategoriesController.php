<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Term;
use App\Models\term_relationships;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    function __construct(Request $request)
    {
        $posts = Post::all();
        $categories = Term::all();
        view()->share('posts',$posts);
        view()->share('categories',$categories);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }
    public function show()
    {
        dd(session('limit'));
        echo $this->limit;
        return $this->limit;
    }
    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('list-categories');
    }
    //sort
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('list-categories');
    }

    public function checkValidate(Request $request)
    {

        $this->validate($request,
        [
            'name' =>'required|min:3|max:255|unique:terms,name',
            'img' =>'image',
        ],
        [
            'name.required' =>'bạn không thể bỏ trống tên thể loại',
            'name.min' =>'tên thể loại ít nhất ít nhất từ 3 đến 255 ký tự',
            'name.max' =>'tên thể loại ít nhất ít nhất từ 3 đến 255 ký tự',
            'name.unique' =>'thể loại đã tồn tại',
        ]);
    }

    public function listCategories()
    {
        if(session()->has('sort')){
            $categories = Term::where([['type','category'],['parent','!=',99]])->orderBy('name',session('sort'))->paginate(session('limit'));
        }else{
            $categories = Term::where([['type','category'],['parent','!=',99]])->paginate(session('limit'));
        }

        return view('admin.categories.listCategories',['categories'=>$categories]);
    }
    public function test(){
        $rs=DB::table('posts')->pluck('title');
        dd($rs);
    }
    public function getAddCategory()
    {
        return view('admin.categories.addCategory');
    }
    public function postAddCategory(Request $request)
    {

        $this->checkValidate($request);
        $category = new Term;
        $category->name= mb_strtolower($request->name,"UTF-8");
        $category->parent= $request->parent;
        $category->status= $request->status;
        $category->type= "category";
        $category->slug = Str::slug($request->name,'-');
        if(isset($request->showon)){
            $category->show = 1;
        }

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
            $category->image = Carbon::now()->year.'/'.Carbon::now()->month.'/'.$name;
        }
        else{
            $category->image = null;
         }
        $category->save();
        return redirect('admin/categories/add-category')->with('message','Thêm thành công');
    }
    public function getEditCategory($id)
    {
        $category = Term::find($id);
        return view('admin.categories.editCategory',['category'=>$category]);
    }
    public function postEditCategory(Request $request)
    {

            $this->validate($request,
            [
                'name' =>'required|min:3|max:255|unique:terms,name,'.$request->id.',id',
                'img' =>'image',
            ],
            [
                'name.required' =>'bạn không thể bỏ trống tên thể loại',
                'name.min' =>'tên thể loại ít nhất từ 3 đến 255 ký tự',
                'name.max' =>'tên thể loại ít nhất ít nhất từ 3 đến 255 ký tự',
                'name.unique' =>'thể loại đã tồn tại',
            ]);
        $category = Term::find($request->id);
        $category->name= mb_strtolower($request->name);
        $category->parent= $request->parent;
        $category->status= $request->status;
        $category->slug = Str::slug($request->name, '-');
        if(isset($request->showon)){
            $category->show = 1;
        }else{
            $category->show = 0;
        }
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
            $category->image = Carbon::now()->year.'/'.Carbon::now()->month.'/'.$name;
        }
        else{
            if($request->getImg != ""){
                    $category->image = $request->getImg;
            }else{
                    $category->image = null;
            }
        }
        $category->save();
        return redirect('admin/categories/edit-category/'.$request->id)->with('message','Updated successfully');

    }

    public function deleteCategory($id)
    {
        $postId = term_relationships::where("term_id",$id)->pluck("post_id");
        $result = DB::table('posts')->whereIn('id',$postId)->where('post_type',"boards")->pluck("id");

        $categoriesPosts= term_relationships::where("term_id",$id)->delete();
        $deleteParent= Term::where("parent",$id)->update(['parent'=>0]);
        $category = Term::find($id);
        $category->delete();
        foreach($result as $item){
            $term_relationships = new term_relationships;
            $term_relationships->post_id= $item;
            $term_relationships->term_id= 99;
            $term_relationships->save();
        }

        return redirect('admin/categories/list-categories')->with('message','Deleted successfully');
    }

    public function searchCategories(Request $request)
    {
        $categories = Term::where([['name','like',"%$request->search%"],['type','category']])->paginate(session('limit'));

        return view('admin.categories.listCategories',['categories'=>$categories]);

    }

    public function bulkActionCategories(Request $request)
    {
        if($request->select=="public"){
            if(!empty($request->check)){
                $posts= Term::whereIn('id',$request->check)->update(['status'=>"public"]);
                return redirect()->route('list-categories')->with('message',"$posts Changed successfully");
            }else{
                return redirect()->route('list-categories')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="verified"){
            if(isset($request->check)){
                $posts= Term::whereIn('id',$request->check)->update(['status'=>'verified']);
                return redirect()->route('list-categories')->with('message',"$posts Changed successfully");
            }else{
                return redirect()->route('list-categories')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="private"){
            if(isset($request->check)){
                $posts= Term::whereIn('id',$request->check)->update(['status'=>'private']);
                return redirect()->route('list-categories')->with('message',"$posts Changed successfully");
            }else{
                return redirect()->route('list-categories')->with('messageWarning',"Nothing selected");
            }

        }else if($request->select=="delete"){
            if(isset($request->check)){
                // get id post
                $postId= Term_relationships::whereIn('term_id',$request->check)->pluck("post_id");
                $result = DB::table('posts')->whereIn('id',$postId)->where('post_type',"boards")->pluck("id");
                //delete category
                $categoriesPosts= Term_relationships::whereIn('term_id',$request->check)->delete();
                $categoriesParent = Term::whereIn('parent',$request->check)->update(['parent'=>0]);
                Term::whereIn('id',$request->check)->delete();
                // //insert relationships default
                foreach($result as $item){
                    DB::table('term_relationships')->insert(
                        array('post_id' => $item, 'term_id' => 99)
                    );
                }
                return redirect()->route('list-categories')->with('message',"Deleted successfully");
            }else{
                return redirect()->route('list-categories')->with('messageWarning',"Nothing selected");
            }
        }else{
            return redirect()->route('list-categories')->with('message','chọn một tùy chọn');
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Postmeta;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    public function __construct()
    {
        $allImgsCategories = Term::where('image','!=','')->get();
        $allImgsPosts = Postmeta::all();
        view()->share('allImgsCategories',$allImgsCategories);
        view()->share('allImgsPosts',$allImgsPosts);
        if(!session()->has('limit')){
            session(['limit' => 10]);
        }
    }

    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('list-categories');
    }

    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('listImages');
    }
    public function listImages()
    {
        if(session()->has('sort')){
            $imagesCategories = Term::where('image','!=','')->orderBy('name',session('sort'))->get();
            $imagesPosts = Postmeta::where([['meta_key','=',"meta_image"],['meta_value','!=',null]])->orderBy('meta_value',session('sort'))->get();
        }else{
            $imagesCategories = Term::where('image','!=','')->get();
            $imagesPosts = Postmeta::where([['meta_key','=',"meta_image"],['meta_value','!=',null]])->get();
        }

        // $allImgsCategories = Term::where('image','!=','')->get();
        // dd($allImgsCategories);
        return view('admin.image.listImages',['imagesCategories'=>$imagesCategories,'imagesPosts'=>$imagesPosts]);
    }

    public function getEditCategory($id)
    {
        $category = Term::find($id);
        return view('admin.image.editImageCategory',['category'=>$category]);
    }
    public function postEditCategory(Request $request)
    {
        $this->validate($request,
        [
            'img' =>'image',
        ]);
        $category = Term::find($request->id);
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
        return redirect()->route('getEditImgCategory',['id'=>$request->id])->with('message','Đã update ảnh. ');
    }
    public function deleteImgCategory($id)
    {
        $category = Term::find($id);
        $category->image= null;
        $category->save();
        return redirect()->route('listImages')->with('message','Đã xóa ảnh.');
    }
    public function getEditPost($id)
    {
        $post = Postmeta::find($id);
        return view('admin.image.editImagePost',['post'=>$post]);
    }
    public function postEditPost(Request $request)
    {
        $this->validate($request,
        [
            'img' =>'image',
        ]);
        $meta_image = Postmeta::find($request->id);

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
        $meta_image->meta_value = Carbon::now()->year.'/'.Carbon::now()->month.'/'.$name;
        $meta_image->save();
        }
        else{
            if($request->getImg != ""){
                $meta_image->meta_value = $request->getImg;
                $meta_image->save();
            }else{
                $meta_image->meta_value = null;
                $meta_image->save();
            }
        }
        return redirect()->route('getEditImgPost',['id'=>$request->id])->with('message','Đã update ảnh.');
    }

    public function deleteImgPost($id)
    {
        $post = Postmeta::find($id);
        $post->meta_value= null;
        $post->save();
        return redirect()->route('listImages')->with('message','Deleted successfully');
    }

    public function searchImages(Request $request)
    {
        $allImgsCategories = Term::where('image','like',"%$request->search%")->get();
        $allImgsPosts = Postmeta::where([['meta_key','meta_image'],['meta_value','like',"%$request->search%"]])->get();

        return view('admin.image.listImages',['imagesCategories'=>$allImgsCategories,'imagesPosts'=>$allImgsPosts]);

    }

    public function bulkActionImages(Request $request)
    {
        if($request->select=="delete"){
            if(isset($request->check) || isset($request->check2)){
                if(isset($request->check)){
                    $imgCategories= Term::whereIn('id',$request->check)->update(['image'=>null]);
                }
                if(isset($request->check2)){
                    $imgPosts= Postmeta::whereIn('id',$request->check2)->update(['meta_value'=>null]);
                }
                    return redirect()->route('listImages')->with('message',"Deleted successfully");
            }else{
                return redirect()->route('listImages')->with('messageWarning',"Nothing selected");
            }
        }else{
            return redirect()->route('listImages')->with('message','chọn một tùy chọn');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function showAll(){
        $post = Post::all();
        return response() -> json($post,200);
    }
    public function show($id){
        $post = Post::find($id);
        return response() -> json($post);

    }
    public function proverka(Request $request, $id){
        $ad_key = $request -> input('ad_key');
        $post = Post::find($id);
        if($post -> ad_key == $ad_key){
            return response() -> json(['massage' => 'Ключ успешно прошел проверку'],200);
        }
        else{
            return response() -> json(['massage' => 'ad_key не прошел проверку'],422);
        }
    }

    public function addPost(Request $request){
        $title_ad = $request -> input('title_ad');
        $info_ad = $request -> input('info_ad');
        $contact_name = $request -> input('contact_name');
        $contact_phone = $request -> input('contact_phone');
        $date_end = $request -> input('date_end');
        $file = $request -> file('file');
        $hello = $file -> getClientOriginalName();

        if (strlen($title_ad) >0){
            if (strlen($info_ad) >0){
                if (strlen($contact_name) >0){
                    if (strlen($contact_phone) == 11){
                        if (strlen($date_end) >0){
                            $post = new Post();
                            $ad_key = rand(0, 10000);
                            $post -> title_ad = $title_ad;
                            $post -> info_ad = $info_ad;
                            $post -> contact_name = $contact_name;
                            $post -> contact_phone = $contact_phone;
                            $post -> date_end = $date_end;
                            $post -> file = $file;
                            $post -> ad_key = $ad_key;
                            $post -> file = $file;
                            $post -> save();
                            $id = $post -> id;
                            $file -> move(storage_path('app/files'), $hello. '.' . $file->getClientOriginalExtension());
                            return response()->json(['ad_key = ' => $ad_key, 'id = ' => $id],201);

                        }else{return response()-> json(['massage' => 'date_end не прошел валидацию'], 422);}
                    }else{return response()-> json(['massage' => 'contact_phone не прошел валидацию'], 422);}
                }else{return response()-> json(['massage' => 'contact_name не прошел валидацию'], 422);}
            }else{return response()-> json(['massage' => 'info_ad не прошел валидацию'], 422);}}
            else{return response()-> json(['massage' => 'title_ad не прошел валидацию'], 422);}





    }

    public function editPost(Request $request, $id){
        $title_ad = $request -> input('title_ad');
        $info_ad = $request -> input('info_ad');
        $contact_name = $request -> input('contact_name');
        $contact_phone = $request -> input('contact_phone');
        $date_end = $request -> input('date_end');
        $file = $request -> file('file');
        $ad_key = $request -> input('ad_key');

        $post = Post::find($id);
        $hello = $file -> getClientOriginalName();

        if ($post -> ad_key == $ad_key){
        if (strlen($title_ad) >0){
            if (strlen($info_ad) >0){
                if (strlen($contact_name) >0){
                    if (strlen($contact_phone) == 11){
                        if (strlen($date_end) >0){
                            $post -> title_ad = $title_ad;
                            $post -> info_ad = $info_ad;
                            $post -> contact_name = $contact_name;
                            $post -> contact_phone = $contact_phone;
                            $post -> date_end = $date_end;
                            $post -> file = $file;
                            $file -> move(storage_path('app/files'),$hello. '.' . $file->getClientOriginalExtension());
                            return response()-> json($post,200);

                        }else{return response()-> json(['massage' => 'date_end не прошел валидацию'], 422);}
                    }else{return response()-> json(['massage' => 'contact_phone не прошел валидацию'], 422);}
                }else{return response()-> json(['massage' => 'contact_name не прошел валидацию'], 422);}
            }else{return response()-> json(['massage' => 'info_ad не прошел валидацию'], 422);}}
            else{return response()-> json(['massage' => 'title_ad не прошел валидацию'], 422);}
        }else{return response()->json(['message' => 'Ключ не подходит']);}
    }

    public function editDate(Request $request, $id){
        $date_end = $request -> input('date_end');
        $ad_key = $request -> input('ad_key');

        $edit = Post::find($id);
        if($edit -> ad_key == $ad_key){
            if (strlen($date_end) > 0){
                $edit -> date_end = $date_end;
                $edit -> save();
                return response() -> json(['massage' => 'Дата об окончании была успешно изменена'],200);
            }else{return response() -> json(['massage' => 'date_end не прошел валидацию'],422);}
        }else{return response() -> json(['massage' => 'ad_key не подходит'],422);}
    }

    public function deleteFile(Request $request, $id){
        $ad_key = $request -> input('ad_key');

        $delete = Post::find($id);
        $file = $delete -> file;
        if ($delete -> ad_key == $ad_key){
            File::delete('app/files/'.$file);
            return response() -> json(['massage'=> 'Файл удален']);
        }else{return response() -> json(['massage'=> 'Ключ не прошел валидацию']);}

    }

    public function delete(Request $request, $id){
        $ad_key = $request -> input('ad_key');
        $delete = Post::find($id);

        $file = $delete -> file;
        if($delete -> ad_key == $ad_key){

            File::delete('app/files/'.$file);
            $delete->delete();
            return response()->json(['massage' => 'Объявление было успешно удалено']);
        }else{return response()->json(['massage' => $file,'ad_key не подходит']);}

    }

}

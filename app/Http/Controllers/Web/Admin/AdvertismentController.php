<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisment;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Str;

class AdvertismentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:advertisments', ['only' => ['index']]);
        $this->middleware('permission:create_advertisments', ['only' => ['create','store']]);
        $this->middleware('permission:update_advertisments', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_advertisments', ['only' => ['destroy']]);
    }

    public function index($category_id)
    {
        $advertisments=Advertisment::where('category_id', $category_id)->paginate(20);
        $categories=Category::where('id', $category_id)->get();

        return view('web.admin.advertisments.index', compact('advertisments', 'category_id', 'categories'));
    }

    public function create($category_id)
    {
        $categories=Category::where('id', $category_id)->get();
        return view('web.admin.advertisments.create', compact('category_id', 'categories'));
    }

    public function edit($id)
    {
        $advertisment=Advertisment::find($id);
        return view('web.admin.advertisments.edit', compact('advertisment'));
    }


    public function store(Request $request)
    {
        $code                           = "S" .'#'  . Str::random(4);
        $advertisment                   = new Advertisment;
        $advertisment->link             = $request->link;
        $advertisment->category_id      =$request->category_id;
        $advertisment->code             = $code ;
        $advertisment->save();


        if ($request->has('document')) {
            $advertisment->image = $request->document;
            $advertisment->save();
        }


        if ($request->type =="product") {
            $advertisment->type_id  = $request->product_id;
            $advertisment->type     ='product';
            $advertisment->save();
        } elseif ($request->type =="organization") {
            $advertisment->type_id =  $request->organization_id;
            $advertisment->type    = 'organization';
            $advertisment->save();
        } else {
            $advertisment->type_id =null;
            $advertisment->type    = null;
            $advertisment->save();
        }


        return back()->with('status', 'Added successfully.');
    }


    public function show(Category $category)
    {
        $views = View::all();
        $subCategories = Category::where('parent_id', $category)->orderBy('id', 'desc')->get();

        return view('web.admin.categories.', ['categories' => $categories , 'views' => $views]);
    }


    public function update(Request $request, $id)
    {
        $advertisment = Advertisment::findOrFail($id);

        $advertisment->link = $request->link;
        $advertisment->save();

        if ($request->has('document')) {
            $advertisment->image = $request->document;
            $advertisment->save();
        }


        if ($request->type =="product") {
            $advertisment->type_id = $request->product_id;
            $advertisment->type    ='product';
            $advertisment->save();
        } elseif ($request->type =="organization") {
            $advertisment->type_id =  $request->organization_id;
            $advertisment->type = 'organization';
            $advertisment->save();
        } else {
            $advertisment->type_id =null;
            $advertisment->type    = null;
            $advertisment->save();
        }


        return back()->with('status', "updated successfully");
    }

    public function destroy($id)
    {
        $advertisment = Advertisment::find($id);
        \Storage::disk('advertisments')->delete($advertisment->image);
        $advertisment->delete();

        return back()->with('delete', "تم حذف سجل بنجاح");
    }

    public function saveaAvertismentImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('uploads/advertisments/', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    ////////////////delete image from database in edit dropzone
    public function delete_file(Request $request)
    {
        Storage::disk('s3')->delete('uploads/advertisments/'.$request->old_image);
        return 'sucess';
    }

    // multi_delete
    public function delete_all(Request $request)
    {
        if ($request->delete_all_id) {
            $delete_all_id = explode(",", $request->delete_all_id);
            $advertisment= Advertisment::whereIn('id', $delete_all_id)->get();

            if (in_array('on', $delete_all_id)) {
                array_shift($delete_all_id);
            }


            if (count($advertisment) >  0) {
                $medias=Media::whereIn('mediaable_id', $advertisment)->where('mediaable_id', 'App\Models\Advertisment')->get();
                if ($medias) {
                    foreach ($medias as $media) {
                        \Storage::disk('s3')->delete($advertisment->image);
                        $media->delete();
                    }
                }
            }
            $advertisment= Advertisment::whereIn('id', $delete_all_id)->delete();
        }

        return back()->with('status', "Deleted successfully");
    }
}

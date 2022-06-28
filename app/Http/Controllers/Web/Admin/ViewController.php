<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\View;
use App\Http\Requests\Web\Admin\ViewRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Image;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:views', ['only' => ['index']]);
        $this->middleware('permission:create_view', ['only' => ['create','store']]);
        $this->middleware('permission:update_view', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_view', ['only' => ['destroy']]);
        $this->middleware('permission:delete_all_view', ['only' => ['views.delete_all']]);
    }

    public function index()
    {
        $views = View::where('id', '!=', 12)->get();
        return view('web.admin.views.index', ['views' => $views]);
    }

    public function store(ViewRequest $request)
    {
        $view = new View();
      
        if ($request->hasFile('image')) {
            $img = request()->file('image');

            // store uploaded image
            $uploaded_image = $img->store('uploads/views', 's3');

            // add watermark and save
            $image = Image::make($img);
            $extension = $img->getClientOriginalExtension(); // getting image extension
        $file_name = 'uploads/views/'. time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
        $image->insert(env('AWS_S3_URL').'/uploads/SuiizWatermark.png', 'bottom-left')->encode($extension);
        
            Storage::disk('s3')->put($file_name, (string)$image);
            $view->image = $file_name;
        }

        $view->name = $request->name_en;
        $view->save();
        session()->flash('Add', 'تم اضافة سجل بنجاح ');

        return redirect()->back();
    }

    public function update(ViewRequest $request, View $view)
    {
        if ($request->hasFile('image')) {
            $file_name = $request->file('image')->store('uploads/views', 's3');
            Storage::disk('s3')->setVisibility($file_name, 'public');
            Storage::disk('s3')->delete($view->image);
            $view->image = $file_name;
            $view->update();
        }

        $view->name = $request->name_en;
        $view->update();

        session()->flash('Edit', 'تم التعديل السجل بنجاح ');
        return redirect()->back();
    }

    public function destroy(View $view)
    {
        \Storage::disk('public_uploads')->delete($view->image);

        $view->delete();
        return back()->with('delete', "تم حذف سجل بنجاح");
    }

      
    //Delete all
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
   
        $views= View::whereIn('id', $delete_all_id)->get();

        foreach ($views as $view) {
            \Storage::disk('public_uploads')->delete($view->image);
            $view->delete();
        }
  
        return back()->with('status', "Deleted successfully");
    }
}

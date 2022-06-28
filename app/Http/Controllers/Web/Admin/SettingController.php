<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Media;

class SettingController extends Controller
{
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        return view('web.admin.settings.edit', compact('setting'));
    }


    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request->all());

        if ($request->has('document') && count($request->document) > 0) {
            foreach ($request->document as $image) {
                $setting->medias()->create([
                   'url'         => $image,
                   'full_file'   =>$request->getSchemeAndHttpHost().$image	,
                   'path'        =>'uploads/settings/'.$image

               ]);
            }
        }
        return back()->with('status', "updated successfully");
    }




    ////////////////save image in folder  in create image from dropzone
    public function saveSettingImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImageToS3('uploads/settings', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
    ////////////////delete image from database in edit dropzone
    public function delete_file(Request $request)
    {
        $media = Media::where('id', $request->id)->first();

        if ($media) {
            \Storage::disk('s3')->delete($media->path);
            $media->forceDelete();
        }

        return 'sucess';
    }
}

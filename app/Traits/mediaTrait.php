<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait mediaTrait
{
    public function saveFile($file, $folder, $old=null)
    {
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $file_name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image

        Storage::disk('s3')->put($folder . '/' . $file_name, $file, 'public');

        if ($old != null) {
            Storage::disk('s3')->delete($old);
        }

        return $file_name;
    }
}

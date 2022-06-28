<?php

use Spatie\Image\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadMedia')) {
    /**
     * @param $result
     * @param $message
     */
    function uploadMedia(HasMedia $model, $images, $key = 'images')
    {
        if (blank($images)) {
            return;
        }

        $modelMedia = $model->getMedia($key);
        $position = optional($modelMedia->sortDesc()->first())->order_column ?? 0;
        $isModelHasMedia = $modelMedia->count() > 0;

        $dirName = Str::snake(Str::plural(class_basename($model)));
        $tempPath = storage_path("tmp/uploads/{$dirName}");

        collect($images)->each(function (UploadedFile $image) use ($model, &$position, $dirName, $tempPath, $key, $isModelHasMedia) {
            $fileName = $model->id . time() . uniqid() . '.' . $image->getClientOriginalExtension();
            $originalImage = $image->move($tempPath, $fileName);

            $image = Image::load($originalImage->getRealPath())
                ->width(1200)
                // watermark
                ->save();

            $position = ++$position;
            $media = $model->addMedia($originalImage->getRealPath())
                           ->setName("/uploads/{$dirName}/{$fileName}")
                           ->setFileName("/uploads/{$dirName}/{$fileName}")
                           ->setOrder($position);

            if (!$isModelHasMedia && $position == 1) {
                $media->withCustomProperties(['isFeatured' => true]);
            }

            $media->toMediaCollection($key);
        });
    }
}

if (!function_exists('sendJsonResponse')) {
    /**
     * @param $result
     * @param $message
     */
    function sendJsonResponse($result, $message = '')
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
}

if (!function_exists('sendJsonError')) {
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    function sendJsonError($errorMessages, $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $errorMessages,
            'data'    => null,
        ];

        return response()->json($response, $code);
    }
}

if (!function_exists('uploadImageToS3')) {
    /**
     * // save images
     * @param  $folder
     * @param  $image
     * @return mixed
     */
    function uploadImageToS3($folder, $image)
    {
        $image->store($folder, 's3');

        $filename = $image->hashName();

        return $filename;
    }
}

if (!function_exists('uploadProductImage')) {
    /**
     * @param  $folder
     * @param  $img
     * @return mixed
     */
    function uploadProductImage($folder, $img)
    {
        $arr = [

            'top-left',
            'bottom-left',
            'top-right',
            'bottom-right',
            'center',
        ];

        $key = array_rand($arr);

        $uploaded_image = $img->store($folder, 's3');

        // add watermark and save
        $image = Image::make($img);
        $extension = $img->getClientOriginalExtension(); // getting image extension
        $file_name = $folder . time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
        $image->insert(env('AWS_S3_URL') . '/uploads/SuiizWatermark5.png', $arr[$key], 5, 5)->encode($extension);

        Storage::disk('s3')->put($file_name, (string) $image);

        return $file_name;
    }
}

if (!function_exists('convert2english')) {

                                                          /**
     * @param $string
     */
    function convert2english($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        $string = str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }
}

if (!function_exists('getNestedAttribute')) {
    /**
     * @param  Model   $model
     * @param  string  $key
     * @param  string  $childrenKey
     * @param  array   $array
     * @return mixed
     */
    function getNestedAttribute(Model $model, $key, $childrenKey, &$array = [])
    {
        $array[] = $model->{$key};

        if ($models = $model->{$childrenKey}) {
            foreach ($models as $model) {
                getNestedAttribute($model, $key, $childrenKey, $array);
            }
        }

        return $array;
    }
}

if (!function_exists('lastCategoriesIds')) {
    /**
     * @param  $cat_id
     * @param  $arr
     * @return mixed
     */
    function lastCategoriesIds($cat_id, $arr)
    {
        array_push($arr, $cat_id);

        $categories = App\Models\Category::where('parent_id', $cat_id)->get();
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                $arr = lastCategoriesIds($category->id, $arr);
            }
        }

        return $arr;
    }
}

if (!function_exists('updateRecurringCategory')) {

                     /**
     * @param $rec_id
     * @param $cat_id
     */
    function updateRecurringCategory($rec_id, $cat_id)
    {
        $recurring_categories = App\Models\CategoryRecurring::where('parent_id', $rec_id)->get();

        foreach ($recurring_categories as $recurring_category) {
            $category = $recurring_category->categories()->create([

                'name'        => ['en' => $recurring_category->getTranslation('name', 'en'), 'ar' => $recurring_category->getTranslation('name', 'ar')],
                'parent_id'   => $cat_id,
                'description' => ['en' => $recurring_category->getTranslation('description', 'en'), 'ar' => $recurring_category->getTranslation('description', 'ar')],
                'image'       => $recurring_category->image,
                'view_id'     => $recurring_category->view_id,

            ]);

            $category->subAccounts()->attach($recurring_category->subAccounts);

            if ($recurring_category->recurringChilds->count()) {
                updateRecurringCategory($recurring_category->id, $category->id);
            }
        }
    }
}

if (!function_exists('notifyByFirebase')) {

    // dd(env('FIREBASE_API_ACCESS_KEY'));
    /**
     * @param  $title
     * @param  $body
     * @param  $tokens
     * @param  array     $data
     * @return mixed
     */
    function notifyByFirebase($title, $body, $tokens, $data = [])
    {
        $registrationIDs = $tokens;
        $fcmMsg = array(
            'body'  => $body,
            'title' => $title,
            'sound' => "default",
            'color' => "#203E78",
        );

        $fcmFields = array(
            'registration_ids' => $registrationIDs,
            'priority'         => 'high',
            'notification'     => $fcmMsg,
            'data'             => $data,
        );

        $headers = array(
            // 'Authorization: key='.env('FIREBASE_API_ACCESS_KEY'),
            'Authorization: key=AAAADnUGqgs:APA91bFypfX0lGOrisF0S6F6KR7aW4NZxb0bCBlVNiRQCm-7v0MfBUxG-5pkK2N7Ou75GJG8BDtTqFyOGR_CI2HqSzFoqKITJOx3Xfqkt6jSkJ9Cq1JSWUJeYimvHtEjPp5XuFdMv_OQ',
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}

if (!function_exists('sendMisr')) {
    /**
     * @param  $to
     * @param  $message
     * @return mixed
     */
    function sendMisr($to, $message)
    {
        $url = 'https://smsmisr.com/api/webapi/?';

        $push_load = array(
            'username' => 'tkWwxqPP',
            'password' => '3TSdCQG01x',
            'language' => '2',
            'sender'   => 'Suiiz',
            'mobile'   => '2' . $to,
            'message'  => $message,

        );
        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url . http_build_query($push_load));
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_load);
        curl_setopt($rest, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt(
            $rest,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            )
        );
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($rest);
        curl_close($rest);
        return $response;
    }
}

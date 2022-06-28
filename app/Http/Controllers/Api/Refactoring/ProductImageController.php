<?php

namespace App\Http\Controllers\Api\Refactoring;

use App\Models\Product;
use App\Models\MediaCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return sendJsonResponse($product->images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->validate($request, [
            'images'   => 'array|required',
            'images.*' => 'image',
        ]);

        $product->update(['images' => $request->images]);

        $product->load('media');

        return sendJsonResponse($product->images);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Product         $product
     * @param  \App\Models\MediaCenter     $image
     * @return \Illuminate\Http\Response
     */
    public function markFeatured(Product $product, MediaCenter $image)
    {
        $product->getMedia('images')->each(function (MediaCenter $media) {
            $media->forgetCustomProperty('isFeatured');
            $media->save();
        });

        $image->setCustomProperty('isFeatured', true);
        $image->save();

        $image = $image->refresh();

        return sendJsonResponse([], __('lang.model_featured', ['model' => 'image']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product         $product
     * @param  \App\Models\MediaCenter     $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, MediaCenter $image)
    {
        $image->delete();

        return sendJsonResponse([], __('lang.model_deleted', ['model' => 'image']));
    }
}

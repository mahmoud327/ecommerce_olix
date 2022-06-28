<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use App\Models\Service;
use App\Http\Resources\ServiceResource;

class OrganizationServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return
        [
            
                'success'    => true,
                
                'data'=>$this->resource->transform(function ($item) {
                    $servicesIds = $item->services()->pluck('service_id');

                    $services = Service::whereIn('id', $servicesIds)->get();

                    return
                    [
                                
                        'id'                => $item->id,
                        'name'              => $item->name,
                        'phones'            => $item->phones,
                        'description'       => $item->description,
                        'google_map_link'   => $item->google_map_link,
                        'city_name'         => $item->city_name,
                        'links'             => $item->links,
                        'image'             => env('AWS_S3_URL').'/'.$item->image,
                        'services'          => ServiceResource::collection($services),
                        
                    ];
                }),
                    
                'meta'=>
                [
                        
                        'total' => $this->total(),
                        'count' => $this->count(),
                        'per_page' => $this->perPage(),
                        'current_page' => $this->currentPage(),
                        'total_pages' => $this->lastPage()
                ],
                                
                'message'    => 'success',
                    
        ];
    }


    public function withResponse($request, $response)
    {
        $jsonResponse=json_decode($response->getContent, true);
        unset($jsonResponse['links'],$jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}

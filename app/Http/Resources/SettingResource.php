<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $medias= ['full_file' => env('AWS_S3_URL').'/uploads/avatar.png' ];
        $phones= json_decode($this->phone);
        $emails= json_decode($this->email);
        $lang = $request->header('x-localization');
        if ($lang == "en") {
            $terms=view('web.admin.terms.terms_en')->render();

            $about_us=view('web.admin.about_us.about_us_en')->render();
        } else {
            $terms=view('web.admin.terms.terms_ar')->render();
            ;
            $about_us=view('web.admin.about_us.about_us_ar')->render();
            ;
        }

   
      
        return [
            
            'id'                         => $this->id,

            'terms'                      => $terms,
            'fax'                        => $this->fax,
            'about_us'                   =>  $about_us,
            'fb_link'                    => $this->fb_link,
            'tw_link'                    => $this->tw_link,
            'youtube_link'              => $this->youtube_link,
            'inst_link'                 => $this->inst_link,
            'tw_link'                   => $this->tw_link,
            'whatsapp'                  => $this->whatsapp,
            'langitude'                 => $this->langitude,
            'latitude'                  => $this->latitude,
            'phone'                     => $phones,
            'emails'                    => $emails,
            'medias'                    => $this->medias()->count() ? MediaResource::collection($this->medias) : [$medias] ,
                    
         ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Alcohole;
use App\Models\BodyType;
use App\Models\Children;
use App\Models\Interest;
use App\Models\Relations;
use App\Models\Smoking;
use App\Models\Target;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $profile = parent::toArray($request);

        return [
                'profile' => $profile,
                'relations' => Relations::all(),
                'targets' => Target::all(),
                'interest' => Interest::all(),
                'children' => Children::all(),
                'body_type' => BodyType::all(),
                'alcohol' => Alcohole::all(),
                'smoking' => Smoking::all()
        ];
    }
}

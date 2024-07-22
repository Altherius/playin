<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\Media;

/**
 * @property int $id
 * @property string $path
 * @property ?string $description
 */
class MediaController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        return new MediaResource($media);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BookServices
{
    public function uploadImage($request)
    {
        $image = $request->file('image');
        $imageName = 'Image_' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        return $imageName;
    }
}

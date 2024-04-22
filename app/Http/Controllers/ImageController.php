<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    /**
     * Retrieve an image by name.
     */
    public function getImage($imageName)
    {
        $path = public_path('images/product/') . $imageName;

        if (!file_exists($path)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return Response::make($file, 200, ['Content-Type' => $type]);
    }
}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlideshowImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SlideshowController extends Controller
{
    public function index()
    {
        $images = SlideshowImage::all();
        return view('admin.slideshow.index', compact('images'));
    }

    public function create()
    {
        return view('admin.slideshow.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->path();
        $resizedImage = $this->resizeImage($imagePath, 800, 400);
        $path = 'slideshow_images/' . uniqid() . '.jpg';
        Storage::disk('public')->put($path, $resizedImage);

        SlideshowImage::create([
            'image_path' => $path,
            'caption' => $request->caption,
        ]);

        return redirect()->route('admin.slideshow.index')->with('success', 'Slideshow image added successfully.');
    }


    public function edit(SlideshowImage $slideshow)
    {
        if (!$slideshow->exists) {
            Log::error('Slideshow image not found: ' . $slideshow->id);
            abort(404, 'Slideshow image not found.');
        }

        Log::info('Editing slideshow image: ' . $slideshow->id);
        return view('admin.slideshow.edit', compact('slideshow'));
    }

    public function update(Request $request, SlideshowImage $slideshow)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|max:2048',
            ]);

            $imagePath = $request->file('image')->path();
            $resizedImage = $this->resizeImage($imagePath, 800, 400);
            $path = 'slideshow_images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($path, $resizedImage);

            // Ensure the image path is not null and exists before attempting to delete
            if ($slideshow->image_path && Storage::disk('public')->exists($slideshow->image_path)) {
                Storage::disk('public')->delete($slideshow->image_path);
            } else {
                Log::error('Image path does not exist: ' . $slideshow->image_path);
            }

            $slideshow->update(['image_path' => $path]);
        }

        $slideshow->update($request->only('caption', 'is_active'));

        return redirect()->route('admin.slideshow.index')->with('success', 'Slideshow image updated successfully.');
    }
    public function destroy(SlideshowImage $slideshow)
    {
        Log::info('Deleting slideshow image: ' . $slideshow->id);

        // Ensure the image path is not null and exists before attempting to delete
        if ($slideshow->image_path && Storage::disk('public')->exists($slideshow->image_path)) {
            Storage::disk('public')->delete($slideshow->image_path);
        } else {
            Log::error('Image path does not exist: ' . $slideshow->image_path);
        }

        // Delete the database record
        $slideshow->delete();

        return redirect()->route('admin.slideshow.index')->with('success', 'Slideshow image deleted successfully.');
    }

    private function resizeImage($imagePath, $width, $height)
    {
        $image = imagecreatefromstring(file_get_contents($imagePath));
        $newImage = imagecreatetruecolor($width, $height);
        list($originalWidth, $originalHeight) = getimagesize($imagePath);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
        ob_start();
        imagejpeg($newImage, null, 75);
        $data = ob_get_clean();
        imagedestroy($newImage);
        imagedestroy($image);
        return $data;
    }
}

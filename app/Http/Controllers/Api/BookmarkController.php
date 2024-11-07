<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    use ApiResponse; // Use the trait

    public function toggleBookmark(Request $request) {

        $user = auth()->user();
        $productId = $request->input('ad_id');

        $validator = Validator::make($request->all(), [
            'ad_id' => 'required|integer|exists:ads,id',
        ]);

        if ($validator->fails()) {
            return $this->error([], $validator->errors()->first(), 422);
        }

        // Check if the product is already in favorites
        $bookmark = Bookmark::where('user_id', $user->id)->where('ad_id', $productId)->first();

        if ($bookmark) {
            // If exists, remove from favorites
            $bookmark->delete();
            return $this->success([], 'Ad removed from bookmark.');
        } else {
            // If not, add to favorites
            Bookmark::create([
                'user_id' => $user->id,
                'ad_id' => $productId,
            ]);
            return $this->success([], 'Ad added to bookmark.');
        }
    }

    public function getBookmarks() {
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'User not authenticated', 401);
        }

        // Fetch favorite products using the relationship
        $bookmark = $user->bookmarkProducts;

        if ($bookmark->isEmpty()) {
            return $this->error([], 'No Bookmark AD found', 404);
        }

        return $this->success($bookmark, 'Bookmark AD retrieved successfully.');
    }
}

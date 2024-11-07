<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    use ApiResponse;

    /**
     * Created A Ad
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the ad Create query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:4048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,others',
            'price' => 'required|numeric',
            'email' => 'required|email',
            'number' => 'required|numeric',
        ], [
            'gender.in' => 'The selected gender is invalid.',
        ]);

        if ($validator->fails()) {
            return $this->error([], $validator->errors(), 422);
        }

        try {

            if ($request->hasFile('image')) {
                $image                        = $request->file('image');
                $imageName                    = uploadImage($image, 'Ad');
            }

            DB::beginTransaction();

            $ad = Ad::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'image' => $imageName,
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'gender' => $request->gender,
                'price' => $request->price,
                'email' => $request->email,
                'number' => $request->number,
            ]);

            $notification = Notification::create([
                'user_id' => auth()->user()->id,
                'ad_id' => $ad->id,
                'notifiable_id' => auth()->user()->id,
                'title' => 'Your Ad Has Been Successfully Created',
            ]);

            DB::commit();

            return $this->success($ad, 'Your Ad Has Been Successfully Created', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage(), 500);
        }
    }

    /**
     * All Ads
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the all ad query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

     public function ad() {
        try {
            $currentUserId = auth()->id(); // Get the current user's ID

            // Get paginated data
            $data = Ad::query()
                ->with(['category'])
                ->select([
                    'id',
                    'user_id',
                    'category_id',
                    'title',
                    'image',
                    'description',
                    'location',
                    'gender',
                    'price',
                    'email',
                    'number',
                ])
                ->latest()
                ->paginate(10);

            // Check if the data is empty
            if ($data->isEmpty()) {
                return $this->error([], 'Ads not found', 404);
            }

            // Map the data to include bookmark flag
            $ads = $data->map(function ($ad) use ($currentUserId) {
                $ad->is_bookmarked = $ad->bookmarkBy->contains($currentUserId); // Add bookmark flag
                unset($ad->bookmarkBy);
                return $ad;
            });

            // Prepare the response
            $response = [
                'ads' => $ads,
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'next_page' => $data->nextPageUrl(),
                    'prev_page' => $data->previousPageUrl(),
                ],
            ];

            return $this->success($response, 'Ads retrieved successfully');

        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Error retrieving ads: ' . $e->getMessage());

            // Return a generic error response
            return $this->error([], 'An error occurred while retrieving ads', 500);
        }
    }

    /**
     * All Ads
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request edit ad.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function edit(Request $request, $id) {

        $validator = Validator::make($request->all(),[
            'category_id' => 'nullable|integer|exists:categories,id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:4048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,others',
            'price' => 'required|numeric',
            'number' => 'required|numeric',
        ], [
            'gender.in' => 'The selected gender is invalid.',
        ]);

        if ($validator->fails()) {
            return $this->error([], $validator->errors(), 422);
        }

        try {

            $data = Ad::where("id", $id)->firstOrFail();

            if ($request->hasFile('image')) {

                if ($data->image) {
                    $previousImagePath = public_path($data->image);
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }

                $image                        = $request->file('image');
                $imageName                    = uploadImage($image, 'Ad');
            } else {
                $imageName = $data->image;
            }

            $updateData = [
                'user_id' => auth()->user()->id,
                'image' => $imageName,
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'gender' => $request->gender,
                'price' => $request->price,
                'number' => $request->number,
            ];

            // Conditionally add category_id if it's not null
            if ($request->filled('category_id')) {
                $updateData['category_id'] = $request->category_id;
            }

            $ad = Ad::where('id', $id)->update($updateData);



            return $this->success($ad, 'Ad Updated Successful', 201);
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }
    }

    /**
     * All Ads Under A Categorys
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the all ad Under A Categorys query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

     public function adsUnderCategory($id) {
        $currentUserId = auth()->id(); // Get the current user's ID

        $data = Ad::query()
            ->with(['category']) // Load bookmarks relation
            ->select(['id', 'user_id', 'category_id', 'title', 'image', 'description', 'location', 'gender', 'price', 'email', 'number'])
            ->where('category_id', $id) // Filter by category
            ->latest()
            ->get()
            ->map(function ($ad) use ($currentUserId) {
                // Check if the ad is bookmarked by the current user
                $ad->is_bookmarked = $ad->bookmarkBy->contains($currentUserId);
                unset($ad->bookmarkBy);
                return $ad;
            });


        if ($data->isEmpty()) {
            return $this->error([], 'Ads not found', 404);
        }

        return $this->success($data, 'Ad retrieved successfully');
    }


    /**
     * Single Ad
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the single ad query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

     public function singleAd($id) {

        // Retrieve the ad with related user and category
        $currentUserId = auth()->id(); // Get the current user's ID

        $data = Ad::with(['category']) // Load the category and bookmarkBy
            ->select(['id', 'user_id', 'category_id', 'title', 'image', 'description', 'location', 'gender', 'price', 'email', 'number', 'created_at'])
            ->where('id', $id)
            ->first();

        if ($data) {
        // Check if the ad is bookmarked by the current user
            $data->is_bookmarked = $data->bookmarkBy->contains($currentUserId);
            unset($data->bookmarkBy);
        }

        // Check if the ad was found
        if ($data === null) {
            return $this->error([], 'Ad not found', 404);
        }

        // Return the ad data with a success message
        return $this->success($data, 'Ad retrieved successfully');
    }

    /**
     * My Ads
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the my ad query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

     public function myAd(Request $request) {
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'User not authenticated', 401);
        }

        // Get the authenticated user's ID
        $userId = $user->id;

        // Retrieve the ads with related category and paginate results
        $data = Ad::with(['category']) // Eager load the category relationship
            ->select(['id', 'user_id', 'category_id', 'title', 'image', 'description', 'location', 'gender', 'price', 'email', 'number', 'created_at'])
            ->where('user_id', $userId)
            ->latest() // Optional: Order by latest ads
            ->paginate(10); // Paginate results

        // Check if the data is empty
        if ($data->isEmpty()) {
            return $this->error([], 'No ads found for this user', 404);
        }

        // Map the data to include bookmark flag
        $ads = $data->map(function ($ad) use ($userId) {
            $ad->is_bookmarked = $ad->bookmarkBy->contains($userId);
            unset($ad->bookmarkBy); // Remove unnecessary relationship data
            return $ad;
        });

        // Prepare the response with pagination details
        $response = [
            'ads' => $ads,
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'next_page' => $data->nextPageUrl(),
                'prev_page' => $data->previousPageUrl(),
            ],
        ];

        return $this->success($response, 'Ads retrieved successfully');
    }


}

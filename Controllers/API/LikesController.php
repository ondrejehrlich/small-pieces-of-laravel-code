<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    /**
     * Add like.
     *
     * @param LikeRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function like(LikeRequest $request)
    {
        if (Auth::check()) {
            $request->user()->addLike($request->likeable());
        }

        if ($request->ajax()) {
            return response()->json([
                'likes' => $request->likeable()->likes()->count()
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove like.
     *
     * @param LikeRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function dislike(LikeRequest $request)
    {
        if (Auth::check()) {
            $request->user()->removeLike($request->likeable());
        }

        if ($request->ajax()) {
            return response()->json([
                'likes' => $request->likeable()->likes()->count()
            ]);
        }

        return redirect()->back();
    }
}

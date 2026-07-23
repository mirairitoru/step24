<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\AdoptionMatch;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::guard('web')->user();
        $favorites = Favorite::with('animal')->where('user_id', $user->id)->where('status', 'pending')->latest()->paginate(3, ['*'], 'pending_page');
        $matches = AdoptionMatch::where('user_id', $user->id)->with('animal')->paginate(3, ['*'], 'matched_page');
        return view('user.mypage', compact(
            'user',
            'favorites',
            'matches',
        ));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(UpdateUserProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('home');
        }

        $user->update($request->validated());

        if($request->deleteUserImage === '1') {
            if($user->image) {
                Storage::disk('public')->delete($user->image->path);
                $user->image()->delete();
            }
        }

        if($request->filled('cropped_image') && $request->deleteUserImage !== '1') {
            $base64 = $request->cropped_image;
            if(preg_match('/^data:image\/(\w+);base64,/', $base64)) {
                if($user->image) {
                    Storage::disk('public')->delete($user->image->path);
                    $user->image()->delete();
                }

                $base64 = preg_replace('/^data:image\/\w+;base64,/','',$base64);

                $base64 = str_replace(' ', '+', $base64);

                $path = 'user/' .uniqid() .'.jpg';

                Storage::disk('public')->put($path, base64_decode($base64));
                $user->image()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('user.mypage')->with('success', 'プロフィールを更新しました');
    }
}

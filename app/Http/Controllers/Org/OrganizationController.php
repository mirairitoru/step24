<?php

namespace App\Http\Controllers\Org;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrganizationProfileRequest;
use App\Models\Animal;
use App\Models\Favorite;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{

    public function requests()
    {
        $org = Auth::guard('org')->user();

        $favorites = Favorite::whereHas('animal', function ($query) use($org){
            $query->where('organization_id', $org->id);
        })
        ->with(['user', 'animal'])
        ->latest()
        ->get();

        return view('org.requests', compact('favorites'));
    }
    
    public function mypage()
    {
        $org = Auth::guard('org')->user();
        $query = Animal::where('organization_id', $org->id);

        $animals = (clone $query)->paginate(6);

        $total = (clone $query)->count();

        $available = (clone $query)->where(
            'adoption_status',
            '募集中',
        )->count();

        $matching = (clone $query)->where(
            'adoption_status',
            'マッチ中',
        )->count();

        $adopted = (clone $query)->where(
            'adoption_status',
            '譲渡完了',
        )->count();
        
        $recentNotifications = $org->notifications()->latest()->take(4)->get();
        $allNotifications = $org->notifications()->latest()->get();
        $unreadCount = $org->unreadNotifications()->count();

        return view('org.mypage', compact('org', 'animals', 'total', 'available', 'matching', 'adopted' ,
            'recentNotifications', 'allNotifications', 'unreadCount'));
    }

    public function edit()
    {
        $org = Auth::guard('org')->user();
        return view('org.edit', compact('org'));
    }

    public function update(UpdateOrganizationProfileRequest $request)
    {
        /** @var \App\Models\Organization $org */
        $org = Auth::guard('org')->user();

        if(!$org) {
            return redirect()->route('home');
        }

        // バリデーション
        $org->update($request->validated());

        if($request->cropped_image) {
            // 古い画像削除
            if($org->image) {
                Storage::disk('public')->delete($org->image->path);
                $org->image()->delete();
            }

            // トリミング画像を取得
            $base64 = $request->cropped_image;
            if(preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $base64 = substr($base64, strpos($base64, ',') + 1);
                $type = strtolower($type[1]);

                $path = 'organization/' . uniqid() . '.jpg';

                Storage::disk('public')->put($path, base64_decode($base64));

                // imagesテーブル登録
                $org->image()->create([
                    'path' => $path,
                ]);
            }
            // $image = str_replace('data:image/jpeg;base64,', '', $base64);
            // $image = str_replace(' ', '+', $image);
        }

        // 更新
        return redirect()->route('org.mypage')->with('success', 'プロフィール更新しました');
    }
}

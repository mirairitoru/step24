<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Favorite;
use App\Notifications\FavoriteNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function store(Animal $animal)
    {

        $userId = Auth::id();

        if($animal->adoption_status !== '募集中') {
            return back()->with(
                'error',
                'この動物は現在申請できません'
            );
        }

        $exists = Favorite::where('user_id', $userId,)
            ->where('animal_id',$animal->id)
            ->whereIn('status', ['pending', 'matched'])
            ->exists();

        if($exists) {

            return back()->with(
                'error',
                'すでに興味あり登録されています'
            );

        }
       
        $favorite = Favorite::firstOrNew([
            'user_id' => $userId,
            'animal_id' => $animal->id,
        ]);

        $favorite->status = 'pending';
        $favorite->save();

        $organization = $animal->organization;

        $organization->notify(
            new FavoriteNotification(
                Auth::guard('web')->user(),
                $animal
            )
        );

        return back()->with('success', '興味ありに追加しました');
    }

    public function index()
    {
        $favorites = Favorite::with([
            'animal.images' => function($q) {
                $q->orderBy('sort_order');
            }
        ])
        ->where('user_id', Auth::id())
        ->whereIn('status', ['pending', 'matched'])
        ->latest()
        ->paginate(3);
        return view('favorites.index', compact('favorites'));
    }

    public function destroy(int $id)
    {
        $favorite = Favorite::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favorite->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', '興味ありをキャンセルしました');        
    }
}

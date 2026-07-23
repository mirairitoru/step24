<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMatchStatusRequest;
use App\Models\AdoptionMatch;
use App\Models\Animal;
use App\Models\Chat;
use App\Models\Favorite;
use App\Notifications\CompleteNotification;
use App\Notifications\MatchNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdoptionMatchController extends Controller
{
    public function favoriteIndex(Request $request)
    {
        $orgUser = Auth::guard('org')->user();

        abort_unless($orgUser, 403);

        $animals = Animal::where(
            'organization_id',
            $orgUser->id
        )
        ->where('adoption_status', '募集中')
        ->with([
            'images' => function($q) {
                $q->orderBy('sort_order');
            }
        ])
        ->withCount([
            'favorites as favorites_count' => function($query) {
                $query->where('status', 'pending');
            }
        ])
        ->whereHas('favorites', function($query) {
            $query->where('status', 'pending');
        })
        ->get();

        if($animals->isEmpty()) {
            return view('org.favorite.index', [
                'animals' => $animals,
                'selectedAnimal' => null,
                'favoritedUsers' => collect(),
                'noAnimals' => true,
            ]);
        }

        if(!$request->animal_id) {
            return view('org.favorite.index', [
                'animals' => $animals,
                'selectedAnimal' => null,
                'favoritedUsers' => collect(),
                'noAnimals' => false,
            ]);
        }

        $selectedAnimal = Animal::with([
            'images' => function($q) {
                $q->orderBy('sort_order');
            }
        ])->find($request->animal_id);

        $favoritedUsers = $selectedAnimal
            ? $selectedAnimal->favorites()
                ->where('status', 'pending')
                ->with([
                    'user.image'
                ])
                ->paginate(3)
            : collect();
        
        return view('org.favorite.index', compact(
            'animals',
            'selectedAnimal',
            'favoritedUsers'
        ));
    }

    public function matchIndex(Request $request)
    {
        /** @var \App\Models\User $user */
        $orgUser = Auth::guard('org')->user();

        abort_unless($orgUser, 403);
            // 自分の投稿した動物のみ
        $animals = Animal::where('organization_id', $orgUser->id)
            ->where('adoption_status', 'マッチ中')
            ->with([
                'matche',
                'images' => function($q) {
                    $q->orderBy('sort_order');
                }
            ])
            ->get();

        // マッチ中の動物が0匹
        if($animals->isEmpty()) {
            return view('org.match.index', [
                'animals' => $animals,
                'selectedAnimal' => null,
                'matchedUsers' => collect(),
                'noAnimals' => true,
            ]);
        }

        if(!$request->animal_id) {
            return view('org.match.index', [
                'animals' => $animals,
                'selectedAnimal' => null,
                'matchedUsers' => collect(),
                'noAnimals' => false,
            ]);
        }

        $selectedAnimal = Animal::where('organization_id', $orgUser->id)
            ->with([
                'matche.user',
                'matche.chat.messages',
                'images' => function($q) {
                    $q->orderBy('sort_order');
                }
            ])
            ->find($request->animal_id);

        $matchedUsers = $selectedAnimal?->matche ?? collect();

        // 進行状況
        $timelines = [];
        if($selectedAnimal) {
            foreach($matchedUsers as $match) {
                $timelines[] = [
                    'date' => $match->created_at,
                    'text' => 'マッチが成立しました',
                ];

                foreach($match->chat->messages as $message) {
                    $timelines[] = [
                        'date' => $message->created_at,
                        'text' => $message->sender_type === 'user'
                            ? $match->user->nickname . 'さんがチャットを送信しました'
                            : '保護団体がチャットを送信しました',
                    ];
                }

                if($match->status === '譲渡完了') {
                    $timelines[] = [
                        'date' => $match->updated_at,
                        'text' => '譲渡完了になりました',
                    ];
                }
            }
        }

        $timelines = collect($timelines)
            ->sortByDesc('date')
            ->values()
            ->all();

        return view('org.match.index', compact(
            'animals',
            'selectedAnimal',
            'matchedUsers',
            'timelines',
        ));
    }

    public function approve(Favorite $favorite)
    {

        abort_unless(
            $favorite->animal->organization_id === Auth::guard('org')->id(),
            403
        );

        DB::transaction(function () use($favorite) {

            $animal = $favorite->animal;

            if($animal->matche()->exists()) {
                abort(400, '既にマッチ済みです');
            }

            $favorite->update([
                'status' => 'matched',
            ]);

            $match = AdoptionMatch::create([
                'user_id' => $favorite->user_id,
                'animal_id' => $favorite->animal_id,
                'status' => '譲渡準備中',
            ]);

            Chat::create([
                'match_id' => $match->id,
                'status' => 'active',
            ]);

            $animal->update([
                'adoption_status' => 'マッチ中',
            ]);

            Favorite::where('animal_id', $animal->id)
                ->where('id', '!=', $favorite->id)
                ->update([
                    'status' => 'cancelled',
                ]);

            $organization = $animal->organization;

            $organization->notify(
                new MatchNotification(
                    $favorite->user,
                    $animal
                )
            );
        });

        return back()->with('match_success', 'マッチ承認しました。');
    }

    public function updateStatus(UpdateMatchStatusRequest $request, AdoptionMatch $match)
    {

        abort_unless(
            $match->animal->organization_id === Auth::guard('org')->id(),
            403
        );

        $match->update([
            'status' => $request->validated('status'),
        ]);

        if($request->status === '譲渡完了') {

            $animal = $match->animal;

            if($animal) {
                $animal->update([
                    'adoption_status' => '譲渡完了'
                ]);

                $organization = $animal->organization;

                $organization->notify(
                    new CompleteNotification(
                        $match->user,
                        $animal,
                    )
                );
            }
        }

        return back()->with('success', '進行管理ステータスを更新しました。');
    }

    public function destroy(AdoptionMatch $match)
    {
        abort_unless($match->user_id === Auth::id(),403);

        $animal = $match->animal;

        $favorite = Favorite::where('user_id', $match->user_id)
            ->where('animal_id', $match->animal_id)
            ->latest()
            ->first();

        if($favorite) {
            $favorite->update([
                'status' => 'cancelled',
            ]);
        }

        $match->delete();

        Favorite::where('animal_id', $animal->id)
            ->where('status', 'cancelled')
            ->where('user_id', '!=', $match->user_id)
            ->update([
                'status' => 'pending',
            ]);

        $animal->update([
            'adoption_status' => '募集中',
        ]);

        return back()->with('success', 'マッチをキャンセルしました。');
    }
}

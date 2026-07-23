<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{

    public function index(Request $request)
    {
        $query = Animal::with([
            'organization',
            'images' => function($q) {
                $q->orderBy('sort_order');
            }
        ])->where('adoption_status', '募集中');

        // 名前検索
        if($request->filled('keyword')) {
            $query->where(
                'animal_name',
                'like',
                '%' . $request->input('keyword') . '%'
            );
        }

        // 種類
        if($request->filled('species')) {
            $query->where(
                'species',
                $request->species
            );
        }

        // 年齢
        if($request->filled('age')) {
            $query->where(
                'age',
                $request->age
            );
        }

        // 性別
        if($request->filled('sex')) {
            $query->where(
                'sex',
                $request->sex
            );
        }
        // 性格
        if($request->filled('personality')) {
            $query->where(function($q)
            use ($request) {
                foreach($request->personality as $personality) {
                    $q->orwhereJsonContains(
                        'personality',
                        $personality
                    );
                }
            });
        }

        $animals = $query
            ->paginate(9)
            ->withQueryString();

        $favoriteIds = [];

        if(Auth::guard('web')->check()) {

            /** @var \App\Models\User $user */
            $user = Auth::guard('web')->user();

            $favoriteIds = $user->favorites()
                ->whereIn('status', ['pending', 'matched'])
                ->pluck('animal_id')
                ->toArray();
        }

        foreach($animals as $animal) {
            $animal->isFavorited = in_array($animal->id, $favoriteIds);
        }

        return view('index', compact('animals'));
    }

    // 動物詳細画面
    public function show(int $id)
    {
        $animal = Animal::with('organization')
            ->where('adoption_status', '募集中')
            ->findOrFail($id);
        return view('animals.show', compact('animal'));
    }

    // 動物登録画面
    public function create()
    {
        $animal = new Animal;
        return view('org.animals.create', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        abort_unless($animal->organization_id === Auth::guard('org')->id(), 403);

        if($animal->matche()->whereIn('status', ['譲渡完了'])->exists()) {
            return redirect()
                ->route('org.mypage')
                ->with('error', '譲渡完了のため編集できません');
        }

        if($animal->favorites()->where('status', 'matched')->exists()) {
            return redirect()
                ->route('org.mypage')
                ->with('error', 'マッチ中のため編集できません');
        }

        return view('org.animals.edit', compact('animal'));
    }

    // 動物登録保存処理
    public function store(StoreAnimalRequest $request)
    {
        $animal = Animal::create([
            'animal_name' => $request->animal_name,
            'species' => $request->species,
            'age' => $request->age,
            'sex' => $request->sex,
            'personality' => $request->personality,
            'health_status' => $request->health_status,
            'comment' => $request->comment,
            'adoption_status' => '募集中',

            'organization_id' => Auth::guard('org')->id(),
        ]);

        if($request->filled('animalImages')) {

            $images = json_decode($request->animalImages, true);

            if(count($images) > 5) {
                return back()->withErrors(['animalImages' => '画像は最大5枚までです']);
            }

            foreach ($images as $index => $base64) {
                $image = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
                $image = str_replace(' ', '+', $image);

                $path = 'animals/' .uniqid() . '.jpg';

                Storage::disk('public')->put($path, base64_decode($image));

                $animal->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('org.mypage');
    }

    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $animal->update([
            'animal_name' => $request->animal_name,
            'species' => $request->species,
            'age' => $request->age,
            'sex' => $request->sex,
            'personality' => $request->personality,
            'health_status' => $request->health_status,
            'comment' => $request->comment,
        ]);

        if ($request->filled('animalImages')) {

            $images = json_decode($request->animalImages, true);

            if(count($images) > 5) {
                return back()->withErrors([
                    'animalImages' => '画像は最大5枚までです'
                ]);
            }

            foreach ($images as $index => $imageData) {

                // URLなら並び順だけ更新
                if(str_starts_with($imageData, asset('storage/'))) {

                    $path = str_replace(
                        asset('storage/'),
                        '',
                        $imageData
                    );

                    $animal->images()
                        ->where('path', $path)
                        ->update([
                            'sort_order' => $index
                        ]);

                    continue;
                }

                // 新規base64画像
                $image = preg_replace(
                    '/^data:image\/\w+;base64,/',
                    '',
                    $imageData
                );

                $image = str_replace(' ', '+', $image);

                $path = 'animals/' . uniqid() . '.jpg';

                Storage::disk('public')->put(
                    $path,
                    base64_decode($image)
                );

                $animal->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        if($request->filled('deletedImages')) {
            $deletePaths = json_decode($request->deletedImages, true);

            foreach($animal->images as $img) {
                if(in_array(asset('storage/' .$img->path), $deletePaths)) {
                    Storage::disk('public')->delete($img->path);
                    $img->delete();
                }
            }
        }

        return redirect()->route('org.mypage')->with('success', '動物プロフィールを更新しました');
    }

    public function destroy(Animal $animal)
    {

        if($animal->organization_id !== Auth::guard('org')->id()){
            abort(403);
        }

        if($animal->matche()->exists()) {
            return back()->with(
                'error',
                "{$animal->adoption_status}の動物は削除できません"
            );
        }

        $animal->delete();

        return redirect()->route('org.mypage')->with('success', '削除しました');
    }
}

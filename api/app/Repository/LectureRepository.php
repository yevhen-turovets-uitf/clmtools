<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Lecture;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class LectureRepository
{
    public function create(array $fields): Lecture
    {
        return Lecture::create($fields);
    }

    /**
     * @param int $id
     * @return Lecture
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Lecture
    {
        return Lecture::findOrFail($id);
    }

    public function save(Lecture $lecture): Lecture
    {
        $lecture->save();

        return $lecture;
    }

    public function getLecturesByLecturer(int $id): Collection
    {
        return Lecture::where('author_id', $id)
            ->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function attach(Lecture $lecture, array $arr_user_id): void
    {
        $lecture->users()->sync($arr_user_id);
    }

    public function detach(Lecture $lecture): void
    {
        $lecture->users()->detach();
    }

    public function delete(int $lecture_id): ?bool
    {
        return Lecture::find($lecture_id)->delete();
    }

    public function getUsersId(int $lecture_id): ?array
    {
        return Lecture::find($lecture_id)->users->map(
            function (User $user) {
                return $user->id;
            }
        )->toArray();
    }
}

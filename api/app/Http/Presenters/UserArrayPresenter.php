<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class UserArrayPresenter
{
    public function present(User $user): array
    {
        return [
            'id' => $user->getId(),
            'avatar' => $user->getAvatar(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'last_name' => $user->getLastName(),
            'date_birth' => $user->getDateBirth(),
            'phone' => $user->getPhone(),
            'email_verified_at' => $user->getVerifiedEmail(),
            'city' => $user->getCity(),
            'university' => $user->getUniversity(),
            'graduation_year' => $user->getGraduationYear(),
            'role' => $user->getUserRole(),
            'course' => $user->getCourseTitle(),
            'course_id' => $user->getCourseId()
        ];
    }

    public function getCollections(Collection $users): array
    {
        return $users->map(
                function (User $user) {
                    return $this->present($user);
                }
            )
            ->all();
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;

final class MessageRepository
{
    public function create(array $fields): Message
    {
        return Message::create($fields);
    }

    /**
     * @param int $id
     * @return Message
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Message
    {
        return Message::findOrFail($id);
    }

    public function save(Message $message): Message
    {
        $message->save();

        return $message;
    }

    public function getMessagesByLectureId(int $user_id, int $lecture_id): Collection
    {
        return Chat::where([
            ['user_id', $user_id],
            ['lecture_id', $lecture_id]
        ])->first()
            ->messages()
            ->orderBy('created_at', 'asc')
            ->get();
    }
}

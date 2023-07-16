<?php

namespace App\Http\Controllers\Api;

use App\Actions\Chat\AddChatAction;
use App\Actions\Chat\AddChatRequest;
use App\Actions\Chat\AddMessageAction;
use App\Actions\Chat\AddMessageRequest;
use App\Actions\Chat\GetChatByLectureIdAction;
use App\Actions\Chat\GetChatByLectureIdRequest;
use App\Actions\Chat\GetMessagesByLectureIdAction;
use App\Actions\Chat\GetMessagesByLectureIdRequest;
use App\Http\Presenters\ChatArrayPresenter;
use App\Http\Presenters\MessageArrayPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ChatController extends ApiController
{
    public function store(
        Request $request,
        AddChatAction $action,
        ChatArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new AddChatRequest(
                $request->get('lecture_id')
            )
        );

        return $this->successResponse($presenter->present($response->getChat()));
    }

    public function chat(
        Request $request,
        GetChatByLectureIdAction $action,
        ChatArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new GetChatByLectureIdRequest(
                $request->get('user_id'),
                $request->get('lecture_id')
            )
        );

        return $this->successResponse($presenter->present($response->getChat()));
    }

    public function messages(
        Request $request,
        GetMessagesByLectureIdAction $action,
        MessageArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new GetMessagesByLectureIdRequest(
                $request->get('user_id'),
                $request->get('lecture_id')
            )
        );

        return $this->successResponse($presenter->presentCollection($response->getMessages()));
    }

    public function storeMessage(
        Request $request,
        AddMessageAction $action,
        MessageArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new AddMessageRequest(
                $request->get('lecture_id'),
                $request->get('body'),
                $request->file('file')
            )
        );

        return $this->successResponse($presenter->present($response->getMessage()));
    }
}

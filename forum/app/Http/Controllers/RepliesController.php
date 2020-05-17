<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessages;
use App\Http\Requests\CreatePostRequest;
use App\Thread;
use App\Reply;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\{RedirectResponse, Response};

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * @param $channelId
     * @param Thread $thread
     *
     * @return LengthAwarePaginator
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }
    
    /**
     * @param                   $channelId
     * @param Thread            $thread
     * @param CreatePostRequest $form
     *
     * @return Reply
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        return $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    /**
     * Display the specified resource.
     *
     * @param Reply $reply
     * @return void
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reply $reply
     * @return void
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * @param Reply $reply
     *
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        try {
            request()->validate(['body' => 'required|spamfree']);
            $reply->update(['body' => request('body')]);
        } catch (\Exception $e) {
            return response(ErrorMessages::REPLY_COULD_NOT_BE_SAVED, 422);
        }
    }

    /**
     * @param Reply $reply
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessages;
use App\Inspections\Spam;
use App\Thread;
use App\Reply;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\Validation\ValidationException as ValidationExceptionAlias;

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
     * @param $channelId
     * @param Thread $thread
     *
     * @return Reply|RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        try {
            $this->validateReply();

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            return response(ErrorMessages::REPLY_COULD_NOT_BE_SAVED, 422);
        }

        if(\request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Your reply has been left.');
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
     * @param Request $request
     * @param Reply $reply
     * @param Spam $spam
     *
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);
        try {
            $this->validateReply();
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

    /**
     * @throws ValidationExceptionAlias
     */
    private function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request('body'));
    }
}

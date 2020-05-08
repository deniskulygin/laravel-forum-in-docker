<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Thread;
use App\Reply;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\{RedirectResponse, Request};
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
     * @param Spam $spam
     * @return Reply|RedirectResponse
     * @throws ValidationExceptionAlias
     */
    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(\request(), ['body' => 'required']);

        $spam->detect(request('body'));

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

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
     *
     * @throws AuthorizationException
     * @throws ValidationExceptionAlias
     */
    public function update(Request $request, Reply $reply): void
    {
        $this->authorize('update', $reply);

        $this->validate($request, ['body' => 'required']);

        $reply->update(['body' => $request['body']]);
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

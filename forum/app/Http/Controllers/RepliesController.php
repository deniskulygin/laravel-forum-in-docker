<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use foo\bar;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationExceptionAlias;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @return RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(\request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

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
     * @return \Illuminate\Http\Response
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
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }
}

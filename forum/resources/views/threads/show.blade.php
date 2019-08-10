 @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ route('profile', $thread->creator) }}" >{{ $thread->creator->name }}</a>
                            Posted: {{ $thread->title }}
                        </span>

                        @can ('update', $thread)
                        <form action="{{ $thread->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">Delete Thread</button>
                        </form>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>

            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
                <div class="col-md-8">
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have smth  to say?" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card-header">
                <div class="card-body">
                    <p>
                        This thread was published {{ $thread->created_at->diffForHumans() }} By:
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has
                        {{ $thread->replies_count  }} {{ str_plural('comment'), $thread->replies_count }}.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection
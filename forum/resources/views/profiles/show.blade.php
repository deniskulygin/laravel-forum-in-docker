@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offet-2">
            <div class="page_header">
                <h1>
                    {{ $profileUser->name }}
                </h1>
            </div>
            @forelse ($activities as $date => $activity)
                <h3 class="page-header">{{ $date }}</h3>
                @foreach($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif
                @endforeach
            @empty
                <p>There is no activity for {{ $profileUser->name }}  yet.</p>
            @endforelse
        </div>
    </div>

@endsection

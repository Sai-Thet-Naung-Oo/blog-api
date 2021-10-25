@extends("layouts.app")
@section("content")
<div class="container">

    @if(session('info'))
    <div class="alert alert-danger">
        {{ session('info') }}
    </div>
    @endif

    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">{{ $article->title }}</h5>
            <div class="card-subtitle mb-2 text-muted small">
                By <b>{{ $article->user->name }}</b>,
                {{ $article->created_at->diffForHumans() }}
            </div>
            <p class="card-text">{{ $article->body }}</p>
            <a class="btn btn-warning" href="{{ url("/articles/delete/$article->id") }}">
                Delete
            </a>
        </div>
    </div>

    <h4>Comments ({{ count($article->comments)}}) </h4>
    <ul class="list-group">
        @foreach($article->comments as $comment)
        <li class="list-group-item">
            <a href="{{ url("comments/delete/$comment->id") }}" class="close">
                &times; </a>
            {{ $comment->content }}

            <div class="small mt-2">
                By <b>{{ $comment->user->name }}</b>,
                {{ $comment->created_at->diffForHumans() }}
            </div>
        </li>

        @endforeach

    </ul>

    @auth
    <form action="{{ url('/comments/add') }}" method="post">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <br>
        <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
        <input type="submit" value="Add Comment" class="btn btn-secondary">
    </form>
    @endauth


</div>





@endsection
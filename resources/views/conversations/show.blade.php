@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('conversations.users', ['users' => $users])
        <div class="col-md-9">
            <div class="card">

                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body conversations">

                    @foreach($messages as $message)
                    <div class="row">
                        <div class="col-md-10 {{ $message->from->id !== $user->id ? 'offset-md-2 text-right' : '' }}">
                            <p>
                                <strong>{{ $message->from->id !== $user->id ? 'Moi' : $message->from->name }}</strong><br>
                                {{ $message->content }}
                            </p>
                        </div>
                    </div>
                    @endforeach

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="content" placeholder="Ecrivez un message ..." class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('conversations.users', ['users' => $users])
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                <div class="card-body conversations">
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

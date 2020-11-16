@extends('layouts.app')

@section('style')
    <style>

    </style>
@endsection


@section('script')
    <script>
        function addNextUser() {
            $('#formUserList #list').append('<input placeholder="mail" type="email" name="mail[]"> Admin:<input type="checkbox" name="isAdmin[]"><br />');
        }

        $(function () {
            addNextUser();
        });
    </script>
    @if(isset($script))
        {!! $script !!}
    @endif
@endsection

@section('content')
    <div>
        Dodaj userów do {{ \App\Services\DegustationService::getCurrentDegustation()->getName() }}
        <form action="?" method="post" id="formUserList">
            @csrf
            <div id="list"></div>
            <a onclick="addNextUser()">+</a>
        </form>
    </div>

@endsection

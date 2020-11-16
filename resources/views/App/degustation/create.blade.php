@extends('layouts.app')

@section('style')
    <style>

    </style>
@endsection


@section('script')
    <script>
    </script>
    @if(isset($script))
        {!! $script !!}
    @endif
@endsection

@section('content')
    <div>
        Nazwij swoją degustację
        <form action="?" method="post">
            @csrf
            <input name="name" placeholder="Nazwa" /><br />
            <input type="submit" value="Dodaj" />
        </form>
    </div>

@endsection

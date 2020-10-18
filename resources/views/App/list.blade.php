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
            Lista
    </div>

@endsection

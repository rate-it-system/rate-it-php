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
        <ul>
            @foreach ($list as $row)
                <li>{{ $row->getName() }}</li>
            @endforeach
        </ul>
    </div>

@endsection

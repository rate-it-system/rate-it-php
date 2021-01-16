@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($degustations as $degustation)
                    <div class="card" style="margin-bottom: 5px;">
                        <div class="card-header">{{ $degustation->name }}</div>
                        <div class="card-body">
                            {{ $degustation->description }}
                            <div class="card">
                                <div class="card-header">Zaproś znajomych</div>
                                <input class="card-body"
                                       value="{{ env('APP_URL') }}/invitation/{{ $degustation->invitation_key }}"
                                       onclick="$(this).select();document.execCommand('copy');">
                            </div>
                            <a class="btn btn-success float-right" style="margin-left: 5px;">Start</a>
                            <a class="btn btn-info float-right" style="margin-left: 5px;">Edytuj</a>
                            <a class="btn btn-info float-right" style="margin-left: 5px;">Lista uczestników</a>
                            <a class="btn btn-danger float-right" style="margin-left: 5px;">Usuń</a>
                        </div>
                    </div>
                @endforeach
                <a class="btn btn-info float-right" style="margin-left: 5px;">Następne</a>
                <a class="btn btn-info float-left" style="margin-left: 5px;">Poprzednie</a>
            </div>
        </div>
    </div>
@endsection

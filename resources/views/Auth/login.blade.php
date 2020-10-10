@extends('layouts.guest')

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
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Logowanie
				</span>
                <form class="login100-form validate-form p-b-33 p-t-5">

                    <div class="wrap-input100 validate-input" data-validate = "Enter username">
                        <input class="input100" type="text" name="username" placeholder="Email">
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="pass" placeholder="Hasło">
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn">
                            Zaloguj
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

@endsection

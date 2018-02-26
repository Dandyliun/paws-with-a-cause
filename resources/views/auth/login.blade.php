<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @component('components.head')
    @endcomponent
    <body id="login">
        
        <div class="uk-container-expand uk-height-1-1">

            <div class="uk-height-1-1" uk-grid>

                <!-- Start Login Form -->
                <div class="uk-width-1-2@m uk-height-1-1">
                    <div class="uk-flex uk-flex-center uk-flex-middle uk-height-1-1">
                        <div class="uk-width-2-3@m" uk-scrollspy="cls: uk-animation-slide-left;">

                            <h1>Staff Login</h1>

                            <form class="" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} uk-margin">
                                    <label for="email" class="uk-form-label">Email</label>
                                    <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" required autofocus>
                                    
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} uk-margin">
                                    <label for="password" class="uk-form-label">Password</label>
                                    <input id="password" type="password" class="uk-input" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                </div>


                                <div class="uk-margin" uk-grid>
                                    <div class="uk-width-expand">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </div>
                                    <div class="uk-width-auto">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="uk-button uk-button-primary">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Login Form -->

                <!-- Start Image -->
                <div class="uk-width-1-2@m uk-padding-remove login-image">
                    <div class="color-overlay"></div>
                </div>
                <!-- End Image -->

            </div>
        </div>

        @component('components.scripts')
        @endcomponent
    </body>
</html>

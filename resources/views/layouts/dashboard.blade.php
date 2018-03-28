<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @component('components.head')
    @endcomponent
    <body>

        <div id="topbar" class="uk-margin-remove uk-flex uk-flex-middle" uk-grid uk-height-match>
            <div class="uk-width-medium logo uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <img src="{{ URL::to('/storage/logo.png') }}" />
                </div>
                <div class="uk-width-expand">
                    <p class="logo-title">Paws K9 Care</p>
                </div>
            </div>
            <div class="uk-width-expand text uk-grid-small uk-flex uk-flex-middle uk-padding uk-padding-remove-vertical" uk-grid>
                <div class="uk-width-auto">
                    <a href="/dogs/new" class="add-new uk-icon-button" uk-icon="plus" uk-tooltip="title: Add New Dog; pos: bottom"></a>
                </div>
                <div class="uk-width-expand">
                    <form class="search">
                        <input class="uk-input bordered" placeholder="Search..." />
                    </form>
                </div>
                <div class="uk-width-auto">
                    <p>Welcome, {{ Auth::user()->first_name }}</p>
                </div>
            </div>
        </div>

        <div id="page-wrapper" class="uk-margin-remove" uk-grid>
            <div id="sidebar" class="uk-width-medium">
                <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                    <li class="@if(Request::is('home')) uk-active @endif"><a href="{{ URL::to('/home') }}">Dashboard</a></li>
                    <li class="uk-parent @if(Request::is('dogs/*') || Request::is('dogs')) uk-active uk-open @endif">
                        <a href="#">Dogs</a>
                        <ul class="uk-nav-sub">
                            <li><a href="{{ URL::to('/dogs') }}">View All Dogs</a></li>
                            <li><a href="{{ URL::to('/dogs/new') }}">Add New Dog</a></li>
                        </ul>
                    </li>
                    <li class="uk-parent @if(Request::is('users/*') || Request::is('users')) uk-active uk-open @endif">
                        <a href="#">Users</a>
                        <ul class="uk-nav-sub">
                            <li><a href="{{ URL::to('/users') }}">View All Users</a></li>
                            <li><a href="{{ URL::to('/users/new') }}">Add New User</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Email Log</a></li>
                    @if(Auth::user()->is_admin == 1)
                        <li><a href="#">Settings</a></li>
                    @endif
                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                </ul>

            </div>
            <div id="content" class="uk-width-expand uk-padding">
                @yield('content')
            </div>
        </div>



        <!-- Scripts -->
        @component('components.scripts')
        <script>

            var bar = document.getElementById('js-progressbar');
            UIkit.upload('.js-upload', {

                url: '{{ URL::to("/update-dog-image") }}',
                allow: '*.(jpg|jpeg|png)',
                name: 'image',
                params: { dog_id : $('input[name="dog_id"]').val() },

                beforeSend: function (environment) {
                    // console.log('beforeSend', arguments);

                    // The environment object can still be modified here. 
                    // var {data, method, headers, xhr, responseType} = environment;;

                    $('.spinner-wrapper').show();

                },
                beforeAll: function () {
                    // console.log('beforeAll', arguments);
                },
                load: function () {
                    // console.log('load', arguments);
                },
                error: function () {
                    console.log('error', arguments);
                },
                complete: function () {
                    // console.log('complete', arguments);
                },

                loadStart: function (e) {
                    // Show the progress bar
                    bar.removeAttribute('hidden');
                    // Get the upload start progress
                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                progress: function (e) {
                    // Get the upload progress
                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                loadEnd: function (e) {
                    // Get the upload finished progress
                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                completeAll: function () {
                    // console.log(arguments[0].responseText);

                    // Hide the progress bar
                    bar.setAttribute('hidden', 'hidden');
                    
                    // Get the uploaded file name and generate the path
                    var file_name = arguments[0].responseText;
                    var file_path = '{{ URL::to("storage/profile_images") }}' + '/' + file_name;

                    // Hide the loading spinner
                    $('.spinner-wrapper').hide();

                    // Display the uploaded image
                    $('#profile-image-modal .profile-image').attr('src', file_path);
                    $('header .profile-image').attr('src', file_path);

                    // Hide the error message if it is showing
                    $('.upload-error').hide();

                },

                fail: function () {
                    console.log('error');
                    // var alert = UIkit.alert('#invalid-file-type');
                    $('.upload-error').show();
                }

            });

            // Close error message event listener
            $('.upload-error .close').click(function() {
                $('.upload-error').hide();
            });


        </script>
            @yield('scripts')
        @endcomponent
    </body>
</html>

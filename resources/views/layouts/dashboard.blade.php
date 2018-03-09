<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @component('components.head')
    @endcomponent
    <body>

        <div id="topbar">
            <!--TODO: Add the PAWS Logo and the Search Bar-->
        </div>

        <div  uk-grid>
            <div id="sidebar" class="">
                <ul class="uk-tab-right" uk-tab>
                    <li class="uk-margin-small"><a href="#">Dashboard</a></li>
                    <li class="uk-active uk-margin-small"><a href="#">Dogs</a></li>
                    <li class="uk-margin-small"><a href="#">User</a></li>
                    <li class="uk-margin-small"><a href="#">Profile</a></li>
                    <li class="uk-margin-small"><a href="#">Email Log</a></li>
                    <li class="uk-margin-small"><a href="#">Settings</a></li>
                </ul>
            </div>
            <div id="content">
                @yield('content')
            </div>
        </div>

        <!-- Scripts -->
        @component('components.scripts')
        @endcomponent
    </body>
</html>

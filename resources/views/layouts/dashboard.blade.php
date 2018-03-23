<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @component('components.head')
    @endcomponent
    <body>

        <div id="topbar" class="uk-margin-remove uk-flex uk-flex-middle" uk-grid uk-height-match>
            <div class="uk-width-medium logo">
                <img src="{{ URL::to('/storage/logo.png') }}" />
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
                    <p>Welcome, {{auth()->user()->name}}</p>
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
                            <li><a href="#">Breeds</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Users</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Email Log</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                </ul>

            </div>
            <div id="content" class="uk-width-expand uk-padding">
                @yield('content')
            </div>
        </div>

        <!-- Scripts -->
        @component('components.scripts')
            @yield('scripts')
        @endcomponent
    </body>
</html>

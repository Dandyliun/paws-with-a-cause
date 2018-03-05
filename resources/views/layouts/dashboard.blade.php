<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @component('components.head')
    @endcomponent
    <body>
        
        <div id="topbar">

        </div>

        <div uk-grid>
            <div id="sidebar" class="">

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

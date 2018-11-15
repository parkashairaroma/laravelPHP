{{-- Header --}}
@include('admin.includes.header')

<section class="wrapper">
    <header class="header">
        @include('admin.includes.topbar')
    </header>
    <section class="body">
            @include('admin.includes.sidebar') 
            @yield('content')
    </section>
    <footer class="footer">
        @include('admin.includes.bottombar')
    </footer>
</section>

{{-- Footer --}}
@include('admin.includes.footer')
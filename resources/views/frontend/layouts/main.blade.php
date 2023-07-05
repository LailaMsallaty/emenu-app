  @include('frontend.includes.head')
    <body>
    <!-- Body Wrapper -->
        <div id="body-wrapper">
            <x-alert :errors="$errors" ></x-alert>

            @include('frontend.includes.header')

            <!-- Content -->
            <div id="content" class="bg-light">

                @include('frontend.includes.pagetitle')
                <!-- Page Content -->

                @yield('content')

            <!-- Footer -->
            <footer id="footer" class="bg-dark dark">
                @include('frontend.includes.footer')
            </footer>

           </div>
             @include('frontend.includes.cart')
            <!-- Body Overlay -->
            <div id="body-overlay"></div>

        </div>
        @include('frontend.includes.modalproduct')
        @include('frontend.includes.cookiebar')
        <!-- JS Core -->
        <script src="{{ asset('dist/js/core.js') }}"></script>
    </body>
</html>

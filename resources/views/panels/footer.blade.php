<!-- BEGIN: Footer-->
<footer
    class="footer footer-light {{ $configData['footerType'] === 'footer-hidden' ? 'd-none' : '' }} {{ $configData['footerType'] }}">
    <div class="col d-flex justify-content-between">
        <span class="float-md-start d-none d-md-inline-block mt-25">COPYRIGHT &copy;
            <script>
                document.write(new Date().getFullYear())
            </script><a class="ms-25" target="_blank">{{ siteName() }}</a>,
            <span class="d-none d-sm-inline-block">All rights Reserved</span>
        </span>
        <div class="float-md-end d-block d-md-inline-block ms-auto my-auto border-start px-1" id="txt"></div>
        <div class="dropdown dropdown-language my-auto border-end border-start px-1">
            <a id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true">
                <i class="flag-icon flag-icon-us"></i>
                <i class="bi bi-chevron-up text-dark"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                <a class="dropdown-item" href="{{ url('lang/ar') }}" data-language="ar">
                    <i class="flag-icon flag-icon-iq"></i> Arabic
                </a>
                <a class="dropdown-item" href="{{ url('lang/en') }}" data-language="en">
                    <i class="flag-icon flag-icon-us"></i> English
                </a>
                <a class="dropdown-item" href="{{ url('lang/fr') }}" data-language="fr">
                    <i class="flag-icon flag-icon-fr"></i> French
                </a>
                <a class="dropdown-item" href="{{ url('lang/de') }}" data-language="de">
                    <i class="flag-icon flag-icon-de"></i> German
                </a>
                <a class="dropdown-item" href="{{ url('lang/pt') }}" data-language="pt">
                    <i class="flag-icon flag-icon-pt"></i> Portuguese
                </a>
                <a class="dropdown-item" href="{{ url('lang/vn') }}" data-language="vn">
                    <i class="flag-icon flag-icon-vn"></i> Vietnamese
                </a>
                <a class="dropdown-item" href="{{ url('lang/th') }}" data-language="th">
                    <i class="flag-icon flag-icon-th"></i> Thai
                </a>
                <a class="dropdown-item" href="{{ url('lang/es') }}" data-language="es">
                    <i class="flag-icon flag-icon-es"></i> Spanish
                </a>
                <a class="dropdown-item" href="{{ url('lang/it') }}" data-language="it">
                    <i class="flag-icon flag-icon-it"></i> Italian
                </a>
                <a class="dropdown-item" href="{{ url('lang/nl') }}" data-language="nl">
                    <i class="flag-icon flag-icon-nl"></i> Netherlands
                </a>
            </div>
        </div>
        <div class="d-none d-lg-block my-auto border-start">
            <a class="nav-link fs-4" style="padding-top:0!important;padding-bottom:0!important;">
                <i id="toggleFullScreen" class="bi bi-aspect-ratio" onclick="toggleFullScreen();"></i>
            </a>
        </div>
        <div class="my-auto border-start border-end">
            <a class="nav-link  nav-link-style fs-4" style="padding-top:0!important;padding-bottom:0!important;">
                <i class="bi bi-sun"></i>
            </a>
        </div>

    </div>

    <script>
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                $('#toggleFullScreen')
                    .removeClass('bi-aspect-ratio')
                    .addClass('bi-fullscreen-exit');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                    $('#toggleFullScreen')
                        .removeClass('bi-fullscreen-exit')
                        .addClass('bi-aspect-ratio');
                }
            }
        }

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            var d = today.getFullYear();
            var mm = today.getMonth() + 1;
            var dd = today.getDate();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
                '<div class="d-block d-md-inline-block">' + '<i class="bi bi-clock" style="margin-right:5px"></i>' + d +
                '-' + mm + '-' + dd + '<i class="bi bi-chevron-right mx-1"></i>' + h + ':' + m + ':' +
                '<span class="text-danger">' + s + '</span>' + '</div>';
            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }
    </script>
    <button class="btn scroll-top" style="z-index:10000;" type="button"><i
            class="bi bi-arrow-up-square-fill font-medium-5"></i></button>
    <!-- END: Footer-->

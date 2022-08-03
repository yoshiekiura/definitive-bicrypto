@stack('before-scripts')
<script src="{{ mix('js/frontend/manifest.js') }}"></script>
<script src="{{ mix('js/frontend/vendor.js') }}"></script>
<script src="{{ mix('js/frontend/app.js') }}"></script>
@stack('after-scripts')
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/proper-min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/plugin/waypoint.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/plugin/owl.carousel.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/plugin/jquery.magnific-popup.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/plugin/jquery.nice-select.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/plugin/wow.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/plugin/paroller.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-investment/js/main.js'))}}"></script>

@stack('before-scripts')
<script src="{{ mix('js/frontend/manifest.js') }}"></script>
<script src="{{ mix('js/frontend/vendor.js') }}"></script>
<script src="{{ mix('js/frontend/app.js') }}"></script>
@stack('after-scripts')
<script src="{{ asset(mix('assets/frontends/crypto-card/js/proper-min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-card/js/plugin/waypoint.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-card/js/plugin/jquery.nice-select.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-card/js/plugin/wow.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/crypto-card/js/main.js'))}}"></script>

@stack('before-scripts')
<script src="{{ mix('js/frontend/manifest.js') }}"></script>
<script src="{{ mix('js/frontend/vendor.js') }}"></script>
<script src="{{ mix('js/frontend/app.js') }}"></script>
@stack('after-scripts')
<script src="{{ asset(mix('assets/frontends/default/js/proper-min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/plugin/waypoint.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/plugin/owl.carousel.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/plugin/jquery.magnific-popup.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/plugin/jquery.nice-select.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/plugin/wow.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/plugin/paroller.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/default/js/main.js'))}}"></script>

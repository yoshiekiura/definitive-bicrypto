@stack('before-scripts')
<script src="{{ mix('js/frontend/manifest.js') }}"></script>
<script src="{{ mix('js/frontend/vendor.js') }}"></script>
<script src="{{ mix('js/frontend/app.js') }}"></script>
@stack('after-scripts')
<script src="{{ asset(mix('assets/frontends/payments-finance/js/proper-min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/plugin/waypoint.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/plugin/owl.carousel.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/plugin/jquery.magnific-popup.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/plugin/jquery.nice-select.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/plugin/wow.min.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/plugin/paroller.js'))}}"></script>
<script src="{{ asset(mix('assets/frontends/payments-finance/js/main.js'))}}"></script>

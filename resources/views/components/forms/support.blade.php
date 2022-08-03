<x-forms.post name="form-support" class="row g-4 form-support">
    <div class="col-sm-6">
        <input type="text" name="fullName" id="support_full_name" class="form-control" placeholder="Full name" required="" aria-required="true">
    </div>

    <div class="col-sm-6">
        <input type="email" name="email" id="support_email" class="form-control" placeholder="Email" required="" aria-required="true">
    </div>

    <div class="col-sm-12">
        <input type="text" name="message" id="support_message" class="form-control" placeholder="How can we help?" required="" aria-required="true">
    </div>

    <div class="col-sm-12 d-grid">
        <button data-loading-text="Sending..." type="submit" class="btn btn-rounded btn-primary">@Lang('Submit request')</button>
    </div>
</x-forms.post>

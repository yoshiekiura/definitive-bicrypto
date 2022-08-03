<x-forms.post name="form-trial" class="form-trial">
    <div class="mb-4">
        <input type="email" name="email" class="form-control" placeholder="{{ __('Your valid email address') }}" required>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-rounded btn-primary">@Lang('Start your free trial')</button>
    </div>
</x-forms.post>

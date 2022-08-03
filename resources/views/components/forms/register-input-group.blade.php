@props ([
    'buttonColor' => 'primary'
])
<x-forms.post name="form-register" class="form-register">
    <div class="input-group">
        <input type="email" name="subscribe" class="form-control @rtl rounded-circle-right @else rounded-circle-left @endrtl" placeholder="{{ __('Enter your email') }}" required>
        <button class="btn btn-{{ $buttonColor }}@rtl rounded-circle-left @else rounded-circle-right @endrtl" type="submit">@Lang('Register')</button>
    </div>
</x-forms.post>

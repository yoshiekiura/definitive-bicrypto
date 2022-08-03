<x-forms.post name="form-contact" class="form-contact">
    <div class="mb-4">
        <label for="contact_email" class="text-dark bold mb-0">Email address</label>
        <div id="emailHelp" class="small form-text text-secondary mt-0 mb-2 italic">We'll never share your email with anyone else.</div>
        <input type="email" name="email" id="contact_email" class="form-control bg-contrast" placeholder="Valid Email" required>
    </div>

    <div class="mb-4">
        <label for="contact_email" class="text-dark bold">Subject</label>
        <input type="text" name="subject" id="contact_subject" class="form-control bg-contrast" placeholder="Subject" required>
    </div>

    <div class="mb-4">
        <label for="contact_email" class="text-dark bold">Message</label>
        <textarea name="message" id="contact_message" class="form-control bg-contrast" placeholder="What do you want to let us know?" rows="8" required></textarea>
    </div>

    <div class="d-grid gap-2">
        <button id="contact-submit" data-loading-text="Sending..." name="submit" type="submit" class="btn btn-primary btn-rounded">
            @Lang('Send Message')
        </button>
    </div>
</x-forms.post>

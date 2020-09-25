<script src="https://www.google.com/recaptcha/api.js"></script>
{{-- Add a callback function to handle the token: onSubmit(token) --}}
<button class="g-recaptcha"
        data-sitekey="{{ $public_key }}"
        data-callback='{{isset($options['callback']) ? $options['callback'] : 'onSubmit'}}'
        data-action='{{isset($options['action']) ? $options['action'] : 'register'}}'>
    {{isset($options['button_title']) ? $options['button_title'] : 'Submit'}}
</button>
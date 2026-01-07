@props([
    'email',
    'class' => '',
    'showIcon' => false,
])

@php
    $parts = explode('@', $email);
    $user = $parts[0] ?? '';
    $domain = $parts[1] ?? '';
    $encodedEmail = base64_encode($email);
    $uniqueId = 'email-' . uniqid();
@endphp

<a
    id="{{ $uniqueId }}"
    href="#"
    class="{{ $class }}"
    data-u="{{ base64_encode($user) }}"
    data-d="{{ base64_encode($domain) }}"
    onclick="return false;"
>
    @if($showIcon)
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
        </svg>
    @endif
    <span class="email-text">{{ $slot->isEmpty() ? str_replace('@', ' [at] ', $email) : $slot }}</span>
</a>

<script>
    (function() {
        var el = document.getElementById('{{ $uniqueId }}');
        if (el) {
            var u = atob(el.getAttribute('data-u'));
            var d = atob(el.getAttribute('data-d'));
            var email = u + '@' + d;
            el.href = 'mailto:' + email;
            el.removeAttribute('onclick');
            var textSpan = el.querySelector('.email-text');
            if (textSpan && textSpan.textContent.includes('[at]')) {
                textSpan.textContent = email;
            }
        }
    })();
</script>


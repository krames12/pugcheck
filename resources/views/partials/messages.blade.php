<div class="message-box">
    @if (session('error'))
        {{ session('error') }}
    @endif

    @if (session('success'))
        {{ session('success') }}
    @endif
</div>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', optional($user)->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', optional($user)->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <div class="mt-6">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Appearance') }}</h3>
        <p class="text-sm text-gray-600">{{ __('Toggle dark mode for your account (persists to your profile when available).') }}</p>

        <div class="mt-3 flex items-center gap-3">
            <label for="dark-mode-toggle" class="inline-flex items-center cursor-pointer">
                <input id="dark-mode-toggle" type="checkbox" class="hidden" @if(old('dark_mode', $user->dark_mode ?? false)) checked @endif>
                <span id="dark-mode-switch" class="w-12 h-6 bg-gray-300 rounded-full relative transition-colors duration-200">
                    <span id="dark-mode-knob" class="absolute left-0 top-0.5 w-5 h-5 bg-white rounded-full shadow transform transition-transform duration-200"></span>
                </span>
            </label>
            <span id="dark-mode-label" class="text-sm text-gray-700">@if(old('dark_mode', $user->dark_mode ?? false)) {{ __('Dark') }} @else {{ __('Light') }} @endif</span>
        </div>

        <script>
            (function(){
                const checkbox = document.getElementById('dark-mode-toggle');
                const switchEl = document.getElementById('dark-mode-switch');
                const knob = document.getElementById('dark-mode-knob');
                const label = document.getElementById('dark-mode-label');

                function setVisual(checked){
                    if(checked){
                        switchEl.classList.remove('bg-gray-300');
                        switchEl.classList.add('bg-indigo-600');
                        knob.style.transform = 'translateX(24px)';
                        label.textContent = 'Dark';
                        document.body.setAttribute('data-theme','dark');
                    } else {
                        switchEl.classList.add('bg-gray-300');
                        switchEl.classList.remove('bg-indigo-600');
                        knob.style.transform = 'translateX(0px)';
                        label.textContent = 'Light';
                        document.body.setAttribute('data-theme','light');
                    }
                }

                // initialize from server-rendered checked state
                setVisual(checkbox.checked);

                // clicking the visible switch toggles state
                switchEl.parentElement.addEventListener('click', function(){
                    const newState = !checkbox.checked;
                    // optimistic UI update
                    checkbox.checked = newState;
                    setVisual(newState);

                    fetch("/profile/toggle-dark-mode", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    }).then(res => res.json()).then(json => {
                        setVisual(!!json.dark_mode);
                    }).catch(() => {
                        // revert on error
                        checkbox.checked = !newState;
                        setVisual(!newState);
                    });
                });
            })();
        </script>
    </div>
</section>

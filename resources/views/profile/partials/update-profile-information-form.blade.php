

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card h-100">
                <div class="card-body">

                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Profile Information') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Update your account's profile information and email address.") }}
                                </p>
                            </header>

                            <form id="profileForm" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                                    <input id="name" name="name" type="text" class="mt-1 block w-full form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    @if ($errors->has('name'))
                                        <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div>
                                    <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                                    <input id="email" name="email" type="email" class="mt-1 block w-full form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    @if ($errors->has('email'))
                                        <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('email') }}</span>
                                    @endif

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}

                                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <input type="hidden" name="notify_bulletins" value="0">
                                    <label for="notify_bulletins" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Receive Bulletin Notifications') }}</label>
                                    <input id="notify_bulletins" name="notify_bulletins" type="checkbox" class="mt-1 block" value="1" {{ old('notify_bulletins', $user->notify_bulletins) ? 'checked' : '' }}>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                    @if (session('status') === 'profile-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600 dark:text-gray-400"
                                        >{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>

                </div>
            </div>
        </div>
    </div>


<script>
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        console.log('Form Data:', data);
    });
</script>


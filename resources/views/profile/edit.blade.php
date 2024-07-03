@extends('layout.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <section>
                            <header>
                                <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" class="rounded-circle"
                                width="200" height="200" style="  display: block;
  margin-left: auto;
  margin-right: auto;
margin-bottom: 20px">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Profile Information') }}

                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Update your account's profile information and email address.") }}
                                </p>
                            </header>

                            <form id="profileForm" method="post" action="{{ route('profile.update') }}"
                                enctype="multipart/form-data" class="mt-6 space-y-6">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                        style="margin-top:15px">{{ __('Name') }}</label>
                                    <input id="name" name="name" type="text"
                                        class="mt-1 block w-full form-control" value="{{ old('name', $user->name) }}"
                                        required autofocus autocomplete="name">
                                    @if ($errors->has('name'))
                                        <span
                                            class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div>
                                    <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                        style="margin-top:15px">{{ __('Email') }}</label>
                                    <input id="email" name="email" type="email"
                                        class="mt-1 block w-full form-control" value="{{ old('email', $user->email) }}"
                                        required autocomplete="username">
                                    @if ($errors->has('email'))
                                        <span
                                            class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('email') }}</span>
                                    @endif

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}

                                                <button form="send-verification"
                                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                    @endif
                                </div>

                                <div>
                                    <label for="profile_photo"
                                        class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                        style="margin-top:15px">{{ __('Profile Photo') }}</label>
                                    <input id="profile_photo" name="profile_photo" type="file"
                                        class="mt-1 block w-full form-control" accept="image/*" >
                                    @if ($errors->has('profile_photo'))
                                        <span
                                            class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('profile_photo') }}</span>
                                    @endif
                                </div>

                                <div>
                                    <input type="hidden" name="notify_bulletins" value="0">
                                    <label for="notify_bulletins"
                                        class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                        style="margin-top:15px">{{ __('Receive Bulletin Notifications') }}</label>
                                    <input id="notify_bulletins" name="notify_bulletins" type="checkbox" class="mt-1 block"
                                        value="1"
                                        {{ old('notify_bulletins', $user->notify_bulletins) ? 'checked' : '' }}>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="btn btn-primary"
                                        style="margin-top:15px">{{ __('Save') }}</button>

                                    @if (session('status') === 'profile-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-md-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">

                    </div>
                    <div class="card-body">

                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Password') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Current Password') }}</label>
                                <input id="update_password_current_password" name="current_password" type="password"
                                    class="mt-1 block w-full form-control" autocomplete="current-password">
                                @if ($errors->updatePassword->has('current_password'))
                                    <span
                                        class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->first('current_password') }}</span>
                                @endif
                            </div>

                            <div>
                                <label for="update_password_password"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('New Password') }}</label>
                                <input id="update_password_password" name="password" type="password"
                                    class="mt-1 block w-full form-control" autocomplete="new-password">
                                @if ($errors->updatePassword->has('password'))
                                    <span
                                        class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->first('password') }}</span>
                                @endif
                            </div>

                            <div>
                                <label for="update_password_password_confirmation"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Confirm Password') }}</label>
                                <input id="update_password_password_confirmation" name="password_confirmation"
                                    type="password" class="mt-1 block w-full form-control" autocomplete="new-password">
                                @if ($errors->updatePassword->has('password_confirmation'))
                                    <span
                                        class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="btn btn-primary"
                                    style="margin-top:15px">{{ __('Save') }}</button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            </dvi>

            <div class="row">

                <div class="col-lg-12 col-md-12 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row">
                                <section class="space-y-6">
                                    <header>
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Delete Account') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                                        </p>
                                    </header>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirm-user-deletion">
                                        {{ __('Delete Account') }}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="confirm-user-deletion" tabindex="-1"
                                        aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('profile.destroy') }}"
                                                    class="p-6">
                                                    @csrf
                                                    @method('delete')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirm-user-deletion-label">
                                                            {{ __('Are you sure you want to delete your account?') }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                                        </p>

                                                        <div class="mt-6">
                                                            <label for="password"
                                                                class="sr-only">{{ __('Password') }}</label>
                                                            <input id="password" name="password" type="password"
                                                                class="mt-1 block w-3/4 form-control"
                                                                placeholder="{{ __('Password') }}">
                                                            @if ($errors->userDeletion->has('password'))
                                                                <span
                                                                    class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->userDeletion->first('password') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-danger ms-3"
                                                            style="margin-top:15px">
                                                            {{ __('Delete Account') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
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



            {{-- @include('profile.partials.receive-bulletin-notification') --}}
            {{-- @include('profile.partials.update-profile-information-form') --}}


            {{-- @include('profile.partials.update-password-form') --}}

            {{-- @include('profile.partials.delete-user-form') --}}

        </div>
    </div>
@endsection

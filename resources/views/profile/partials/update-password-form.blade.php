


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
                                <label for="update_password_current_password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Current Password') }}</label>
                                <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password">
                                @if ($errors->updatePassword->has('current_password'))
                                    <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->first('current_password') }}</span>
                                @endif
                            </div>

                            <div>
                                <label for="update_password_password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('New Password') }}</label>
                                <input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password">
                                @if ($errors->updatePassword->has('password'))
                                    <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->first('password') }}</span>
                                @endif
                            </div>

                            <div>
                                <label for="update_password_password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Confirm Password') }}</label>
                                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password">
                                @if ($errors->updatePassword->has('password_confirmation'))
                                    <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                @if (session('status') === 'password-updated')
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

                </div>
            </div>
        </div>

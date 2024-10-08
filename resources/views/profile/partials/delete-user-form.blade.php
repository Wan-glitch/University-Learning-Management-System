
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

                            <button
                                type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#confirm-user-deletion"
                            >
                                {{ __('Delete Account') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                            @csrf
                                            @method('delete')

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirm-user-deletion-label">
                                                    {{ __('Are you sure you want to delete your account?') }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                                </p>

                                                <div class="mt-6">
                                                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                                                    <input
                                                        id="password"
                                                        name="password"
                                                        type="password"
                                                        class="mt-1 block w-3/4 form-control"
                                                        placeholder="{{ __('Password') }}"
                                                    >
                                                    @if ($errors->userDeletion->has('password'))
                                                        <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->userDeletion->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    {{ __('Cancel') }}
                                                </button>
                                                <button type="submit" class="btn btn-danger ms-3">
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

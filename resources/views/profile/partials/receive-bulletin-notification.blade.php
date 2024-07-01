<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <section>

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="notify_bulletins">Receive Bulletin Notifications:</label>
                                    <input type="checkbox" name="notify_bulletins" id="notify_bulletins" {{ old('notify_bulletins', auth()->user()->notify_bulletins) ? 'checked' : '' }}>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Preferences</button>
                            </form>


                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

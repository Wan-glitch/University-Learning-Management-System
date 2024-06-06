@extends('layout.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- User list -->
            <div class="col-lg-12 col-md-12 col-12 mb-4">
                {{-- <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="container-fluid">
                            <div class="row"> --}}
                                @include('profile.partials.update-profile-information-form')
                            {{-- </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="container-fluid">
                            <div class="row"> --}}
                                @include('profile.partials.update-password-form')
                            {{-- </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="container-fluid">
                            <div class="row"> --}}
                                @include('profile.partials.delete-user-form')
                            {{-- </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

{{-- <style>
    .card {
        min-height: 100px; /* Set a minimum height for all cards */
        margin-bottom: 20px; /* Ensure there is space between the cards */
    }
    .card-header {
        background-color: #f8f9fa; /* Light background for header */
        border-bottom: 1px solid #e9ecef; /* Light border for header */
    }
    .card-body {
        padding: 20px;
    }
</style> --}}

@extends('frontend.layouts.app')

@section('title', 'Welcome to BidTrack')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@section('content')
    @include('frontend.welcome_page.header')
    @include('frontend.welcome_page.banner')
    @include('frontend.welcome_page.about')
    @include('frontend.welcome_page.features')
    @include('frontend.welcome_page.footer')
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Show Tender page  --}}
    <script>
        $(document).on('click', '.show-tender', function() {
            let id = $(this).data('id');
            window.location.href = `/tenders/${id}`; // Adjust route if using named route or prefix
        });
    </script>

    {{-- Toast Notifications --}}
    @if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                @if (session('success'))
                    Toast.fire({
                        icon: 'success',
                        title: @json(session('success'))
                    });
                @elseif (session('error'))
                    Toast.fire({
                        icon: 'error',
                        title: @json(session('error'))
                    });
                @elseif (session('warning'))
                    Toast.fire({
                        icon: 'warning',
                        title: @json(session('warning'))
                    });
                @elseif (session('info'))
                    Toast.fire({
                        icon: 'info',
                        title: @json(session('info'))
                    });
                @endif
            });
        </script>
    @endif
@endsection

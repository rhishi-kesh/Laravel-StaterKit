@extends('layout/index')
@section('content')
    <div class="pt-5">
        <form action="{{ route('systemInformationPost', $data->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 shadow-md rounded px-4 md:px-8 pt-6 pb-8 mb-4">
            @csrf
            <h2 class="mb-2 font-bold text-3xl dark:text-white text-blue-500">System Information</h2>
            @if (Session::has('success'))
                <div class="flex items-center p-4 mb-4 text-sm text-green-900 rounded-lg bg-green-300 dark:bg-gray-800 dark:text-green-400 select-none" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        {{ Session::get('success') }}
                    </div>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="flex items-center p-4 mb-4 text-sm text-red-900 rounded-lg bg-red-300 dark:bg-gray-800 dark:text-red-400 select-none" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        {{ Session::get('error') }}
                    </div>
                </div>
            @endif
            <hr>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">
                <div class="mb-1">
                    <label for="email" class="my-label">Email</label>
                    <input type="text" value="{{ $data->email }}" name="email" placeholder="Email" id="email" class="my-input focus:outline-none focus:shadow-outline">
                    @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="number" class="my-label">Number</label>
                    <input type="number" value="{{ $data->number }}" name="number" placeholder="Number" id="number" class="my-input focus:outline-none focus:shadow-outline">
                    @error('number')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="location" class="my-label">Location</label>
                    <input type="text" value="{{ $data->location }}" name="location" placeholder="Location" id="location" class="my-input focus:outline-none focus:shadow-outline">
                    @error('location')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="logo" class="my-label">Logo</label>
                    <input type="file" name="logo" placeholder="Logo" id="logo" class="my-input focus:outline-none focus:shadow-outline">
                    @error('logo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <img src="{{ asset('storage/' . $data->logo) }}" width="100" height="100" alt="Preview" class="mt-1" id="logo_p">
                    @push('js')
                        <script>
                            logo.onchange = evt => {
                                const [file] = logo.files
                                if (file) {
                                    logo_p.src = URL.createObjectURL(file)
                                }
                            }
                        </script>
                    @endpush
                </div>
                <div class="mb-1">
                    <label for="fav" class="my-label">Favicon</label>
                    <input type="file" name="favicon" placeholder="Fav" id="fav" class="my-input focus:outline-none focus:shadow-outline">
                    @error('favicon')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <img src="{{ asset('storage/' . $data->fav) }}" width="40" height="40" id="fav_p" alt="Preview" class="mt-1">
                    @push('js')
                        <script>
                            fav.onchange = evt => {
                                const [file] = fav.files
                                if (file) {
                                    fav_p.src = URL.createObjectURL(file)
                                }
                            }
                        </script>
                    @endpush
                </div>
            </div>
            <div class="flex justify-start items-center mt-5">
                <button type="submit" class="btn-submit btn mr-4">Update</button>
            </div>
        </form>
    </div>
@endsection

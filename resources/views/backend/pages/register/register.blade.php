@extends('layout/index')
@section('content')
    <div class="pt-5">
        <form action="{{ route('registerPost') }}" method="POST" class="bg-white dark:bg-slate-900 shadow-md rounded px-4 md:px-8 pt-6 pb-8 mb-4">
            @csrf
            <h2 class="mb-2 font-bold text-3xl dark:text-white text-blue-500">Add User</h2>
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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                <div class="mb-1">
                    <label for="Name" class="my-label">Name</label>
                    <input type="text" name="name" placeholder="Name" id="Name" class="my-input focus:outline-none focus:shadow-outline">
                    @error('name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="email" class="my-label">Email</label>
                    <input type="email" name="email" placeholder="Email" id="email" class="my-input focus:outline-none focus:shadow-outline appearance-none">
                    @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="password" class="my-label">Password</label>
                    <input type="password" name="password" placeholder="Password" id="password" class="my-input focus:outline-none focus:shadow-outline appearance-none">
                    @error('password')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="Cpassword" class="my-label">Confirm Password</label>
                    <input type="password" name="Cpassword" placeholder="Confirm Password" id="Cpassword" class="my-input focus:outline-none focus:shadow-outline appearance-none">
                    @error('Cpassword')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex justify-start items-center mt-4">
                <button type="submit" class="btn-submit btn mr-4">Add</button>
            </div>
        </form>
    </div>
@endsection

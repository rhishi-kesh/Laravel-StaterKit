@extends('layout/index')
@section('content')
    <div class="pt-5">
        <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-3 xl:grid-cols-4">
            <div class="bg-white rounded dark:bg-[#0E1726] p-5 flex items-center justify-center flex-col w-full h-full gap-5">
                @if (Session::has('successprofile'))
                    <div class="flex items-center p-4 mb-4 text-sm text-green-900 rounded-lg bg-green-300 dark:bg-gray-800 dark:text-green-400 select-none" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            {{ Session::get('successprofile') }}
                        </div>
                    </div>
                @endif
                @if (Session::has('errorprofile'))
                    <div class="flex items-center p-4 mb-4 text-sm text-red-900 rounded-lg bg-red-300 dark:bg-gray-800 dark:text-red-400 select-none" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            {{ Session::get('errorprofile') }}
                        </div>
                    </div>
                @endif
                <div>
                    <form action="{{ route('changeProfile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="avatar-upload text-center">
                            <div class="avatar-edit">
                                <input type='file' name="profile_image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload" class="imageUpload !flex justify-center items-center">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="upload-button text-blue-500">
                                        <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="1.5"></circle>
                                        <path opacity="0.5" d="M9.77778 21H14.2222C17.3433 21 18.9038 21 20.0248 20.2646C20.51 19.9462 20.9267 19.5371 21.251 19.0607C22 17.9601 22 16.4279 22 13.3636C22 10.2994 22 8.76721 21.251 7.6666C20.9267 7.19014 20.51 6.78104 20.0248 6.46268C19.3044 5.99013 18.4027 5.82123 17.022 5.76086C16.3631 5.76086 15.7959 5.27068 15.6667 4.63636C15.4728 3.68489 14.6219 3 13.6337 3H10.3663C9.37805 3 8.52715 3.68489 8.33333 4.63636C8.20412 5.27068 7.63685 5.76086 6.978 5.76086C5.59733 5.82123 4.69555 5.99013 3.97524 6.46268C3.48995 6.78104 3.07328 7.19014 2.74902 7.6666C2 8.76721 2 10.2994 2 13.3636C2 16.4279 2 17.9601 2.74902 19.0607C3.07328 19.5371 3.48995 19.9462 3.97524 20.2646C5.09624 21 6.65675 21 9.77778 21Z" stroke="currentColor" stroke-width="1.5"></path>
                                        <path d="M19 10H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" class="bg-white" style="background-image: url('{{ empty(Auth::user()->profile) ? asset('profile.jpeg') : asset('storage/' . auth()->user()->profile) }}');">
                                </div>
                            </div>
                            @error('profile_image')
                                <div class="text-red-500 mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex justify-center mt-4">
                            <button type="submit" class="btn btn-submit uppercase cursor-pointer">
                                Update
                            </button>
                        </div>
                    </form>
                    @push('js')
                        <script>
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                                        $('#imagePreview').hide();
                                        $('#imagePreview').fadeIn(650);
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                            $("#imageUpload").change(function() {
                                readURL(this);
                            });
                        </script>
                    @endpush
                </div>
            </div>
            <div class="lg:col-span-2 xl:col-span-3 ng-tns-c265-3">
                <div class="bg-white rounded dark:bg-[#0E1726] p-5">
                    <div class="mb-5 ng-tns-c265-3">
                        <h5 class="mb-2 font-bold text-3xl dark:text-white text-blue-500">Update Information </h5>
                    </div>
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
                    <div class="mb-5 ng-tns-c265-3">
                        <form action="{{ route('changeInformation', auth()->user()->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label for="Name" class="my-label">Name</label>
                                    <input type="text" value="{{ auth()->user()->name }}" name="name" placeholder="Name" id="Name" class="my-input focus:outline-none ">
                                    @error('name')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="Name" class="my-label">Email</label>
                                    <input type="text"  value="{{ auth()->user()->email }}" name="email" placeholder="Email" id="email" class="my-input focus:outline-none ">
                                    @error('email')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-submit uppercase cursor-pointer">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-white rounded dark:bg-[#0E1726] p-5 mt-6">
                    <div class="mb-5 ng-tns-c265-3">
                        <h5 class="mb-2 font-bold text-3xl dark:text-white text-blue-500">Change Password</h5>
                    </div>
                    @if (Session::has('successp'))
                        <div class="flex items-center p-4 mb-4 text-sm text-green-900 rounded-lg bg-green-300 dark:bg-gray-800 dark:text-green-400 select-none" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{ Session::get('successp') }}
                            </div>
                        </div>
                    @endif
                    @if (Session::has('errorp'))
                        <div class="flex items-center p-4 mb-4 text-sm text-red-900 rounded-lg bg-red-300 dark:bg-gray-800 dark:text-red-400 select-none" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{ Session::get('errorp') }}
                            </div>
                        </div>
                    @endif
                    <div class="mb-5 ng-tns-c265-3">
                        <form action="{{ route('changePassword', auth()->user()->id) }}" method="POST">
                            @csrf
                            <div class=" grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                                <div class="mb-1">
                                    <label for="Email" class="my-label">Current Password</label>
                                    <input type="password" name="current_password" placeholder="current password" type="password" id="Email" name="email" class=" form-control my-input focus:outline-none focus:shadow-outline">
                                    @error('current_password')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @if (Session::has('old'))
                                        <div class="text-red-500">{{ Session::get('old') }}</div>
                                    @endif
                                </div>
                                <div class="mb-1">
                                    <label for="Email" class="my-label">New Password</label>
                                    <input type="password" name="password" placeholder="Enter new password" type="password" id="password" name="password" class=" form-control my-input focus:outline-none focus:shadow-outline">
                                    @error('password')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-1">
                                    <label for="Email" class="my-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" placeholder="Enter Confirm password" type="password" id="password_confirmation" class=" form-control my-input focus:outline-none focus:shadow-outline">
                                    @error('password_confirmation')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-submit uppercase cursor-pointer">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

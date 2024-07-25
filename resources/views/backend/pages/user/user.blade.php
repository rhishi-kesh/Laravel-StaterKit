@extends('layout/index')
@section('content')
    <div class="pt-5">
        <div class="bg-white dark:bg-slate-900 shadow-md rounded px-4 md:px-6 pt-6 pb-5 mb-4 w-full">
            <h2 class="mb-2 font-bold text-3xl dark:text-white text-blue-500">Users</h2>
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
            <div class="w-full">
                <div class="overflow-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">SL</th>
                                <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Photo</th>
                                <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Name</th>
                                <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Email</th>
                                <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Status</th>
                                <th class="p-3 bg-gray-100 dark:bg-gray-800 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $data)
                                <tr class="border-b border-[#ebedf2] dark:border-[#191e3a]">
                                    <td class="p-3 text-center">{{ $users->firstItem() + $key }}</td>
                                    <td class="p-3 flex justify-center">
                                        @if(empty($data->profile))
                                            <div class="profile">{{ mb_substr(strtoupper($data->name), 0, 1) }}</div>
                                        @else
                                            <img class="h-9 w-9 rounded-full object-cover bg-white" src="{{ asset('storage/' . $data->profile) }}" alt="image">
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">{{ $data->name }}</td>
                                    <td class="p-3 text-center">{{ $data->email }}</td>
                                    <td class="p-3 border-b border-[#ebedf2] dark:border-[#191e3a]">
                                        <div class="flex justify-center items-center">
                                            <label class="w-12 h-6 relative">
                                                <input type="checkbox" class="checkbox peer" onclick="userStatus({{ $data->id }})" id="" @if($data->status == '0') checked @else @endif />
                                                <span for="custom_switch_checkbox6" class="checkboxSpan"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="p-3 mb-2 flex justify-center items-center">

                                        {{-- Delete Button --}}
                                        <a href="{{ route('userDelete', $data->id) }}" x-tooltip="Delete">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash text-red-500"><path class="text-red-500" stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path class="text-red-500" d="M10 11l0 6" /><path class="text-red-500" d="M14 11l0 6" /><path class="text-red-500" d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path class="text-red-500" d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20">
                                        <div class="flex justify-center items-center">
                                            <img src="{{ asset('empty.png') }}" alt="" class="w-[200px] opacity-40 dark:opacity-15 mt-10 select-none">
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="py-4 px-3 pb-0 mb-0">
                {{ $users->links() }}
            </div>
        </div>
        @push('js')
            <script>
                function userStatus(id) {
                    $.ajax({
                        url: "{{ url('/admin/user-status') }}"+"/"+id,
                        type: "GET",
                        dataType: 'json',
                        data: id,
                        contentType: false,
                        processData: false,
                        success: function(respons){
                            console.log(respons);
                        }
                    });
                }
            </script>
        @endpush
    </div>
@endsection

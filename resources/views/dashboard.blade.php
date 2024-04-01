<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Steam Trading Website
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('create-post') }}">
                @csrf
                <div class="flex gap-4 mb-4">
                    <div class="w-full">
                        <label for="username" class="block mb-2 text-sm font-bold text-gray-700">Have:</label>
                        <input type="text" id="have" name="have"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="w-full">
                        <label for="username" class="block mb-2 text-sm font-bold text-gray-700">Want:</label>
                        <input type="text" id="want" name="want"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                <button type="submit"
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">Submit</button>
            </form>
            @foreach ($posts as $post)
                <div class="flex items-center pl-5 mt-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    @if ($post->user->profile_picture)
                        <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $post->user->profile_picture) }}"
                            alt="Profile Picture">
                    @else
                        <img class="w-10 h-10 rounded-full" src="https://picsum.photos/200" alt="Profile Picture">
                    @endif
                    <div class="p-6 text-gray-900">
                        [H] {{ $post->selling }} [W] {{ $post->buying }}
                    </div>
                </div>
            @endforeach
            {{-- <div>
                {{$posts[0]}}
            </div>
            <div>
                {{$posts[0]->title}}
            </div> --}}
        </div>
    </div>
</x-app-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <input type="text" id="searchInput"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            placeholder="Type at least 3 letters">
                        <div id="searchResults"
                            class="absolute left-0 hidden w-full mt-1 bg-white border border-gray-300 rounded-b shadow-lg">
                        </div>
                    </div>
                    {{-- {{ csrf_field() }} --}}
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
    <script>
        $(document).ready(function() {
            $('#searchInput').keyup(function() {
                var query = $(this).val();
                if (query.length >= 3) {
                    $.ajax({
                        url: '/search',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            var dropdown = $('#searchResults');
                            dropdown.empty();
                            if (data.length > 0) {
                                dropdown.removeClass('hidden');
                                dropdown.addClass('block');
                                var inputOffset = $('#searchInput').offset();
                                var inputWidth = $('#searchInput').outerWidth();
                                dropdown.css({
                                    'width': inputWidth,
                                    'left': inputOffset.left
                                });
                                $.each(data, function(index, result) {
                                    var listItem = $('<div>').addClass(
                                        'px-4 py-2 cursor-pointer hover:bg-gray-100'
                                    ).text(result.name);
                                    listItem.on('click', function() {
                                        $('#searchInput').val(result.name);
                                        dropdown.empty().addClass('hidden');
                                        $('#searchInput').blur();
                                        // Redirect or perform desired action here
                                    });
                                    dropdown.append(listItem);
                                });
                            } else {
                                dropdown.removeClass('block');
                                dropdown.addClass('hidden');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#searchResults').empty().addClass('hidden');
                }
            });
        });
    </script>
</x-app-layout>

{{-- <script>
    $(function() {
        $("#searchInput").typeahead({
            source: function(request, response) {
                $.ajax({
                    url: "/search",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.name,
                                value: item.name
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $("#name").val(ui.item.name);
                $("#value").val(ui.item.name);
                return false;
            }
        });
    });
    // $(document).ready(function() {
    //     $('#searchInput').on('input', function() {
    //         var query = $(this).val();

    //         if (query.length >= 3) {
    //             $.ajax({
    //                 url: '/search',
    //                 method: 'GET',
    //                 data: {
    //                     query: query
    //                 },
    //                 success: function(response) {
    //                     console.log(response)
    //                     var dropdown = $('#dropdownList');
    //                     dropdown.empty();

    //                     // Ensure response is an array and has elements
    //                     if (Array.isArray(response) && response.length > 0) {
    //                         response.forEach(function(item) {
    //                             dropdown.append($('<option></option>').attr('value',
    //                                 item.id).text(item.name));
    //                         });
    //                     } else {
    //                         // Handle empty or invalid response
    //                         dropdown.append($('<option></option>').text(
    //                             'No results found'));
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });
    // $(document).ready(function() {
    //     $('#searchInput').autocomplete({
    //         // minLength: 3, // Minimum number of characters before autocomplete starts
    //         source: function(request, response) {
    //             $.ajax({
    //                 url: '/search',
    //                 method: 'GET',
    //                 data: {
    //                     query: request.term
    //                 },
    //                 success: function(data) {
    //                     console.log(data)
    //                     // Transform the data as needed for autocomplete
    //                     response($.map(data, function(item) {
    //                         return {
    //                             label: item.name,
    //                             value: item.name
    //                         };
    //                     }));
    //                     // response(data);
    //                 }
    //             });
    //         },
    //         select: function(event, ui) {
    //             // Handle selection from the autocomplete dropdown
    //             // For example, you can fill other fields based on the selection
    //             $("#name").val(ui.item.label);
    //             $("#value").val(ui.item.value);
    //             return false;
    //         }
    //     });
    // });
</script> --}}

<div style="margin: 50px">
    <a href="{{route('media-library.index')}}">Index</a>
    <a href="{{route('media-library.create')}}">Create</a>


    @if ($type == 'index')
    <h1>Index</h1>
    <table>
        @foreach ($data as $item)
        <tr>
            <td>
                {{$item->title}}
            </td>
            <td>
                <a href="{{ route('media-library.destroy', $item->id) }}" onclick="event.preventDefault();
                             if (confirm('Are you sure you want to delete this item?')) {
                                 document.getElementById('delete-form-{{ $item->id }}').submit();
                             }">
                    Destroy
                </a>

                <form id="delete-form-{{ $item->id }}" action="{{ route('media-library.destroy', $item->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach

    </table>
    @endif

    @if ($type == 'create')
    <h1>Create</h1>
    <form action="{{route('media-library.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="">Title :</label><br>
        <input type="text" name="title" value="">
        <br>
        <br>
        <label for="">Information :</label>
        <br>
        <input type="text" name="information" value="">
        <br>
        <br>
        <label for="">Description :</label>
        <br>
        <textarea name="description" id="" cols="30" rows="10" value=""></textarea>
        <br>
        <br>
        <input type="file" name="media-files" id="">
        <br>
        <br>
        <button type="submit">Store</button>
    </form>
    @endif

    @if ($type == 'edit')
    <h1>Edit</h1>
    <form action="{{route('media-library.update', $medialibrary->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <label for="">Title :</label><br>
        <input type="text" name="title" value="{{$medialibrary->title}}">
        <br>
        <br>
        <label for="">Information :</label>
        <br>
        <input type="text" name="information" value="{{$medialibrary->information}}">
        <br>
        <br>
        <label for="">Description :</label>
        <br>
        <textarea name="description" id="" cols="30" rows="10" value="">{{$medialibrary->description}}</textarea>
        <br>
        <br>
        {{-- Image --}}

        @switch($extensions)
        @case('jpg')
        <img src="{{Storage::url($medialibrary->media_files)}}" alt="" srcset="">
        @break
        @case('png')
        <img src="{{Storage::url($medialibrary->media_files)}}" alt="" srcset="">
        @break
        @case('jpeg')
        <img src="{{Storage::url($medialibrary->media_files)}}" alt="" srcset="">
        @break
        @case('mp4')
        <h5>{{$basename}}</h5>
        @break

        @case('mp3')
        <h5>{{$basename}}</h5>
        @break
        @case('pdf')
        <h5>{{$basename}}</h5>
        @break
        @default

        @endswitch

        <br>
        <br>
        <button type="submit">Store</button>
    </form>
    @endif


    @if (isset($errors))
    <pre>{{$errors}}</pre>
    @endif

</div>

@extends('layouts.app')

@section('content')


<div class="container-xl">
    <div class="row mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Messages</th>
                    <th scope="col">Apartment</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Message</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($messages as $message)
                <tr>
                    <th scope="row">
                        {{ $message->id }}
                        <form action="{{ route('message.destroy', $message->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button id="deleteButton" class="btn btn-danger mt-2">Elimina</button>
                    </form>
                    </th>
                    <td>
                        @foreach($apartments as $apartment)
                            @if($message->apartment_id == $apartment->id)
                                {{ $apartment->title }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->email_body }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('deleteButton').onclick = function() {
        
    };
</script>

@endsection
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
                        {{ $message->created_at }}
                        <button class="btn btn-danger mt-2 deleteButton" data-message-id="{{ $message->id }}">Elimina</button>
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

<div class="modal" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conferma eliminazione</h5>
            </div>
            <div class="modal-body">
                Sei sicuro di voler eliminare questo messaggio?
            </div>
            <div class="modal-footer">
                <button id="annulla" type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Elimina</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Aggiungi un gestore per il clic del pulsante di eliminazione
    const deleteButtons = document.querySelectorAll('.deleteButton');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Impedisci l'azione predefinita di inviare il form
            event.preventDefault();

            // Salva l'ID del messaggio associato al pulsante di eliminazione
            const messageId = button.dataset.messageId;

            // Aggiungi l'ID del messaggio al modal di conferma
            document.getElementById('confirmDeleteButton').dataset.messageId = messageId;

            // Apri il modal di conferma
            $('#confirmDeleteModal').modal('show');
        });
    });

    // Aggiungi un gestore per il clic del pulsante di conferma nell'interno del modal
    document.getElementById('confirmDeleteButton').onclick = function() {
        // Recupera l'ID del messaggio dal pulsante di conferma nel modal
        const messageId = this.dataset.messageId;

        // Costruisci l'URL del form di eliminazione
        const deleteFormUrl = '{{ route("message.destroy", ":id") }}';
        const url = deleteFormUrl.replace(':id', messageId);

        // Invia il form di eliminazione
        const deleteForm = document.createElement('form');
        deleteForm.method = 'POST';
        deleteForm.action = url;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        deleteForm.appendChild(csrfInput);
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        deleteForm.appendChild(methodInput);
        document.body.appendChild(deleteForm);
        deleteForm.submit();
    };

    document.getElementById('annulla').onclick = function() {

        location.reload();
        
    }
</script>

@endsection
<table class="table table-bordered table-borderless">
    <thead>
    <tr>
        <th class="text-center">Nombre</th>
        <th class="text-center">Cédula</th>
        <th class="text-center">Teléfono</th>
        <th class="text-center">E-Mail</th>
        <th class="text-center">Acciones</th>
    </tr>
    </thead>
    <tbody>
        @forelse ($clients as $client)
            <tr>
                <td class="text-center align-middle"><a href="{{ route('client.details', $client->id_number) }}"><b>{{ $client->name }}</b></a></td>
                <td class="text-center align-middle">{{ $client->id_number }}</td>
                <td class="text-center align-middle">{{ $client->telephone }}</td>
                <td class="text-center align-middle">{{ $client->email }}</td>
                <td class="text-center align-middle">@include('modules.clients.partials.actionButtons')</td>
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="5"><h4>No hay clientes para mostrar.</h4></td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th class="text-center">Nombre</th>
        <th class="text-center">Cédula</th>
        <th class="text-center">Teléfono</th>
        <th class="text-center">E-Mail</th>
        <th class="text-center">Acciones</th>
    </tr>
    </tfoot>
</table>
<div class="float-right">
    {{ $clients->render() }}
</div>
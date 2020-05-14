
{{ Form::open(['url' => 'clientes/'.$id, 'method' => 'delete', 'id'=>'formelim-'.$id]) }}
<a href="{{route('client.details', $id_number) }}" data-tooltip="tooltip"
   data-placement="left" title="Ver detalles del cliente" class="btn btn-light btn-sm">
    <span class="fa fa-eye"></span>
</a>
@can('manageClients', \App\User::class)
    <a href="{{route('clients.edit', $id) }}" data-tooltip="tooltip"
       data-placement="top" title="Editar" class="btn btn-blue btn-sm">
        <span class="fa fa-pencil"></span>
    </a>
    <button type="button" onclick="alertElim('{{$id}}')"
            class="btn btn-danger btn-sm"
            data-tooltip="tooltip" data-placement="right" title="Eliminar">
        <span class="fa fa-times"></span>
    </button>
@endcan
{{ Form::close() }}
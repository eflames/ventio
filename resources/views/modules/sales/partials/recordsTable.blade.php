<table class="table table-striped table-bordered table-borderless">
    <thead>
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Cliente</th>
        <th class="text-center">Fecha</th>
        <th class="text-center">Artículos</th>
        <th class="text-center">Monto</th>
        <th class="text-center">Status</th>
        <th class="text-center">Acciones</th>
    </tr>
    </thead>
    <tbody>
        @forelse ($sales as $sale)
            <tr>
                <td class="text-center align-middle"><a href="{{ route('sale.view', base64_encode($sale->id)) }}">{{ $sale->id }}</a></td>
                <td class="text-center align-middle"><strong><a href="{{ route('client.details', $sale->client->id_number) }}">{{ $sale->client->name }}</a></strong></td>
                <td class="text-center align-middle">{{ $sale->closed_at ? $sale->closed_at->format('d/m/Y') : 'Ver detalle' }}</td>
                <td class="text-center align-middle">{{ $sale->details->sum('qty') }}</td>
                <td class="text-center align-middle"><strong>${{ number_format($sale->amount, 2) }}</strong></td>
                <td class="text-center align-middle">
                    <div class="badge @if( $sale->status->name == 'Incompleto') badge-warning @else badge-success @endif">
                        {{ $sale->status->name }}
                    </div>
                </td>
                <td class="text-center">@include('modules.sales.partials.actionButton')</td>
            </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center"><h4>No hay ventas registradas.</h4></td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Cliente</th>
        <th class="text-center">Fecha</th>
        <th class="text-center">Artículos</th>
        <th class="text-center">Monto</th>
        <th class="text-center">Status</th>
        <th class="text-center">Acciones</th>
    </tr>
    </tfoot>
</table>
<div class="float-right">
    {{ $sales->render() }}
</div>
<table class="table table-striped table-borderless table-success">
    <thead>
    <tr>
        <th class="text-center">Identificador</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Disponible</th>
        <th class="text-center">Almacén</th>
        <th class="text-center">Precio venta</th>
        <th class="text-center">Precio costo</th>
        <th class="text-center" >Acciones</th>
    </tr>
    </thead>
    <tbody>
        @forelse ($stock as $item)
            <tr>
                <td class="text-center align-middle">{{ $item->product->identifier }}</td>
                <td class="text-center align-middle"><strong>{{ $item->product->name }}</strong></td>
                <td class="text-center align-middle">
                    @if($item->qty == 0)
                        <div class="badge badge-md badge-danger"><strong>{{ $item->qty }}</strong></div>
                    @elseif($item->qty <= $item->min_stock)
                        <div class="badge badge-md badge-warning"><strong>{{ $item->qty }}</strong></div>
                    @else
                        <div class="badge badge-md badge-success"><strong>{{ $item->qty }}</strong></div>
                    @endif
                </td>
                <td class="text-center align-middle">{{ $item->warehouse->name }}</td>
                <td class="text-center align-middle">${{ number_format($item->price, 2) }}</td>
                <td class="text-center align-middle">${{ number_format($item->cost_price, 2) }}</td>
                @include('modules.stock.partials.actionButtons')

            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center"><h4>No hay productos para mostrar.</h4></td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th class="text-center">Identificador</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Disponible</th>
        <th class="text-center">Almacén</th>
        <th class="text-center">Precio venta</th>
        <th class="text-center">Precio costo</th>
        <th class="text-center">Acciones</th>
    </tr>
    </tfoot>
</table>
<div class="float-right">
    {!! $stock->render() !!}
</div>
<div class="row mt-3">
    <div class="col-12">
        Leyenda: <span class="text-success">Stock correcto</span> | <span class="text-warning">Stock por debajo del mínimo</span> | <span class="text-danger">Stock agotado</span>
    </div>
    
</div>
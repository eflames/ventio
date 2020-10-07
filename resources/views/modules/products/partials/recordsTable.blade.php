
<table class="table table-striped table-bordered table-borderless">
    <thead>
    <tr>
        <th>Identificador</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th class="text-center">Acciones</th>
    </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <td class="align-middle">{{ $product->identifier }}</td>
                <td class="align-middle">{{ $product->name }}</td>
                <td class="align-middle">{{ $product->category->name }}</td>
                <td class="align-middle text-center">
                    @include('modules.products.partials.actionButton')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center align-middle"><h4>No hay productos que mostrar.</h4></td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th>Identificador</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th class="text-center">Acciones</th>
    </tr>
    </tfoot>
</table>
<div class="float-right">
    {{ $products->render() }}
</div>
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
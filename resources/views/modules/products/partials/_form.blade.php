<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/8/2019
 * Time: 1:53 AM
 */?>

<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="identifier" class="filled">Identificador: <span class="text-danger">*</span></label>
            {{ Form::text('identifier', null, ['class' => 'form-control', 'placeholder' => 'SKU, EAN (Sitúe el curso en este campo y use la pistola)', 'required' => true, 'autofocus' => true]) }}
            @if ($errors->has('identifier'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('identifier') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Nombre: <span class="text-danger">*</span></label>
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @if ($errors->has('name'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('name') }}</small></p>
            @endif
        </fieldset>
    </div>
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="product_category_id" class="filled">Categoría: <span class="text-danger">*</span></label></label>
            {{ Form::select('product_category_id', [''=>'Seleccione categoría...'] + $categories->toArray(), null, ['class' => 'form-control', 'id' => 'selectOpt']) }}
            @if ($errors->has('product_category_id'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('product_category_id') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="description" class="filled">Descripción:</label>
            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
            @if ($errors->has('description'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('description') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row pt-4">
    <div class="col-12 text-center">
        <a href="{{ route('products.list') }}" class="btn btn-grey btn-lg">
            <span class="fa fa-times"></span> Cancelar
        </a>
        <button type="submit" class="btn btn-green btn-lg ld-ext-right">
            <span class="fa fa-check"></span> Guardar <div class="ld ld-ring ld-spin"></div>
        </button>
    </div>
</div>

@extends('shop::base')

@section('pius_header')
    <title>{{ __( 'Checkout') }}</title>
    <?= $piheader['checkout/standard'] ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
@stop

@section('pius_nav')
    <?= $pibody['catalog/tree'] ?? '' ?>
    <?= $pibody['catalog/search'] ?? '' ?>
@stop

@section('pius_body')
    <div class="container-fluid">
        <?= $pibody['checkout/standard'] ?>
    </div>
@stop

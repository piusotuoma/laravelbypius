@extends('shop::base')

@section('pius_header')
    <title>{{ __( 'Thank you') }}</title>
    <?= $piheader['checkout/confirm'] ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
@stop

@section('pius_nav')
    <?= $pibody['catalog/tree'] ?? '' ?>
    <?= $pibody['catalog/search'] ?? '' ?>
@stop

@section('pius_body')
    <div class="container-fluid">
        <?= $pibody['checkout/confirm'] ?>
    </div>
@stop

@extends('shop::base')

@section('pius_header')
    <title>{{ __( 'Basket') }}</title>
    <?= $piheader['locale/select'] ?? '' ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
    <?= $piheader['basket/bulk'] ?? '' ?>
    <?= $piheader['basket/standard'] ?? '' ?>
    <?= $piheader['basket/related'] ?? '' ?>
@stop

@section('pius_head_nav')
    <?= $pibody['catalog/tree'] ?? '' ?>
@stop

@section('pius_head_locale')
    <?= $pibody['locale/select'] ?? '' ?>
@stop

@section('pius_head_search')
    <?= $pibody['catalog/search'] ?? '' ?>
@stop

@section('pius_body')
    <div class="container-fluid">
        <?= $pibody['basket/standard'] ?? '' ?>
        <?= $pibody['basket/related'] ?? '' ?>
        <?= $pibody['basket/bulk'] ?? '' ?>
    </div>
@stop

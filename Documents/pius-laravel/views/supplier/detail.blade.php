@extends('shop::base')

@section('pius_header')
    <?= $piheader['supplier/detail'] ?>
    <?= $piheader['locale/select'] ?? '' ?>
    <?= $piheader['basket/mini'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/lists'] ?? '' ?>
@stop

@section('pius_head_basket')
    <?= $pibody['basket/mini'] ?? '' ?>
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
        <?= $pibody['supplier/detail'] ?>
        <?= $pibody['catalog/lists'] ?? '' ?>
    </div>
@stop

@extends('shop::base')

@section('pius_header')
    <?= $piheader['locale/select'] ?? '' ?>
    <?= $piheader['basket/mini'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/stage'] ?? '' ?>
    <?= $piheader['catalog/detail'] ?? '' ?>
    <?= $piheader['catalog/session'] ?? '' ?>
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

@section('pius_stage')
    <?= $pibody['catalog/stage'] ?? '' ?>
@stop

@section('pius_body')
    <?= $pibody['catalog/detail'] ?? '' ?>
    <?= $pibody['cms/page'] ?? '' ?>
@stop

@section('pius_aside')
    <?= $pibody['catalog/session'] ?? '' ?>
@stop

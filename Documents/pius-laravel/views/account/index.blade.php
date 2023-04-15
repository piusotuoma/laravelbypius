@extends('shop::base')

@section('pius_header')
    <title>{{ __( 'Profile') }}</title>
    <?= $piheader['locale/select'] ?? '' ?>
    <?= $piheader['basket/mini'] ?? '' ?>
    <?= $piheader['account/profile'] ?? '' ?>
    <?= $piheader['account/review'] ?? '' ?>
    <?= $piheader['account/subscription'] ?? '' ?>
    <?= $piheader['account/basket'] ?? '' ?>
    <?= $piheader['account/history'] ?? '' ?>
    <?= $piheader['account/favorite'] ?? '' ?>
    <?= $piheader['account/watch'] ?? '' ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/session'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
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
        <?= $pibody['account/profile'] ?? '' ?>
        <?= $pibody['account/review'] ?? '' ?>
        <?= $pibody['account/subscription'] ?? '' ?>
        <?= $pibody['account/basket'] ?? '' ?>
        <?= $pibody['account/history'] ?? '' ?>
        <?= $pibody['account/favorite'] ?? '' ?>
        <?= $pibody['account/watch'] ?? '' ?>
    </div>
@stop

@section('pius_aside')
    <?= $pibody['catalog/session'] ?>
@stop

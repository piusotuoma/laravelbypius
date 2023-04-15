@extends('shop::base')

@section('pius_header')
    <?= $piheader['locale/select'] ?? '' ?>
    <?= $piheader['basket/mini'] ?? '' ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/filter'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
    <?= $piheader['catalog/stage'] ?? '' ?>
    <?= $piheader['catalog/session'] ?? '' ?>
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
    <?= $pibody['catalog/stage'] ?? '' ?>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-3">
                <?= $aibody['catalog/filter'] ?? '' ?>
                <?= $aibody['catalog/session'] ?? '' ?>
            </aside>
            <div class="col-lg-9">
                <?= $aibody['catalog/lists'] ?>
            </div>
        </div>
    </div>
@stop

@extends('shop::base')

@section('pius_header')
    <?= $piheader['locale/select'] ?? '' ?>
    <?= $piheader['basket/mini'] ?? '' ?>
    <?= $piheader['catalog/search'] ?? '' ?>
    <?= $piheader['catalog/filter'] ?? '' ?>
    <?= $piheader['catalog/tree'] ?? '' ?>
    <?= $piheader['catalog/session'] ?? '' ?>
    <?= $piheader['catalog/stage'] ?? '' ?>
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

@section('pius_stage')
    <?= $pibody['catalog/stage'] ?? '' ?>
@stop

@section('pius_body')
    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-3">
                <?= $pibody['catalog/filter'] ?? '' ?>
                <?= $pibody['catalog/session'] ?? '' ?>
            </aside>
            <div class="col-lg-9">
                <?= $pibody['catalog/lists'] ?? '' ?>
                <?= $pibody['cms/page'] ?? '' ?>
            </div>
        </div>
    </div>
@stop

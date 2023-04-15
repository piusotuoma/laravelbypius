@extends('shop::base')

@section('pius_header')
	<?= $piheader['catalog/tree'] ?? '' ?>
	<?= $piheader['basket/mini'] ?? '' ?>
    <?= $piheader['cms/page'] ?? '' ?>
@stop

@section('pius_nav')
	<?= $pibody['catalog/tree'] ?? '' ?>
@stop

@section('pius_head')
	<?= $pibody['basket/mini'] ?? '' ?>
@stop

@section('pius_body')
    <div class="container-fluid">
		<?= $pibody['cms/page'] ?? '' ?>
	</div>
@stop

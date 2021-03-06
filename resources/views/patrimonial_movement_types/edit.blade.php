@extends('home')

@section('content')

	<div class="page-header text-primary">
	   	<h4>
	   		Administração - Movimentações Patrimônios > Tipos: Alteração
	   		<div class="btn-group btn-group-sm pull-right">
          		<a href="{!! route('patrimonial_movement_types.create') !!}" type="button" class="round round-sm hollow green" rel="tooltip" title="Incluir"><i class="fa fa-file-o"></i></a>
          		<a href="{!! route('patrimonial_movement_types') !!}" type="button" class="round round-sm hollow" rel="tooltip" title="Pesquisar"><i class="fa fa-search"></i></a>
        	</div>
	   		<hr class="hr-primary" />
	   	</h4>
	</div>

	{!! Form::model($patrimonial_movement_type, ['route' => ['patrimonial_movement_types.update', $patrimonial_movement_type->id], 'method' => 'put', 'class' => 'form-horizontal', 'role'=>'form']) !!}

	    @include('patrimonial_movement_types.form')

	{!! Form::close() !!}
	    
@endsection
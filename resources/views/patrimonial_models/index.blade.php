@extends('home')

@section('content')
	<div class="page-header text-primary">
	   	<h4>
	   		Administração - Modelos de Patrimônios
	   		<div class="btn-group btn-group-sm pull-right">
          		<a href="{!! route('patrimonial_models.create') !!}" type="button" class="round round-sm hollow green" rel="tooltip" title="Incluir"><i class="fa fa-file-o"></i></a>
        	</div>
	   		<hr class="hr-primary" />
	   	</h4>
	</div>
				
	<div class="table-responsive">
		<table class="table table-bordered table-striped" id="table_patrimonial_models" data-toggle="table" data-toolbar="#filter-bar" data-show-toggle="false" data-search="false" data-show-filter="true" data-show-columns="true" data-show-export="true" data-pagination="true" data-click-to-select="true" data-page-list="[10, 20, 50, 100, All]" data-toolbar="#filter-bar"> 
		    <thead>
		        <th data-width="1%" class="text-center">
		        	<a href="{!! route('patrimonial_models.create') !!}" type="button" class="round round-sm hollow green" rel="tooltip" title="Incluir"><i class="fa fa-file-o"></i></a>
		        </th>
		        <th data-width="2%">Código</th>
		        <th>Descrição</th>
		        <th data-width="1%" class="text-center">#</th>
		    </thead>
		    <tbody>
			    @foreach($patrimonial_models as $patrimonial_model)
			        <tr>
			            <td>
			                <a href="{!! route('patrimonial_models.edit', [$patrimonial_model->id]) !!}" type="button" class="round round-sm hollow blue"><i class="fa fa-edit"></i></a>
			            </td>
			            <td><a href="{!! route('patrimonial_models.show', [$patrimonial_model->id]) !!}">{!! $patrimonial_model->code !!}</a></td>
			            <td>{!! $patrimonial_model->description !!}</td>
			            <td>
			            	<a href="javascript:;" onclick="onDestroy('{!! route('patrimonial_models.destroy', [$patrimonial_model->id]) !!}')" id="link_delete" type="button" class="round round-sm hollow red"><i class="fa fa-trash-o text-danger"></i></a>
			            </td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>
@endsection
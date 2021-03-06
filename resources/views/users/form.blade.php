<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} ">
	<label for="name" class="col-lg-2 control-label">Usuário:</label>
	<div class="col-xs-11 col-sm-8 col-lg-2">
		<div class="input-group input-group-sm">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			{!! Form::text('name', $value = null, ['id'=>'name', 'class'=>'form-control']) !!}
		</div>
	</div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} ">
	<label for="email" class="col-lg-2 control-label">e-mail:</label>
	<div class="col-xs-11 col-sm-7 col-lg-3">
		<div class="input-group input-group-sm">
			<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
			{!! Form::text('email', $value = null, ['id'=>'email', 'class'=>'form-control']) !!}
		</div>
	</div>
</div>

<div class="form-group">
	<label for="submit" class="col-sm-2 control-label"></label>
		<div class="form-group col-sm-4">
			<button type="submit" class="btn btn-success">Confirmar <i class="fa fa-check"></i></button>
			<a href="{{ URL::previous() }}" class="btn btn-danger">Cancelar <i class="fa fa-times"></i></a>
		</div>
</div>



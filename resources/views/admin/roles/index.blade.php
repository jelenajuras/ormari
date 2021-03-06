@extends('layouts.admin')

@section('title', 'Roles')
<link rel="stylesheet" href="{{ URL::asset('css/user.css') }}"/>
@section('content')
    <div class="addUser">
		<button data-path="{{ route('roles.create') }}" 
			class="load-ajax-modal" role="button" data-toggle="modal" data-target="#myModal">
			<i class="far fa-plus-square"></i>create role
		</button>
	</div>
	<h5>Duplico proizvodnja - Permitions</h5>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>Naziv</th>
                            <th>Slug</th>
                            <th>Dozvole</th>
                            <th>Opcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr class="role">
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ implode(", ", array_keys($role->permissions)) }}</td>
                                <td>
                                    <button data-path="{{ route('roles.edit', $role->id) }}" 
									class="load-ajax-modal" role="button" data-toggle="modal" data-target="#myModal">
									<i class="far fa-edit"></i> 
									</button>
									<!--<a href="{{ route('roles.edit', $role->id) }}" class="btn btn-default btn md" id="button">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        Ispravi
                                    </a>
                                    <a href="{{ route('roles.destroy', $role->id) }}" class="btn btn-danger btn-md action_confirm" data-method="delete" data-token="{{ csrf_token() }}" id="button">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        Obriši
                                    </a>-->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

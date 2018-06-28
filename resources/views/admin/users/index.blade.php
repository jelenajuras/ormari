@extends('layouts.admin')

@section('title', 'Users')

@section('content')
	<div class="addUser">
			<!-- Trigger/Open The Modal -->
			<button data-path="{{ route('users.create') }}" 
			   class="load-ajax-modal" role="button" data-toggle="modal" data-target="#dynamic-modal">
			    <i class="far fa-plus-square"></i>add user
			</button>
	</div>

        <h3>Users</h3>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table id="table_id" class="display">
					<thead>
						<tr>
							<th>Avatar</th>
							<th>Ime i prezime</th>
							<th>Tvrtka</th>
							<th>email</th>
							<th>Telefon</th>
							<th>Uloge</th>
							<th>Opcije</th>
						</tr>
					</thead>
					<tbody id="myTable">
						@foreach ($users as $user)
						@if($user->productionProject_id)
						<?php 
							$proj = $user->productionProject_id;
							$kupac = DB::table('projects')->join('customers','projects.investitor_id','customers.id')->select('projects.*','customers.naziv as tvrtka')->where('projects.id','=', $proj)->first();
							$kupac = $kupac->tvrtka;
							?>
						@else
							<?php $kupac=null; ?>
						@endif
							<tr>
								<td><img src="//www.gravatar.com/avatar/{{ md5($user->email) }}?d=mm" alt="{{ $user->email }}" class="img-circle"></td>
								<td>{{ $user->first_name . " ". $user->last_name }}</td>
								<td>{{ $kupac }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->telefon }}</td>
								<!--<td>{{ $user->department['name'] }}</td>-->
								<td>@if ($user->roles->count() > 0)
									{{ $user->roles->implode('name', ', ') }}
								@else
									<em>No Assigned Role</em>
								@endif</td>

								<td>
									<button data-path="{{ route('users.edit', $user->id) }}" 
									class="load-ajax-modal" role="button" data-toggle="modal" data-target="#dynamic-modal">
									<i class="far fa-edit"></i>edit 
									</button>
									
									<!--<a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-md action_confirm" data-method="delete" data-token="{{ csrf_token() }}" id="button">
										<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										Obriši
									</a>-->
								</td>
								
							</tr>
						@endforeach
						<script>
							$(document).ready(function(){
							  $("#myInput").on("keyup", function() {
								var value = $(this).val().toLowerCase();
								$("#myTable tr").filter(function() {
								  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
								});
							  });
							});
						</script>
					</tbody>
                </table>
			</div>
        </div>
    </div>

@stop

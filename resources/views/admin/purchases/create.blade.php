@extends('layouts.admin')

@section('title', 'Priprema')
<style>
table {
	width:600px;
}
.padd1 td {
	padding: 5px;
	font-size:0.75rem
}
.btn {
	width: 150px;
	margin: auto;
}
</style>
@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <br/>
		<h3 class="panel-title">Upiši status nabave</h3>
		<br/>
		<div class="panel panel-default">
            <div class="panel-body">
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('admin.purchases.store') }}">
				<fieldset>
                    <label>Ormar: {{ $cabinet->brOrmara . ' ' . $cabinet->naziv }}</label>
					<input type="hidden" name="ormar_id" value="{{ $idOrmara }}"/>
					<div>
					
					</div>
					<div class="form-group">
						<table>
							<div class="form-group">
							<tr class="padd1">
								<?php $datum_1 = new DateTime($cabinet->datum_isporuke);
								$datum_1->modify('-3 days')?>
								<td>Datum isporuke stavaka ormara:</td>
								<td><input name="datum" class="date form-control" type="text"  value = "{{ $datum_1->format('d-m-Y') }}"></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno1" type="radio" value="DA" />DA <input name="rijeseno1" type="radio" value="NE" checked />NE </td>
								<td>Ormar</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_orm" type="text" value="{{ old('koment_orm') }}" /></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno2" type="radio" value="DA" />DA <input name="rijeseno2" type="radio" value="NE" checked />NE </td>
								<td>Kanalice</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_kan" type="text" value="{{ old('koment_kan') }}" /></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno3" type="radio" value="DA" />DA <input name="rijeseno3" type="radio" value="NE" checked />NE </td>
								<td>Din šine</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_sine" type="text" value="{{ old('koment_sine') }}" /></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno4" type="radio" value="DA" />DA <input name="rijeseno4" type="radio" value="NE" checked />NE </td>
								<td>Vodič</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_vod" type="text" value="{{ old('koment_vod') }}" /></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno5" type="radio" value="DA" />DA <input name="rijeseno5" type="radio" value="NE" checked />NE </td>
								<td>Bakar</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_bak" type="text" value="{{ old('koment_bak') }}" /></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno6" type="radio" value="DA" />DA <input name="rijeseno6" type="radio" value="NE" checked />NE </td>
								<td>Redne stezaljke</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_stez" type="text" value="{{ old('koment_stez') }}" /></td>
							</tr>
							<tr class="padd1">
								<td><input name="rijeseno7" type="radio" value="DA" />DA <input name="rijeseno7" type="radio" value="NE" checked />NE </td>
								<td>Sklopna oprema</td>
								<td><input class="form-control" placeholder="Upiši komentar" name="koment_sklOpr" type="text" value="{{ old('koment_sklOpr') }}" /></td>
							</tr>
							<script type="text/javascript">
								$('.date').datepicker({  
								   format: 'dd-mm-yyyy',
								   startDate:'-60y',
								   endDate:'+1y'
								}); 
							</script> 
						</table>
                    </div>
					
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn-default btn pull-right" type="submit" value="Upiši">
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@extends('layouts.dn')

@section('page_title')
	<table class="table table-borderless">
		<tr>
			<td><div class="page-title-icon f32"><i class="fas fa-info"></i></div></td>
			<td class="top text-end align-text-top p-2"><strong>@lang('Server Info')</strong><br><small>{{ $server->rootDSE()->entryuuid[0] ?? '' }}</small></td>
		</tr>
	</table>
@endsection

@section('main-content')
	<div class="main-card mb-3 card">
		<div class="card-body">
			<table class="table">
				@foreach($server->rootDSE()->getObjects() as $attribute => $ao)
					<tr>
						<th class="w-25">
							{!! ($x=$server->schema('attributetypes',$attribute))
								? sprintf('<a class="attributetype" id="strtolower(%s)" href="%s">%s</a>',$x->name_lc,url('schema/attributetypes',$x->name_lc),$x->name)
								: $attribute !!}
						</th>
						<td>
							@if($ao instanceof \App\Classes\LDAP\Attribute\Schema\OID)
								<x-attribute :edit="false" :o="$ao"/>
							@else
								{!! $ao->values_old->dot()->join('<br>') !!}
							@endif
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
@endsection
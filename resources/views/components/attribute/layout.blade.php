<div class="row pt-2">
	<div class="col-10 offset-1">
		<attribute id="{{ $o->name_lc }}">
			{{ $slot }}
		</attribute>

		<x-attribute.widget.options :o="$o" :edit="$edit" :new="$new" :template="$template ?? FALSE"/>
	</div>
</div>

@yield($o->name_lc.'-scripts')
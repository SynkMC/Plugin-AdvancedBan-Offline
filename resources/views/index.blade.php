@extends('layouts.app')

@section('title', trans('advancedban::messages.title'))

@section('content')
    <div class="container content">
    	<h1>{{ trans('advancedban::messages.title') }}</h1>

		<div class="table-wrapper table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col">{{ trans('messages.fields.type') }}</th>
						<th scope="col">{{ trans('advancedban::messages.username') }}</th>
						<th scope="col">{{ trans('advancedban::messages.reason') }}</th>
						<th scope="col">{{ trans('advancedban::messages.staff') }}</th>
						<th scope="col">{{ trans('messages.fields.date') }}</th>
						<th scope="col">{{ trans('advancedban::messages.expires_at') }}</th>
						<th scope="col" class="text-right">{{ trans('messages.fields.status') }}</th>
					</tr>
				</thead>
				<tbody>
					@forelse(array_map('json_decode', array_unique(array_map('json_encode',
						array_merge($PunishmentHistory, $Punishments)
						))) as $punishment)
						<tr class="text-nowrap">
							<td>{{ $punishment->punishmentType }}</td>
							<td><img src="https://crafthead.net/avatar/{{ $punishment->uuid }}/30"> {{ $punishment->name }}</td>
							<td>{{ $punishment->reason }}</td>
							<td><img data-name="{{ $punishment->operator }}" src="https://crafthead.net/avatar/8667ba71-b85a-4004-af54-457a9734eed7/30"> {{ $punishment->operator }}</td>
							<td>{{ format_date(Carbon\Carbon::createFromTimestampMs($punishment->start)) }} <span class="badge badge-info">{{ strftime('%H:%M', $punishment->start / 1000) }}</span></td>
							<td>
								@if($punishment->end != -1)
									{{ format_date(Carbon\Carbon::createFromTimestampMs($punishment->end)) }}
									<span class="badge badge-info">{{ strftime('%H:%M', $punishment->end / 1000) }}</span>
								@else
									N/A
								@endif
							</td>
							<td class="text-right">
								@if(in_array($punishment, $Punishments) && $punishment->end < time())
									{{ trans('advancedban::messages.active') }}
								@else
									{{ trans('advancedban::messages.finished') }}
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="7">{{ trans('advancedban::messages.no_punishments_found') }}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		window.addEventListener('load', function() {
			var links = document.getElementsByTagName("img");    
			var linksArr = Array.from(links);

			linksArr.forEach(function(element) {
				let name = element.getAttribute('data-name');
				if(name === null) return;

				profile.setAttribute('src', 'https://crafthead.net/avatar/' + name + '/30');
			});
		})
	</script>
@endpush

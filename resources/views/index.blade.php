@extends('layouts.app')

@section('title', trans('advancedban::messages.title'))

@section('content')
    <div>
        <div class="row">
            <div class="col">
                <h1>{{ trans('advancedban::messages.title') }}</h1>
            </div>

            <div class="col">
                <form class="mb-3 float-end" action="{{ route('advancedban.index') }}" method="GET">
                    <div class="mb-2">
                        <label for="searchInput" class="form-label sr-only">{{ trans('messages.actions.search') }}</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" name="q"
                                value="{{ request()->input('q') }}"
                                placeholder="{{ trans('messages.actions.search') }}">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                    @forelse ($allPunishments as $punishment)
                        <tr class="text-nowrap">
                            <td>{{ $punishment->punishmentType }}</td>
                            <td><img src="https://crafthead.net/avatar/{{ $punishment->uuid }}/30">
                                {{ $punishment->name }}</td>
                            <td>{{ $punishment->reason }}</td>
                            <td><img data-name="{{ $punishment->operator }}"
                                    src="https://crafthead.net/avatar/8667ba71-b85a-4004-af54-457a9734eed7/30">
                                {{ $punishment->operator }}</td>
                            <td>{{ format_date(Carbon\Carbon::createFromTimestampMs($punishment->start)) }} <span
                                    class="badge bg-info">{{ strftime('%H:%M', $punishment->start / 1000) }}</span></td>
                            <td>
                                @if ($punishment->end != -1)
                                    {{ format_date(Carbon\Carbon::createFromTimestampMs($punishment->end)) }}
                                    <span class="badge bg-info">{{ strftime('%H:%M', $punishment->end / 1000) }}</span>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($punishments->contains($punishment) && time() < $punishment->end / 1000)
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

            {{ $allPunishments->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            var links = document.querySelectorAll("img");

            links.forEach(function(element) {
                let name = element.getAttribute('data-name');
                if (name === null) return;

                element.setAttribute('src', 'https://crafthead.net/avatar/' + name + '/30');
            });
        })
    </script>
@endpush

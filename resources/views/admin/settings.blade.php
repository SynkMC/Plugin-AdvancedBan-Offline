@extends('admin.layouts.admin')

@section('title', trans('advancedban::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            <form action="{{ route('advancedban.admin.settings') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="host">{{ trans('advancedban::admin.settings.host') }}</label>
                    <input class="form-control" id="host" name="host" value="{{ $host }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="port">{{ trans('advancedban::admin.settings.port') }}</label>
                    <input class="form-control" id="port" name="port" value="{{ $port }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="database">{{ trans('advancedban::admin.settings.database') }}</label>
                    <input class="form-control" id="database" name="database" value="{{ $database }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="username">{{ trans('advancedban::admin.settings.username') }}</label>
                    <input class="form-control" id="username" name="username" value="{{ $username }}" required="required">
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="password">{{ trans('advancedban::admin.settings.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ $password }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="perPage">{{ trans('advancedban::admin.settings.perPage') }}</label>
                    <input type="number" min="1" max="100" class="form-control" id="perPage" name="perPage" value="{{ $perPage }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="historyTable">{{ trans('advancedban::admin.settings.historyTable') }}</label>
                    <input type="text" class="form-control" id="historyTable" name="historyTable" value="{{ $historyTable }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="punishmentTable">{{ trans('advancedban::admin.settings.punishmentTable') }}</label>
                    <input type="text" class="form-control" id="punishmentTable" name="punishmentTable" value="{{ $punishmentTable }}" required="required">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="route">{{ trans('advancedban::admin.settings.route') }}</label>
                    <input type="text" class="form-control" id="route" name="route" value="{{ $route }}" required="required">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

            </form>

        </div>
    </div>
@endsection

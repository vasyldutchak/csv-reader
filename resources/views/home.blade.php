@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <div class="row justify-content-md-center">

            <div class="col-6">

                @if(isset($created) && isset($updated) && isset($deleted))
                    <div class="alert alert-success">
                       <span>
                           Created: <strong>{{$created}}</strong>;
                        </span>

                        <span>
                            Updated: <strong>{{$updated}}</strong>;
                        </span>

                        <span>
                            Deleted: <strong>{{$deleted}}</strong>;
                        </span>
                    </div>
                @endif

                <div class="card">

                    <div class="card-header">
                        Import data
                    </div>

                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ url('/') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="col-4 control-label">CSV file to import</label>

                                <div class="col-4">
                                    <input id="csv_file" type="file" class="form-control float-left" name="csv_file"
                                           required
                                           accept=".csv">
                                </div>
                                <div class="col-4 float-right">
                                    <button type="submit" class="btn btn-primary">
                                        Parse CSV
                                    </button>
                                </div>

                                @if ($errors->has('csv_file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('csv_file') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>


        <div class="row justify-content-md-center">
            <div class="col-6">
                <table class="table table-hover">

                    <thead class="thead-dark">
                    <tr class="light">
                        <th scope="col">#</th>
                        <th scope="col">UID</th>
                        <th scope="col">firstName</th>
                        <th scope="col">lastName</th>
                        <th scope="col">birthDay</th>
                        <th scope="col">dateChange</th>
                        <th scope="col">description</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($allRecords as $record)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $record->uid }}</td>
                            <td>{{ $record->firstname }}</td>
                            <td>{{ $record->lastname }}</td>
                            <td>{{ $record->birthday }}</td>
                            <td>{{ $record->datechange }}</td>
                            <td>{{ $record->desctiption }}</td>
                        </tr>
                    @empty
                        <span>There are not data</span>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
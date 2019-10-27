@extends('layout')

@section('content')
    <form method="POST" enctype="multipart/form-data" class="form-horizontal"
            action="{{ route('user.update', ['user'=>$user->id])}}">

        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{$user->image ? $user->image->url() : ''}}"
                    class="img-thumbnail avatar"/>

                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload a different photo</h6>
                        <input type="file" class="form-control-file" name="avatar">
                    </div>
                </div>

            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" class="form-control" value="" name="name">
                </div>

                <div class="form-group">
                    <label for="">Language:</label>
                    <select name="locale" class="form-control">
                        @foreach(App\User::LOCALES as $locale => $label)
                            <option value="{{$locale}}" {{$user->locale!=$locale ? : 'selected'}}>
                                {{$label}}
                            </option>
                        @endforeach
                    </select>
                </div>

                @errors @enderrors

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save Changes">
                </div>
            </div>
        </div>

    </form>
@endsection

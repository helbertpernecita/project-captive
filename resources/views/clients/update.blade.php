
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

<div class="card">
    <div class="card-body">
        <form action="{{route('clients.update', $client->id)}}" method="post">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-sm-8">
                        <label for="1" class="form-label ">NAME</label>
                        <input type="text" class="form-control" name="name" value="{{$client->name}}">
                </div>
                <div class="col-sm-4">
                    <label for="2" class="form-label">CODE</label>
                    <input type="text" class="form-control" name="code" value="{{$client->code}}">
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-5">
                    <label for="2" class="form-label ">BRSTN</label>
                    <input type="text" class="form-control" name="brstn" value="{{$client->brstn}}">
                </div>
                <div class="col-sm-7">
                    <label for="3" class="form-label ">BRANCH</label>
                    <input type="text" class="form-control" name="branch" value="{{$client->branch}}">
                </div>
            </div><br>
            <div class="row">
                <div class="col-sm-12">
                    <label for="3" class="form-label ">ADDRESS 1</label>
                    <input type="text" class="form-control" name="address" value="{{$client->address}}">
                </div>
            </div><br>
            <div class="row">
                <div class="col-sm-12">
                    <label for="4" class="form-label ">ADDRESS 2</label>
                    <input type="text" class="form-control" name="address1" value="{{$client->address1}}">
                </div>
            </div><br>
            <div class="row">

                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" @if (!$client->isActive)
                            checked
                        @endif>
                        <label class="form-check-label" for="defaultCheck1">Active</label>
                    </div>
                </div>
                <div class="col-sm-8 text-right">
                    <div>
                        <button type="submit" class="btn btn-sm btn-success float-right">SAVE UPDATE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

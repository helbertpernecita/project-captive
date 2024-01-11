<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BANK LIST') }}
        </h2>
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @php
                        $clients = App\Models\Client::all();
                        $count = 1;
                    @endphp
                    <div class="table table-responsive">
                        <table class="table text-nowrap text-truncate table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bank Name</th>
                                    <th>Code</th>
                                    <th>BRSTN</th>
                                    <th>Branch</th>
                                    <th>Address1</th>
                                    <th>Processed</th>
                                    <th>Last update by</th>
                                    <th class="text-center" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    @php
                                        $processCount = App\Models\Process\Process::where('client_id','=', $client->id)->count();
                                        $pending = App\Models\Process\Process::where('client_id','=', $client->id)->where('isProcessed','=',false)->count();
                                    @endphp
                                    <tr class="data-row @if($pending > 0) text-danger text-bold @endif">
                                        <td class="pl-3 text-center">{{ $count++ }}</td>
                                        <td class="pl-3">{{ $client->name }}</td>
                                        <td class="pl-3 text-center">{{ $client->code }}</td>
                                        <td class="pl-3 text-center">{{ $client->brstn }}</td>
                                        <td class="pl-3 text-center">{{ $client->branch }}</td>
                                        <td class="pl-3">{{ $client->address }}</td>
                                        <td class="pl-3 text-center">{{ ($processCount > 0 ? $processCount : '') }}</td>
                                        <td class="pl-3 text-center">{{ $client->user->name }} </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-start">
                                                <button type="button" data-id="{{$client->id}}" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-sm mx-1 editAccountBtn"><i class="fas fa-upload text-success"></i></button>
                                                <a href="{{ route('processes.index') }}" class="btn btn-sm mx-1"><i class="fas fa-eye text-primary"></i></a>
                                                @if ($processCount == 0)
                                                    <form action="{{route('clients.destroy', $client->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="if(!confirm('Are you sure, you want to delete this client? This cannot be reverse once confirmed.')){ event.preventDefault() }" class="btn btn-sm mx-1"><i class="fas fa-trash text-danger"></i></button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('clients.edit', $client->id) }}" data-name="{{$client->name}}" data-bs-toggle="modal" data-bs-target="#myEditModal" class="btn btn-sm mx-1 myEditModalBtn"><i class="fas fa-edit text-secondary"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Process docs for <strong id="modal-account-name" class="text-primary text-uppercase"></strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('processes.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <input type="file" name="file" id="fileId">
                        <input type="hidden" name="client_id" id="modal-account-id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Process</button>
            </div>
        </form>
    </div>
    </div>
  </div>

  <div class="modal fade" id="myEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update <strong id="dataName" class="text-primary text-uppercase"></strong> Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
    </div>
    </div>
  </div>



<script>
    $(document).ready(function() {
        $('.editAccountBtn').on('click', function() {
            var el = $(this);
            var dataId = $(this).data('id');
            var row = el.closest(".data-row");
            var accountName = row.find(".account-name").text();
            console.log(accountName);
            $("#modal-account-name").text(accountName);
            $("#modal-account-id").val(dataId);

            var options = { 'backdrop': 'static' };
            $('#editAccountModal').modal(options);
        });

    // On modal hide
        $('#editAccountModal').on('hide.bs.modal', function() {
            $("#edit-form").trigger("reset");
        });

        $('.myEditModalBtn').on('click', function() {
            var clientName = $(this).data('name');
            $("#dataName").text(clientName);
        });

        $('#myEditModal').bind("show.bs.modal", function(e){
            var link = $(e.relatedTarget);
            $(this).find(".modal-body").load(link.attr("href"));
        })

    });

</script>


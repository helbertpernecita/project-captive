<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BANK LIST') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $clients = App\Models\Client::all();
            @endphp
            <div class="table table-responsive">
                <table class="table table-sm table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Bank Name</th>
                            <th>Code</th>
                            <th>Branch</th>
                            <th>Address</th>
                            <th class="text-center" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="data-row">
                                <td class="pl-3 account-name">{{ $client->name }}</td>
                                <td class="pl-3">{{ $client->code }}</td>
                                <td class="pl-3">{{ $client->branch }}</td>
                                <td class="pl-3">{{ $client->address }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-start">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-sm mx-1 editAccountBtn"><i class="fas fa-plus text-success"></i></button>
                                        <a href="#" class="btn btn-sm mx-1"><i class="fas fa-eye text-primary"></i></a>
                                        <a href="#" class="btn btn-sm mx-1"><i class="fas fa-trash text-danger"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
h1
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Process docs for <strong id="modal-account-name" class="text-primary text-uppercase"></strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <input type="file" name="file" id="fileId">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary">Process</button>
            </div>
        </form>
    </div>
    </div>
  </div>


<script>
    $(document).ready(function() {
        $('.editAccountBtn').on('click', function() {
            var el = $(this);
            var row = el.closest(".data-row");
            var accountName = row.find(".account-name").text();
            console.log(accountName);
            $("#modal-account-name").text(accountName);

            var options = { 'backdrop': 'static' };
            $('#editAccountModal').modal(options);
        });

    // On modal hide
    $('#editAccountModal').on('hide.bs.modal', function() {
        $("#edit-form").trigger("reset");
    });
    });

</script>


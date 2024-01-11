<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Str::upper($client->name) }} - {{ __('PENDING PROCESSED LIST') }}
        </h2>
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="table table-responsive">
                        <table class="table table-sm table-bordered process-datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Check Type</th>
                                    <th>RT Number</th>
                                    <th>Account No.</th>
                                    <th>Account Name</th>
                                    <th>ContCode</th>
                                    <th>Form Type</th>
                                    <th>Quantity</th>
                                    <th>Processed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($processes as $process)
                                    <tr>
                                        <td colspan="10">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="text-primary">
                                                        <strong>Processed by: {{$process->user->name}}</strong>
                                                        <strong>({{$process->date}} - Batch {{$process->batch}})</strong>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 text-right">
                                                    <a href="{{route('processes.show', $process->id) }}" class="edit btn btn-danger btn-sm"><i class="fas fa-sm fa-download"></i> Print All</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($process->processDetails as $detail)
                                        <tr>
                                            <td class="text-center">{{$count++}}</td>
                                            <td class="text-center">{{$detail->check_type}}</td>
                                            <td>{{$detail->rt_number}}</td>
                                            <td >{{$detail->account_number}}</td>
                                            <td>{{$detail->account_name}}</td>
                                            <td class="text-center">{{$detail->contcode}}</td>
                                            <td class="text-center">{{$detail->form_type}}</td>
                                            <td class="text-center">{{$detail->quantity}}</td>
                                            <td class="text-center">{{($detail->isProcess ? 'Done' : 'Pending')}}</td>
                                            <td class="text-center">
                                                <a href="{{route('process_details.show', $detail->id) }}" class="edit btn btn-default btn-sm"><i class="fas fa-sm fa-download text-success"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <div class="jumbotron bg-success">
                                        <h1 class="text-center">NO PENDING PROCESS</h1>
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
<!-- Modal -->

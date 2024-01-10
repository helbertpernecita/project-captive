<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $chinaBankProcess->client->name }}
        </h2>
    </x-slot>
    <div class="card">
        @php
            $my_url = '/china_banks';
            $start_check = 1100500 + 1;
            $end_check = $start_check;
        @endphp
        <input type="hidden" id="myUrl" value="{{$my_url}}">
        <div class="card-body" id="yourElementId">



Page No. 1
01/02/2024
                    CBC - SUMMARY OF BLOCK - Commercial Pre-Encoded
                    (There should be a 3-characters prefix
                        printed before CHECK NUMBERS)

                Account Number is 12 Digits (4-2-5-1)

BLOCK RT_NO     ACCT_NO         START_NO.  END_NO.


** BLOCK 1
@for($i = 0; $i < $chinaBankProcess->quantity; $i++)
@php
$end_check += 100;
@endphp
        1 {{$chinaBankProcess->rt_number}} {{$chinaBankProcess->account_number}}    000{{$start_check}} 000{{$end_check}}
@php
$start_check += 100;
@endphp
@endfor





01022024                                      DLVR: 01-08(MON)
                      CBC0102CA.txt
A = 05
B = 05

Prepared By   : {{$chinaBankProcess->user->name}}
Updated By    : {{$chinaBankProcess->user->name}}                            RECHECKED BY:
Time Start    : 14:25
Time Finished :
File rcvd     :

        </div>
    </div>
</x-app-layout>
<!-- Modal -->

<script>
        // Get the data from your HTML
        var data = document.getElementById('yourElementId').innerHTML;

        // Create a Blob with the data
        var blob = new Blob([data], {type: 'text/plain;charset=utf-8'});

        var myUrl = document.getElementById('myUrl').value;
        console.log(myUrl);
        // Create an anchor element
        var url = window.URL.createObjectURL(blob);
        var downloadLink = document.createElement('a');
        downloadLink.href = url;
        downloadLink.download = 'BlockC.txt';

        // Append the anchor element to the body and click it to start the download
        document.body.appendChild(downloadLink);
        downloadLink.click();

        // Clean up by removing the link
        document.body.removeChild(downloadLink);

        window.onload = function() {
            window.location.href = myUrl;
        };

</script>

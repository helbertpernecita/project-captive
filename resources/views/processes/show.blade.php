    @include('includes.block-c')
    @include('includes.block-p')

@php
    $my_url = '/processes';
@endphp
<input type="hidden" id="myUrl" value="{{$my_url}}">
<script>
        // Get the data from your HTML
        var data = document.getElementById('yourElementId').innerHTML;
        var data2 = document.getElementById('yourElementId2').innerHTML;

        // Create a Blob with the data
        var blob = new Blob([data], {type: 'text/plain;charset=utf-8'});
        var blob2 = new Blob([data2], {type: 'text/plain;charset=utf-8'});

        // Create an anchor element
        var url = window.URL.createObjectURL(blob);
        var url2 = window.URL.createObjectURL(blob2);
        var downloadLink = document.createElement('a');
        var downloadLink2 = document.createElement('a');
        downloadLink.href = url;
        downloadLink2.href = url2;
        downloadLink.download = 'BlockC.txt';
        downloadLink2.download = 'BlockP.txt';

        // Append the anchor element to the body and click it to start the download
        document.body.appendChild(downloadLink);
        document.body.appendChild(downloadLink2);
        downloadLink.click();
        downloadLink2.click();

        // Clean up by removing the link
        document.body.removeChild(downloadLink);
        document.body.removeChild(downloadLink2);

     var myUrl = document.getElementById('myUrl').value;
    window.onload = function() {
        window.location.href = myUrl;
    };
</script>

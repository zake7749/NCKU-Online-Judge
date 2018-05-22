function sendRequest(codeMirror){

    url = "http://140.116.245.100:9487/api";

    request = {
        "language": $("#compile-language").val(),
        "code": codeMirror.getValue(),
    }

    console.log(request)
    console.log(JSON.stringify(request))

    $.ajax({
        type: 'get',
        url: url,
        data: request,
        dataType: 'json',
        success: function(result) {
            console.log("Success");
            console.log(result);
            console.log(result['memory']);
            $("#code-memory").html("memory usage: " + String(result['memory']));
            $("#code-out").html("output: " + String(result['output']));
            $("#code-result").html("result: " + String(result['result']));
            $("#code-vcpu").html("cpu time: " + String(result['cpu_time']));
            $("#code-realtime").html("real run time: " + String(result['real_time']));
            $("#code-error").html("error: " + String(result['error']));

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Failed");
            console.log(XMLHttpRequest.status);
        }
    });

}
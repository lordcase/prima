<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script src="http://yui.yahooapis.com/3.2.0/build/yui/yui-min.js"></script>        
        <script>
            // Create a YUI instance using io-base module.
            YUI().use("node", "event", "io-base", "dataschema", "datatype-date", function(Y) {
                Y.on('domready', function() {
                    var uri = "get.php?foo=bar";
                    var outputNode = Y.one('#output');

                    // Define a function to handle the response data.
                    function complete(id, o, args) {
                        var id = id; // Transaction ID.
                        var data = o.responseXML; // Response data.
                        var args = args[1]; // 'ipsum'.
                        
                        
                        var schema = {
                            metaFields : { code : "//code", message : '//message' },
                            resultListLocator : 'item',
                            resultFields : { name : "name", email : "email", status : "status" }
                        };
                        
                        var output = Y.DataSchema.XML.apply(schema, data);
                        
                        //alert(output.meta.code + ' - ' + output.meta.message);
                        outputNode.append("<pre>" + Y.DataType.Date.format(new Date(), { format : "%X" }) + ' ['+ output.meta.code + '] ' + output.meta.message + "</pre>");
                        if (output.meta.code != 2) {
                            Y.later(10000, Y, function() {
                                var request = Y.io(uri);
                            })
                        }
                    };

                    // Subscribe to event "io:complete", and pass an array
                    // as an argument to the event handler "complete", since
                    // "complete" is global.   At this point in the transaction
                    // lifecycle, success or failure is not yet known.
                    Y.on('io:complete', complete, Y, ['lorem', 'ipsum']);

                    // Make an HTTP request to 'get.php'.
                    // NOTE: This transaction does not use a configuration object.
                    var request = Y.io(uri);
                });
            });
        </script>
    </head>
    <body>
        <div  id="output"><h1>SENDING SIMULATOR</h1></div>
    </body>
</html>
